<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tithe;

class SubscriptionRenewalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subscription_id' => Tithe::newSubscriptionModel()->factory(),
            'overdue' => $this->faker->boolean(),
            'renewal' => $this->faker->boolean(),
        ];
    }
}
