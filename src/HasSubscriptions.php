<?php

namespace Tithe;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use OutOfBoundsException;
use OverflowException;
use Tithe\Events\FeatureConsumed;

trait HasSubscriptions
{
    protected ?Collection $loadedFeatures = null;

    protected ?Collection $loadedSubscriptionFeatures = null;

    public function featureConsumptions()
    {
        return $this->morphMany(Tithe::featureConsumptionModel(), 'subscriber');
    }

    public function renewals()
    {
        return $this->hasManyThrough(
            Tithe::subscriptionRenewalModel(),
            Tithe::subscriptionModel(),
            'subscriber_id',
        );
    }

    public function subscription()
    {
        return $this->morphOne(Tithe::subscriptionModel(), 'subscriber')->ofMany('started_at', 'MAX');
    }

    public function lastSubscription()
    {
        return app(Tithe::subscriptionModel())
            ->withExpired()
            ->whereMorphedTo('subscriber', $this)
            ->orderBy('started_at', 'DESC')
            ->first();
    }

    /**
     * @throws OutOfBoundsException
     * @throws OverflowException
     */
    public function consume($featureName, ?float $consumption = null)
    {
        throw_if($this->missingFeature($featureName), new OutOfBoundsException(
            'None of the active plans grants access to this feature.',
        ));

        throw_if($this->cantConsume($featureName, $consumption), new OverflowException(
            'The feature has no enough charges to this consumption.',
        ));

        $feature = $this->getFeature($featureName);

        $featureConsumption = $feature->quota
            ? $this->consumeQuotaFeature($feature, $consumption)
            : $this->consumeNotQuotaFeature($feature, $consumption);

        event(new FeatureConsumed($this, $feature, $featureConsumption));
    }

    /**
     * @throws OutOfBoundsException
     * @throws OverflowException
     */
    public function setConsumedQuota($featureName, float $consumption)
    {
        throw_if($this->missingFeature($featureName), new OutOfBoundsException(
            'None of the active plans grants access to this feature.',
        ));

        throw_if($this->getTotalCharges($featureName) < $consumption, new OverflowException(
            'The feature has no enough charges to this consumption.',
        ));

        $feature = $this->getFeature($featureName);

        throw_unless($feature->quota, new InvalidArgumentException(
            'The feature is not a quota feature.',
        ));

        $featureConsumption = $this->featureConsumptions()
            ->whereFeatureId($feature->id)
            ->firstOrNew();

        if ($featureConsumption->consumption === $consumption) {
            return;
        }

        $featureConsumption->feature()->associate($feature);
        $featureConsumption->consumption = $consumption;
        $featureConsumption->save();

        event(new FeatureConsumed($this, $feature, $featureConsumption));
    }

    public function subscribeTo(Plan $plan, $expiration = null, $startDate = null): Model
    {
        $expiration = $expiration ?? $plan->calculateNextRecurrenceEnd($startDate);

        $graceDaysEnd = $plan->hasGraceDays
            ? $plan->calculateGraceDaysEnd($expiration)
            : null;

        return $this->subscription()
            ->make([
                'expired_at' => $expiration,
                'grace_days_ended_at' => $graceDaysEnd,
            ])
            ->plan()
            ->associate($plan)
            ->start($startDate);
    }

    public function hasSubscriptionTo(Plan $plan): bool
    {
        return $this->subscription()
            ->where('plan_id', $plan->id)
            ->exists();
    }

    public function isSubscribedTo(Plan $plan): bool
    {
        return $this->hasSubscriptionTo($plan);
    }

    public function missingSubscriptionTo(Plan $plan): bool
    {
        return ! $this->hasSubscriptionTo($plan);
    }

    public function isNotSubscribedTo(Plan $plan): bool
    {
        return ! $this->isSubscribedTo($plan);
    }

