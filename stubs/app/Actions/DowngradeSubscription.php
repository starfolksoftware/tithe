<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;
use Tithe\Contracts\DowngradesSubscriptions;

class DowngradeSubscription implements DowngradesSubscriptions
{
    /**
     * Validate and upgrade the given subscriber's subscription.
     */
    public function downgrade(mixed $user, mixed $subscriber, mixed $plan): void
    {
        Gate::forUser($user)->authorize('update', $subscriber);

        try {
            $this->ensureCurrentSubscriptionCanBeDowngraded(
                $subscriber,
                $plan
            );

            $currentPlan = $subscriber->subscription?->plan;

            DB::transaction(function () use ($subscriber, $plan, $currentPlan) {
                $newSubscription = $subscriber->switchTo($plan, immediately: false);

                if ($newSubscription->plan->amount > 0) {
                    $subscriber->subscriptionInvoices()->create([
                        'subscription_id' => $newSubscription->id,
                        'meta' => [
                            'action' => 'downgrade',
                            'from' => $currentPlan->name,
                            'to' => $plan->name,
                            'paystack_transaction_reference' => null,
                        ],
                    ]);
                }
            });
        } catch (\Throwable $th) {
            report($th);
            Facades\Validator::make([], [])->after(function (Validator $validator) use ($th) {
                $validator->errors()->add(
                    'downgrade-error', $th->getMessage()
                );
            })->validateWithBag('downgradeSubscription');
        }
    }

    /**
     * Ensures current subscription can be downgraded.
     */
    protected function ensureCurrentSubscriptionCanBeDowngraded(mixed $subscriber, $newPlan): void
    {
        $oldPlan = $subscriber->subscription?->plan;

        throw_if(($newPlan->amount >= $oldPlan->amount) || $subscriber->hasPendingSwitch(), 'Exception', 'Current subscription can not be downgraded.');
    }
}
