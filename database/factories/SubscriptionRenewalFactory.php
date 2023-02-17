<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Subscription;
use Tithe\Tests\Mocks\SubscriptionRenewal;

class SubscriptionRenewalFactory extends Factory
{
    protected $model = SubscriptionRenewal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subscription_id' => Subscription::factory(),
            'overdue' => $this->faker->boolean(),
            'renewal' => $this->faker->boolean(),
        ];
    }
}
