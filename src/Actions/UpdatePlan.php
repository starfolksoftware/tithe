<?php

namespace Tithe\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\UpdatesPlans;
use Tithe\Tithe;

class UpdatePlan implements UpdatesPlans
{
    /**
     * Validate and update the given team's name.
     *
     * @param mixed $user
     * @param mixed $plan
     * @param  array $input
     */
    public function update($user, $plan, array $input): void
    {
        Gate::forUser($user)->authorize('update', $plan);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:'.Tithe::planModel().',name'],
            'display_name' => ['string', 'max:255'],
            'periodicity' => ['required', 'integer'],
            'periodicity_type' => ['required', 'string', 'max:255',],
            'description' => ['string', 'max:255'],
            'amount' => ['required', 'integer'],
            'taxes' => ['array'],
            'meta' => ['array'],
        ])->validateWithBag('updatePlan');

        $plan->forceFill($input)->save();
    }
}