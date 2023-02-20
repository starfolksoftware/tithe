<?php

namespace Tithe\Tests\Mocks;

use Tithe\CreditCard as TitheCreditCard;
use Tithe\Database\Factories\CreditCardFactory;

class CreditCard extends TitheCreditCard
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CreditCardFactory::new();
    }
}