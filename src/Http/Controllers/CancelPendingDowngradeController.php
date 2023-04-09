<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Tithe\Contracts\CancelsPendingDowngrades;
use Tithe\Tithe;

class CancelPendingDowngradeController extends Controller
{
    /**
     * Attach a feature to a plan.
     */
    public function __invoke(CancelsPendingDowngrades $canceler)
    {
        $subscriber = call_user_func(Tithe::$activeSubscriberCallback);

        $canceler->cancel(
            request()->user(),
            $subscriber
        );

        return redirect()->route('tithe.billing.index')->with([
            'cancel-pending-downgrade-success' => true,
        ]);
    }
}
