<?php

namespace Tithe\View\Components;

use Illuminate\Contracts\View;
use Illuminate\View\Component;
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

        $this->plans = Tithe::planModel()::get()
            ->map(function ($plan) use ($currentPlan) {
                $plan->user_current = $plan->name == $currentPlan;

                return $plan;
            })
            ->groupBy('periodicity_type')
            ->toArray();
    }

    public function render(): View\View|View\Factory
    {
        return view('tithe::components.subscription-manager');
    }
}