    public function switchTo(Plan $plan, $expiration = null, $immediately = true): Model
    {
        if ($immediately) {
            $this->subscription
                ->markSwitched()
                ->suppress()
                ->save();

            return $this->subscribeTo($plan, $expiration);
        }

        $this->subscription
            ->markSwitched()
            ->save();

        $startDate = $this->subscription->expired_at;
        $newSubscription = $this->subscribeTo($plan, startDate: $startDate);

        return $newSubscription;
    }

    public function canConsume($featureName, ?float $consumption = null): bool
    {
        if (empty($feature = $this->getFeature($featureName))) {
            return false;
        }

        if (! $feature->consumable) {
            return true;
        }

        if ($feature->postpaid) {
            return true;
        }

        $remainingCharges = $this->getRemainingCharges($featureName);

        return $remainingCharges >= $consumption;
    }

    public function cantConsume($featureName, ?float $consumption = null): bool
    {
        return ! $this->canConsume($featureName, $consumption);
    }

    public function hasFeature($featureName): bool
    {
        return ! $this->missingFeature($featureName);
    }

    public function missingFeature($featureName): bool
    {
        return empty($this->getFeature($featureName));
    }

    public function getRemainingCharges($featureName): float
    {
        $balance = $this->balance($featureName);

        return max($balance, 0);
    }

    public function balance($featureName)
    {
        if (empty($this->getFeature($featureName))) {
            return 0;
        }

        $currentConsumption = $this->getCurrentConsumption($featureName);
        $totalCharges = $this->getTotalCharges($featureName);

        return $totalCharges - $currentConsumption;
    }

    public function getCurrentConsumption($featureName): float
    {
        if (empty($feature = $this->getFeature($featureName))) {
            return 0;
        }

        return $this->featureConsumptions()
            ->whereBelongsTo($feature)
            ->sum('consumption');
    }

    public function getTotalCharges($featureName): float
    {
        if (empty($feature = $this->getFeature($featureName))) {
            return 0;
        }

        $subscriptionCharges = $this->getSubscriptionChargesForAFeature($feature);

        return $subscriptionCharges;
    }

    protected function consumeNotQuotaFeature($feature, ?float $consumption = null)
    {
        $consumptionExpiration = $feature->consumable
            ? $feature->calculateNextRecurrenceEnd($this->subscription->started_at)
            : null;

        $featureConsumption = $this->featureConsumptions()
            ->make([
                'consumption' => $consumption,
                'expired_at' => $consumptionExpiration,
            ])
            ->feature()
            ->associate($feature);

        $featureConsumption->save();

        return $featureConsumption;
    }

    protected function consumeQuotaFeature($feature, float $consumption)
    {
        $featureConsumption = $this->featureConsumptions()
            ->whereFeatureId($feature->id)
            ->firstOrNew();

        $featureConsumption->feature()->associate($feature);
        $featureConsumption->consumption += $consumption;
        $featureConsumption->save();

        return $featureConsumption;
    }

    protected function getSubscriptionChargesForAFeature(Model $feature): float
    {
        $subscriptionFeature = $this->loadedSubscriptionFeatures
            ->find($feature);

        if (empty($subscriptionFeature)) {
            return 0;
        }

        return $subscriptionFeature
            ->pivot
            ->charges;
    }

    public function getFeature(string $featureName): ?Model
    {
        $feature = $this->features->firstWhere('name', $featureName);

        return $feature;
    }

    public function getFeaturesAttribute(): Collection
    {
        if (! is_null($this->loadedFeatures)) {
            return $this->loadedFeatures;
        }

        $this->loadedFeatures = $this->loadSubscriptionFeatures();

        return $this->loadedFeatures;
    }

    protected function loadSubscriptionFeatures(): Collection
    {
        if (! is_null($this->loadedSubscriptionFeatures)) {
            return $this->loadedSubscriptionFeatures;
        }

        $this->loadMissing('subscription.plan.features');

        return $this->loadedSubscriptionFeatures = $this->subscription->plan->features ?? Collection::empty();
    }
}
