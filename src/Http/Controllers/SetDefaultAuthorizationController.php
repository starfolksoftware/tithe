<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Tithe\Tithe;

class SetDefaultAuthorizationController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function __invoke(): \Illuminate\Http\RedirectResponse
    {
        $authorization = Tithe::creditCardAuthorizationModel()::findOrFail(
            request('authorizationId')
        );

        Gate::forUser(request()->user())
            ->authorize('update', $authorization);

        $authorization
            ->subscriber
            ->setDefaultAuth($authorization);

        return redirect()->back();
    }
}
