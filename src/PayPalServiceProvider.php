<?php

namespace Naif\PayPal;

use Illuminate\Support\ServiceProvider;

class PayPalServiceProvider extends ServiceProvider
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
                __DIR__.'/config/paypal.php' => config_path('paypal.php'),
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
            __DIR__ . '/config/paypal.php', 'PayPal'
        );

        $this->app->bind('laravel-paypal', function(){
            return new PayPal();
        });
    }
}
