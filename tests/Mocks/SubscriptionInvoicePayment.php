<?php

namespace Tithe\Tests\Mocks;

use Tithe\Database\Factories\SubscriptionInvoicePaymentFactory;
use Tithe\SubscriptionInvoicePayment as TitheSubscriptionInvoicePayment;

class SubscriptionInvoicePayment extends TitheSubscriptionInvoicePayment
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SubscriptionInvoicePaymentFactory::new();
    }
}
