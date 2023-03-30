<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Tithe\Tithe;

class BillingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('tithe::billing.index', [
            'subscriber' => call_user_func(Tithe::$activeSubscriberCallback),
        ]);
    }
}
