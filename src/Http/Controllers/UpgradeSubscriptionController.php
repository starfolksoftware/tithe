<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Tithe\Contracts\UpgradesSubscriptions;
use Tithe\Tithe;

class UpgradeSubscriptionController extends Controller
{
    /**
     * Attach a feature to a plan.
     */
    public function __invoke(UpgradesSubscriptions $upgrader)
    {
        $planName = request('planName');
        $subscriber = call_user_func(Tithe::$activeSubscriberCallback);

        $plan = Tithe::planModel()::whereName($planName)->first();

        $upgrader->upgrade(
            request()->user(),
            $subscriber,
            $plan
        );

        return redirect()->route('tithe.billing.index')->with([
            'upgrade-subscription-success' => true,
        ]);
    }
}
