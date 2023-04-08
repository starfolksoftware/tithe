<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Tithe\Contracts\DowngradesSubscriptions;
use Tithe\Tithe;

class DowngradeSubscriptionController extends Controller
{
    /**
     * Attach a feature to a plan.
     */
    public function __invoke(DowngradesSubscriptions $downgrader)
    {
        $planName = request('planName');
        $subscriber = call_user_func(Tithe::$activeSubscriberCallback);

        $plan = Tithe::planModel()::whereName($planName)->first();

        $downgrader->downgrade(
            request()->user(),
            $subscriber,
            $plan
        );

        return redirect()->route('tithe.billing.index')->with([
            'downgrade-subscription-success' => true,
        ]);
    }
}
