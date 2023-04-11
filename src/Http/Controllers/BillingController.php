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
            'subscriber' => $subscriber,
            'invoices' => $subscriber->subscriptionInvoices()->latest()->limit(12)->get(),
            'permissions' => [
                'canUpdateSubscription' => Gate::check('update', $subscriber) &&
                    (bool) $subscriber->defaultAuthorization() &&
                    ! $subscriber->hasPendingDowngrade(),
            ],
        ]);
    }
}
