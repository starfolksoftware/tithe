<?php

namespace Tithe\Tests\Mocks;

use Tithe\Database\Factories\FeatureConsumptionFactory;
use Tithe\FeatureConsumption as TitheFeatureConsumption;

class FeatureConsumption extends TitheFeatureConsumption
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return FeatureConsumptionFactory::new();
    }
}