<?php

namespace Tithe\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\UpdatesFeatures;
use Tithe\Tithe;

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

        Validator::make($input, [
            'consumable' => ['required', 'boolean'],
            'quota' => ['boolean'],
            'postpaid' => ['boolean'],
            'periodicity' => ['nullable', 'integer'],
            'periodicity_type' => ['nullable', 'string', 'max:255', 'in:Year,Month,Week,Day'],
        ])->validateWithBag('updateFeature');

        $feature->forceFill(collect($input)->only([
            'consumable',
            'quota',
            'postpaid',
            'periodicity',
            'periodicity_type'
        ])->toArray())->save();
    }
}
