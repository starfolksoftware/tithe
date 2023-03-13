<?php

namespace Tithe\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\AttachesFeaturesToPlans;
use Tithe\Tithe;

class AttachFeatureToPlan implements AttachesFeaturesToPlans
{
    /**
     * Validate and attach the provided feature to the plan.
     *
     * @param  mixed  $user
     * @param  mixed  $plan
     * @param  array $input
     * @return void
     */
    public function attach($user, $plan, array $input): void
    {
        Gate::forUser($user)->authorize('attach-feature', $plan);

        Validator::make($input, [
            'feature_id' => ['required', 'integer', 'exists:'.Tithe::featureModel().',id'],
            'charges' => ['required', 'integer'],
        ])->validateWithBag('attachFeature');

        $feature = Tithe::featureModel()::findOrFail($input['feature_id']);

        $plan->features()->attach($feature, ['charges' => $input['charges']]);
    }
}
