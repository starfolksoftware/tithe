<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tests\Mocks\CreditCardAuthorization;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class CreditCardAuthorizationFactory extends Factory
{
    protected $model = CreditCardAuthorization::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email(),
            'auth' => [],
            'code' => uniqid(),
        ];
    }
}
