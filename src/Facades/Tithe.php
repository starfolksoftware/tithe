<?php

namespace Tithe\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tithe\Tithe
 */
class Tithe extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tithe\Tithe::class;
    }
}
