<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tithe\Plan as TithePlan;

class Plan extends TithePlan
{
    use SoftDeletes;
}