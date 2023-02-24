<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tests\Mocks\SubscriptionInvoice;
use Tithe\Tithe;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionInvoiceFactory extends Factory
{
    protected $model = SubscriptionInvoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $lineItems = [
            ['name' => $this->faker->word(), 'amount' => $this->faker->randomDigitNotZero() * 100],
        ];

        return [
            'subscription_id' => Tithe::newSubscriptionModel()::factory(),
            'line_items' => $lineItems,
            'total' => collect($lineItems)->sum('amount'),
            'due_date' => now(),
            'meta' => [],
            'subscriber_id' => $this->faker->randomNumber(),
            'subscriber_type' => $this->faker->word(),
        ];
    }
}
