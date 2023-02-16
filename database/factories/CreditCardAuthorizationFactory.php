<?php

namespace Database\Factories;

use App\Models\CreditCardAuthorization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tithe;

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
        return [];
    }
}
