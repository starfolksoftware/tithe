<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Enums\SubscriptionInvoiceStatusEnum;
use Tithe\Tithe;

class SubscriptionInvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subscription_id' => Tithe::newSubscriptionModel()::factory(),
            'meta' => [],
            'subscriber_id' => $this->faker->randomNumber(),
            'subscriber_type' => $this->faker->word(),
        ];
    }
}
