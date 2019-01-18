<?php

namespace Naif\LaravelPayPal\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelPayPal extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'laravel-paypal';
    }
}