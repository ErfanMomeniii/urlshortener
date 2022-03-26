<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'username' => $this->faker->name(),
            'password' => $this->faker->password()
        ];
    }

}
