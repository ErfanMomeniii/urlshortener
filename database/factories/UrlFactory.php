<?php

namespace Database\Factories;

use App\Services\UrlService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    /**
     * @throws BindingResolutionException
     */
    public function definition(): array
    {
        $code = app()->make(UrlService::class)->generateCode();

        return [
            'path' => $this->faker->url,
            'code' => $code,
        ];
    }
}
