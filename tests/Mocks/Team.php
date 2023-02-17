<?php

namespace Tithe\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tithe\HasSubscriptions;
use Tithe\Tests\Mocks\TeamFactory;

class Team extends Model
{
    use HasFactory;
    use HasSubscriptions;
    
    protected $table = 'teams';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TeamFactory::new();
    }
}