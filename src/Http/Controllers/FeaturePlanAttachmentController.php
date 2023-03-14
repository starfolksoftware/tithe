<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Tithe\Contracts\AttachesFeaturesToPlans;
use Tithe\Tithe;

class FeaturePlanAttachmentController extends Controller
{
    /**
     * Attach a feature to a plan.
     *
     * @param  mixed  $planId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(AttachesFeaturesToPlans $attacher, $planId)
    {
        $plan = Tithe::planModel()::findOrFail($planId);

        $attacher->attach(request()->user('tithe'), $plan, request()->all());

        return redirect()->route('plans.show', $planId);
    }
}
