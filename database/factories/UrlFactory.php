<?php

namespace Database\Factories;

use App\Services\UrlService;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class UrlFactory extends Factory
{
    public function definition(): array
    {
        $code = (new UrlService())->getCode();

        return [
            'path' => $this->faker->url,
            'code' => $code,
        ];
    }
}
