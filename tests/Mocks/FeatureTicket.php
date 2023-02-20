<?php

namespace Tithe\Tests\Mocks;

use Tithe\Database\Factories\FeatureTicketFactory;
use Tithe\FeatureTicket as TitheFeatureTicket;

class FeatureTicket extends TitheFeatureTicket
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return FeatureTicketFactory::new();
    }
}
