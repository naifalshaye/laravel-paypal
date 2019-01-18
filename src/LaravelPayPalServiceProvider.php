<?php

namespace Naif\LaravelPayPal;

use Illuminate\Support\ServiceProvider;

class LaravelPayPalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/laravel-paypal.php' => config_path('laravel-paypal.php'),
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/laravel-paypal.php', 'LaravelPayPal'
        );

        $this->app->bind('laravel-paypal', function(){
            return new LaravelPayPal();
        });
    }
}
