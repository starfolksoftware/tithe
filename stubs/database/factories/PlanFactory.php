<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Enums\PeriodicityTypeEnum;

class PlanFactory extends Factory
{
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
            'display_name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'periodicity' => $this->faker->randomDigitNotNull(),
            'periodicity_type' => $this->faker->randomElement([
                PeriodicityTypeEnum::YEAR->value,
                PeriodicityTypeEnum::MONTH->value,
                PeriodicityTypeEnum::WEEK->value,
                PeriodicityTypeEnum::DAY->value,
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
