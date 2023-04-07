<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tests\Mocks\SubscriptionInvoice;
use Tithe\Tithe;

class SubscriptionInvoiceFactory extends Factory
{
    protected $model = SubscriptionInvoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
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
