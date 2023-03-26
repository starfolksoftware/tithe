<?php

namespace Tithe\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tithe\Tithe;

class BillingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function __invoke(Request $request)
    {
        return view('tithe::billing.index', [
            'subscriber' => call_user_func(Tithe::$activeSubscriberCallback),
        ]);
    }
}
