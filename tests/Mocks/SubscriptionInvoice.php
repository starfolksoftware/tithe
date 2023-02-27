<?php

namespace Tithe\Tests\Mocks;

use Tithe\Database\Factories\SubscriptionInvoiceFactory;
use Tithe\SubscriptionInvoice as TitheSubscriptionInvoice;

class SubscriptionInvoice extends TitheSubscriptionInvoice
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SubscriptionInvoiceFactory::new();
    }
}
