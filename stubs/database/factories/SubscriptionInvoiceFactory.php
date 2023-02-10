<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tithe;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subscription_id' => '',
            'line_items' => '',
            'total' => '',
            'due_date' => '',
            'status' => '',
            'meta' => ''
        ];
    }

    public function canceled()
    {
        return $this->state(fn (array $attributes) => [
            'canceled_at' => $this->faker->dateTime(),
        ]);
    }
}
