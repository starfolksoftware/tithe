<?php

namespace Tithe\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\CreatesCreditCards;
use Tithe\Tithe;

class CreateCreditCard implements CreatesCreditCards
{
    /**
     * Validate and create a new credit card.
     *
     * @param  mixed  $user
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Tithe::newCreditCardModel());

        Validator::make($input, [
            
        ])->validateWithBag('createCreditCard');

        return Tithe::newCreditCardModel()->create($input);
    }
}
