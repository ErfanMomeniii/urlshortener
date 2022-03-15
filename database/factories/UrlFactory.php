<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{

    public function definition()
    {
        do {
            $code = substr(md5(rand()), 0, 5);
        } while (Url::where('code', '=', $code)->first());

        return [
            'url' => $this->faker->url,
            'code' => $code,
        ];
    }
}
