<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Predis\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $redis = new Client();
        $this->app->instance('Redis', $redis);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
