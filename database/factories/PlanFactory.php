<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Enums\PeriodicityType;
use Tithe\Tests\Mocks\Plan;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'grace_days' => 0,
            'name' => $this->faker->words(asText: true),
            'periodicity' => $this->faker->randomDigitNotNull(),
            'periodicity_type' => $this->faker->randomElement([
                PeriodicityType::Year,
                PeriodicityType::Month,
                PeriodicityType::Week,
                PeriodicityType::Day,
            ]),
            'amount' => $this->faker->randomDigitNotZero() * 1000,
        ];
    }

    public function withGraceDays()
    {
        return $this->state([
            'grace_days' => $this->faker->randomDigitNotNull(),
        ]);
    }
}
