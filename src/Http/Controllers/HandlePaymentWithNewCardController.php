<?php

namespace Tithe\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Tithe\Contracts\CreatesAuthorizations;
use Tithe\Contracts\CreatesCreditCards;
use Tithe\Tithe;

class HandlePaymentWithNewCardController extends Controller
{
    /**
     * Attach a feature to a plan.
     */
    public function __invoke(CreatesAuthorizations $authCreator, CreatesCreditCards $creditCardCreator, Request $request)
    {
        // confirm the transaction using the reference
        DB::transaction(function () use ($authCreator, $creditCardCreator, $request) {
            $subscriber = call_user_func(Tithe::$activeSubscriberCallback);

            $creditCard = $creditCardCreator->create($request->user('tithe'), $request->all());

            $authCreator->create(
                $request->user('tithe'), 
                $subscriber,
                $creditCard,
                $request->all()
            );
        });

        return redirect()->route('');
    }
}
