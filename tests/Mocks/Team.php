<?php

namespace Tithe\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tithe\HasSubscriptions;

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

    /**
     * Returns the display name of the team for Tithe.
     * 
     * @return string
     */
    public function titheDisplayName(): string
    {
        return $this->name;
    }

    /**
     * Returns the unique email of the team for Tithe.
     * 
     * @return string
     */
    public function titheEmail(): string
    {
        return $this->id . "@example.com";
    }
}
