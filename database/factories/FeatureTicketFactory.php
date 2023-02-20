<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tests\Mocks\FeatureTicket;

class FeatureTicketFactory extends Factory
{
    protected $model = FeatureTicket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'charges' => 5,
            'expired_at' => now()->addMonth(),
        ];
    }
}
