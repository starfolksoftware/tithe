<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Tithe\Tithe;

class RemoveAuthorizationController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $authorizationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke($authorizationId)
    {
        $authorization = Tithe::creditCardAuthorizationModel()::findOrFail($authorizationId);

        Gate::forUser(request()->user('tithe'))->authorize('delete', $authorization);

        $authorization->delete();

        return redirect()->back();
    }
}
