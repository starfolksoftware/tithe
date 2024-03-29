<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tests\Mocks\CreditCard;

class CreditCardFactory extends Factory
{
    protected $model = CreditCard::class;

    /**
     * Define the model's default state.
     *
     * @return array
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
