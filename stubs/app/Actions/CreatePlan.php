<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\CreatesPlans;
use Tithe\Enums\PeriodicityTypeEnum;
use Tithe\Events\AddingPlan;
use Tithe\Tithe;

class CreatePlan implements CreatesPlans
{
    /**
     * Validate and create a new plan.
     */
    public function create(mixed $user, array $input)
    {
        Gate::forUser($user)->authorize('create', Tithe::newPlanModel());

        $periodicities = implode(",", collect(PeriodicityTypeEnum::cases())->map(fn ($p) => $p->value)->toArray());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:'.Tithe::planModel().',name'],
            'display_name' => ['string', 'max:255'],
            'periodicity' => ['required', 'integer'],
            'periodicity_type' => ['required', 'string', 'max:255', 'in:'.$periodicities],
            'description' => ['string', 'max:255'],
            'currency' => ['string', 'max:3'],
            'amount' => ['required', 'integer'],
            'grace_days' => ['required', 'integer'],
        ])->validateWithBag('createPlan');

        AddingPlan::dispatch($user);

        return Tithe::newPlanModel()->create($input);
    }
}
