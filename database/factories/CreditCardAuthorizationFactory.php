<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tests\Mocks\CreditCardAuthorization;

class CreditCardAuthorizationFactory extends Factory
{
    protected $model = CreditCardAuthorization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email(),
            'code' => uniqid(),
        ];
    }
}
