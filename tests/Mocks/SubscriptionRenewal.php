<?php

namespace Tithe\Tests\Mocks;

use Tithe\Database\Factories\SubscriptionRenewalFactory;
use Tithe\SubscriptionRenewal as TitheSubscriptionRenewal;

class SubscriptionRenewal extends TitheSubscriptionRenewal
{
   /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SubscriptionRenewalFactory::new();
    }
}