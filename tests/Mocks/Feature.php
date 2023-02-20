<?php

namespace Tithe\Tests\Mocks;

use Tithe\Database\Factories\FeatureFactory;
use Tithe\Feature as TitheFeature;

class Feature extends TitheFeature
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return FeatureFactory::new();
    }
}
