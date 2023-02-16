<?php

namespace Database\Factories;

use App\Models\SubscriptionInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Enums\SubscriptionInvoiceStatusEnum;
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
            ['name' => $this->faker->word(), 'amount' => $this->faker->randomDigitNotZero() * 100]
        ];

        return [
            'subscription_id' => Tithe::newSubscriptionModel()->factory(),
            'line_items' => $lineItems,
            'total' => collect($lineItems)->sum('amount'),
            'due_date' => now(),
            'status' => SubscriptionInvoiceStatusEnum::UNPAID->value,
            'meta' => []
        ];
    }

    /**
     * Of the given status
     * 
     * @param \Tithe\Enums\SubscriptionInvoiceStatusEnum $status
     * @return static
     */
    public function status(SubscriptionInvoiceStatusEnum $status)
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status->value,
        ]);
    }
}
