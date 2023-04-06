<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\CreatesFeatures;
use Tithe\Enums\PeriodicityTypeEnum;
use Tithe\Tithe;

class CreateFeature implements CreatesFeatures
{
    /**
     * Validate and create a new feature.
     */
    public function create(mixed $user, array $input)
    {
        Gate::forUser($user)->authorize('create', Tithe::newFeatureModel());

        $periodicities = implode(",", collect(PeriodicityTypeEnum::cases())->map(fn ($p) => $p->value)->toArray());

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:'.Tithe::featureModel().',name'],
            'consumable' => ['required', 'boolean'],
            'quota' => ['boolean'],
            'postpaid' => ['boolean'],
            'periodicity' => ['nullable', 'integer'],
            'periodicity_type' => ['nullable', 'string', 'max:255', 'in:'.$periodicities],
        ])->validateWithBag('createFeature');

        return Tithe::newFeatureModel()->create($input);
    }
}
