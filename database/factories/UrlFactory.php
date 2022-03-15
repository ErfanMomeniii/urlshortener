<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory{

    public function definition(){
        $code=time();
        while(Url::where('code','=',$code)->first()){
            $code++;
        }

        return [
            'url'=>$this->faker->url,
            'code'=>$code,
        ];
    }
}
