<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tithe\Subscription as TitheSubscription;

class Subscription extends TitheSubscription
{
    use SoftDeletes;
}
