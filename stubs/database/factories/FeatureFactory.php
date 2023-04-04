<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Enums\PeriodicityTypeEnum;

class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'consumable' => $this->faker->boolean(),
            'name' => $this->faker->words(asText: true),
            'periodicity' => $this->faker->randomDigitNotNull(),
            'periodicity_type' => $this->faker->randomElement([
                PeriodicityTypeEnum::YEAR->value,
                PeriodicityTypeEnum::MONTH->value,
                PeriodicityTypeEnum::WEEK->value,
                PeriodicityTypeEnum::DAY->value,
            ]),
            'quota' => false,
            'postpaid' => false,
        ];
    }

    public function consumable()
    {
        return $this->state(fn (array $attributes) => [
            'consumable' => true,
        ]);
    }

    public function notConsumable()
    {
        return $this->state(fn (array $attributes) => [
            'quota' => false,
            'consumable' => false,
            'periodicity' => null,
            'periodicity_type' => null,
        ]);
    }

    public function quota()
    {
        return $this->state(fn (array $attributes) => [
            'consumable' => true,
            'quota' => true,
            'periodicity' => null,
            'periodicity_type' => null,
        ]);
    }

    public function notQuota()
    {
        return $this->state(fn (array $attributes) => [
            'quota' => false,
        ]);
    }

    public function postpaid()
    {
        return $this->state(fn (array $attributes) => [
            'postpaid' => true,
        ]);
    }

    public function prepaid()
    {
        return $this->state(fn (array $attributes) => [
            'postpaid' => false,
        ]);
    }
}
