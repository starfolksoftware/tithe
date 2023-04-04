<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\UpdatesFeatures;
use Tithe\Enums\PeriodicityTypeEnum;

class UpdateFeature implements UpdatesFeatures
{
    /**
     * Validate and update the given team's name.
     *
     * @param  mixed  $user
     * @param  mixed  $feature
     */
    public function update($user, $feature, array $input): void
    {
        Gate::forUser($user)->authorize('update', $feature);

        $periodicities = implode(",", collect(PeriodicityTypeEnum::cases())->map(fn ($p) => $p->value)->toArray());

        Validator::make($input, [
            'consumable' => ['required', 'boolean'],
            'quota' => ['boolean'],
            'postpaid' => ['boolean'],
            'periodicity' => ['nullable', 'integer'],
            'periodicity_type' => ['nullable', 'string', 'max:255', 'in:'.$periodicities],
        ])->validateWithBag('updateFeature');

        $feature->forceFill(collect($input)->only([
            'consumable',
            'quota',
            'postpaid',
            'periodicity',
            'periodicity_type',
        ])->toArray())->save();
    }
}
