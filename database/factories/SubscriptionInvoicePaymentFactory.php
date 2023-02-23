<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tests\Mocks\SubscriptionInvoicePayment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionInvoicePaymentFactory extends Factory
{
    protected $model = SubscriptionInvoicePayment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'transaction_id' => uniqid(),
            'reference' => uniqid(),
            'paid_at' => now(),
        ];
    }
}
