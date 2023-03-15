<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\CreatesFeatures;
use Tithe\Tithe;

class CreateFeature implements CreatesFeatures
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  mixed  $user
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Tithe::newFeatureModel());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:'.Tithe::featureModel().',name'],
            'consumable' => ['required', 'boolean'],
            'quota' => ['boolean'],
            'postpaid' => ['boolean'],
            'periodicity' => ['nullable', 'integer'],
            'periodicity_type' => ['nullable', 'string', 'max:255', 'in:Year,Month,Week,Day'],
        ])->validateWithBag('createFeature');

        return Tithe::newFeatureModel()->create($input);
    }
}
