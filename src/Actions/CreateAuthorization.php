<?php

namespace Tithe\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\CreatesAuthorizations;
use Tithe\Tithe;

class CreateAuthorization implements CreatesAuthorizations
{
    /**
     * Validate and create a new authorization for the given subscriber.
     *
     * @param  mixed  $user
     * @param  mixed  $subscriber
     * @return mixed
     */
    public function create($user, $subscriber, array $input)
    {
        Gate::forUser($user)->authorize('create', Tithe::newCreditCardAuthorizationModel());

        Validator::make($input, [
            
        ])->validateWithBag('createAuthorization');

        return Tithe::newCreditCardAuthorizationModel()->create($input);
    }
}
