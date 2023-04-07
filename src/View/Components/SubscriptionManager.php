<?php

namespace Tithe\View\Components;

use Illuminate\Contracts\View;
use Illuminate\View\Component;
use Tithe\Enums\PeriodicityTypeEnum;
use Tithe\Tithe;

class SubscriptionManager extends Component
{
    /** @var array $plans Holds the plans */
    public mixed $plans;

    /**
     * Constructor.
     */
    public function __construct(public mixed $subscriber, public array $permissions = [])
    {
        $currentPlan = $subscriber->subscription?->plan->name;

        $this->plans = Tithe::planModel()::with(['features'])->get()
            ->map(function ($plan) use ($currentPlan, $subscriber) {
                $plan->user_current = $plan->name == $currentPlan;
                $plan->update_charge = round((float) PeriodicityTypeEnum::proration($subscriber, $plan) / 100, 2);
                $plan->periodicity_type_label = PeriodicityTypeEnum::from($plan->periodicity_type)
                    ->label();
                $plan->features = $plan->features->map(function ($feature) {
                    $feature->label = $feature->displayLabel((float) $feature->pivot->charges);

                    return $feature;
                });

                return $plan;
            })
            ->groupBy('periodicity_type_label')
            ->toArray();
    }

    public function render(): View\View|View\Factory
    {
        return view('tithe::components.subscription-manager');
    }
}
