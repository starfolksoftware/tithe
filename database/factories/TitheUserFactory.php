<?php

namespace Tithe\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tithe\Tests\Mocks\TitheUser;

class TitheUserFactory extends Factory
{
    protected $model = TitheUser::class;

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
