<?php

namespace ahmetbarut\Multilang;

use Illuminate\Support\ServiceProvider;

class ahmetbarutServiceProviders extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . "/routes/multi_lang.php");
        $this->publishes([
            __DIR__ . "/routes" => base_path("routes/"),
            __DIR__ . "/config/multi_lang.php" => config_path("multi_lang.php"),
        ]);
    }
}
