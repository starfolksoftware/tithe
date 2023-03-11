<?php

namespace Tithe\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\UpdatesPlans;

class UpdatePlan implements UpdatesPlans
{
    /**
     * Validate and update the given team's name.
     *
     * @param  mixed  $user
     * @param  mixed  $plan
     */
    public function update($user, $plan, array $input): void
    {
        Gate::forUser($user)->authorize('update', $plan);

        Validator::make($input, [
            'display_name' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
            'currency' => ['string', 'max:3'],
            'amount' => ['required', 'integer'],
            'grace_days' => ['required', 'integer'],
        ])->validateWithBag('updatePlan');

        $plan->forceFill(collect($input)->only([
            'display_name',
            'description',
            'currency',
            'amount',
            'grace_days',
        ])->toArray())->save();
    }
}
