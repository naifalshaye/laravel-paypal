<?php

namespace Naif\PayPal\Facades;

use Illuminate\Support\Facades\Facade;

class PayPal extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'laravel-paypal';
    }
}