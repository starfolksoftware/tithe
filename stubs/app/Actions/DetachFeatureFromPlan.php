<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\DetachesFeaturesFromPlans;
use Tithe\Tithe;

class DetachFeatureFromPlan implements DetachesFeaturesFromPlans
{
    /**
     * Validate and detach the provided feature from the plan.
     */
    public function detach(mixed $user, mixed $plan, array $input): void
    {
        Gate::forUser($user)->authorize('detach-feature', $plan);

        Validator::make($input, [
            'feature_id' => ['required', 'integer', 'exists:'.Tithe::featureModel().',id'],
        ])->validateWithBag('detachFeature');

        $feature = Tithe::featureModel()::findOrFail($input['feature_id']);

        $plan->features()->detach($feature);
    }
}
