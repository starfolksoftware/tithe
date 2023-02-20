<?php

namespace Tithe\Tests\Mocks;

use Tithe\Database\Factories\PlanFactory;
use Tithe\Plan as TithePlan;

class Plan extends TithePlan
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PlanFactory::new();
    }
}
