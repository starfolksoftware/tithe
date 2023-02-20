<?php

namespace Tithe\Tests\Mocks;

use Tithe\Database\Factories\SubscriptionFactory;
use Tithe\Subscription as TitheSubscription;

class Subscription extends TitheSubscription
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SubscriptionFactory::new();
    }
}
