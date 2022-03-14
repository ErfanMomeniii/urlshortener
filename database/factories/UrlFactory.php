<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{

    public function definition()
    {
        return [
            'url'=>$this->faker->url,
            'code'=>time()
        ];
    }
}
