<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\AttachesFeaturesToPlans;
use Tithe\Tithe;

class AttachFeatureToPlan implements AttachesFeaturesToPlans
{
    /**
     * Validate and attach the provided feature to the plan.
     */
    public function attach(mixed $user, mixed $plan, array $input): void
    {
        Gate::forUser($user)->authorize('attach-feature', $plan);

        Validator::make($input, [
            'feature_id' => ['required', 'integer', 'exists:'.Tithe::featureModel().',id'],
            'charges' => ['nullable', 'integer'],
        ])->validateWithBag('attachFeature');

        $feature = Tithe::featureModel()::findOrFail($input['feature_id']);

        $plan->features()->attach($feature, ['charges' => $input['charges']]);
    }
}
