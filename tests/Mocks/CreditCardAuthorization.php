<?php

namespace Tithe\Tests\Mocks;

use Tithe\CreditCardAuthorization as TitheCreditCardAuthorization;
use Tithe\Database\Factories\CreditCardAuthorizationFactory;

class CreditCardAuthorization extends TitheCreditCardAuthorization
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CreditCardAuthorizationFactory::new();
    }
}
