<?php

namespace AhmetBarut\Multilang\Providers;

use AhmetBarut\Multilang\Route;
use Illuminate\Support\ServiceProvider;

class MultilangServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Route::class, function ($app) {
            return new Route($app->getLocale());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
