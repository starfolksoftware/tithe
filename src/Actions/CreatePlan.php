<?php

namespace Tithe\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\CreatesPlans;
use Tithe\Events\AddingPlan;
use Tithe\Tithe;

class CreatePlan implements CreatesPlans
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  mixed  $user
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Tithe::newPlanModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:'.Tithe::planModel().',name'],
            'display_name' => ['string', 'max:255'],
            'periodicity' => ['required', 'integer'],
            'periodicity_type' => ['required', 'string', 'max:255', 'in:Year,Month,Week,Day'],
            'description' => ['string', 'max:255'],
            'currency' => ['string', 'max:3'],
            'amount' => ['required', 'integer'],
            'grace_days' => ['required', 'integer'],
        ])->validateWithBag('createPlan');

        AddingPlan::dispatch($user);

        return Tithe::newPlanModel()->create($input);
    }
}
