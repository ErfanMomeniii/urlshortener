<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PermissionFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->title,
        ];
    }
}
