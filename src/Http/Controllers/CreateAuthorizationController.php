<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Tithe\Contracts\CreatesAuthorizations;
use Tithe\Tithe;

class CreateAuthorizationController extends Controller
{
    /**
     * Attach a feature to a plan.
     */
    public function __invoke(CreatesAuthorizations $creator)
    {
        $subscriber = call_user_func(Tithe::$activeSubscriberCallback);

        $creator->create(
            request()->user(), 
            $subscriber,
            request('reference', request('trxref'))
        );

        return redirect()->route('tithe.billing.index');
    }
}
