<?php

namespace Database\Factories;

use App\Services\UrlService;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    public function definition()
    {
        $code = (new UrlService())->getCode();

        return [
            'path' => $this->faker->url,
            'code' => $code,
        ];
    }
}
