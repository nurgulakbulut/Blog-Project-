<?php

namespace App\Providers;

use Cmfcmf\OpenWeatherMap;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(OpenWeatherMap::class, function ($app) {
            return $owm = new OpenWeatherMap(
                '7f47224e10cdb61c071e8fe6d19b10bf',
                $app->make(Client::class),
                $app->make(HttpFactory::class)
            );
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
