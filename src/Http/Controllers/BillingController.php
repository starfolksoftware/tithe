<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Tithe\Tithe;

class BillingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $subscriber = call_user_func(Tithe::$activeSubscriberCallback);

        return view('tithe::billing.index', [
            'subscriber' => call_user_func(Tithe::$activeSubscriberCallback),
            'permissions' => [
                'canUpdateSubscription' => Gate::check('update', $subscriber) &&
                    (bool) $subscriber->defaultAuthorization() &&
                    ! $subscriber->hasPendingDowngrade(),
            ],
        ]);
    }
}
