<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CreditCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'signature' => md5(now()->toDateTimeString()).($this->faker->randomDigitNotZero() * now()->millisecond),
            'type' => $this->faker->randomElement(['Mastercard', 'Visa', 'Verve', 'Afrigo']),
            'last4' => '2345',
            'exp_month' => 12,
            'exp_year' => 2030,
        ];
    }
}
