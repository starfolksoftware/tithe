<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TitheUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'username' => \Illuminate\Support\Str::slug($this->faker->userName),
            'password' => bcrypt($this->faker->password),
            'avatar' => md5(trim(\Illuminate\Support\Str::lower($this->faker->email))),
            'role' => 'admin',
        ];
    }
}
