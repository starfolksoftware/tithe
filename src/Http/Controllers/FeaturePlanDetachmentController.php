<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Tithe\Contracts\DetachesFeaturesFromPlans;
use Tithe\Tithe;

class FeaturePlanDetachmentController extends Controller
{
    /**
     * Detach a feature to a plan.
     *
     * @param  mixed  $planId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(DetachesFeaturesFromPlans $detacher, $planId)
    {
        $plan = Tithe::planModel()::findOrFail($planId);

        $detacher->detach(request()->user('tithe'), $plan, request()->all());

        return redirect()->route('plans.show', $planId);
    }
}
