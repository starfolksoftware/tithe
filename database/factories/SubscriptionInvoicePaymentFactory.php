<?php

namespace Database\Factories;

use App\Models\SubscriptionInvoicePayment;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [];
    }
}
