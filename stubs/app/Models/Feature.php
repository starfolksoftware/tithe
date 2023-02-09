<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tithe\Feature as TitheFeature;

class Feature extends TitheFeature
{
    use SoftDeletes;
}