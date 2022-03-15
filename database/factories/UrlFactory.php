<?php

namespace Database\Factories;

use App\Services\UrlCodeService;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{

    public function definition()
    {
        $code = UrlCodeService::generate();

        return [
            'path' => $this->faker->url,
            'code' => $code,
        ];
    }
}
