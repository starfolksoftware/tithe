<?php

namespace Tithe\Tests\Mocks;

use Tithe\Database\Factories\TitheUserFactory;
use Tithe\TitheUser as TitheTitheUser;

class TitheUser extends TitheTitheUser
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TitheUserFactory::new();
    }
}
