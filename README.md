# Laravel PayPal to communicate with PayPal API to get current balance and transactions

## Installation
```
composer require naif/laravel-paypal
```

Add service provider and alias to config/app.php
```
Naif\PayPal\PayPalServiceProvider::class,

'PayPal' => Naif\PayPal\Facades\PayPal::class,
```
## API KEYS
Get your API access from PayPal website

https://www.paypal.com/businessprofile/mytools/apiaccess/firstparty/signature

Paypal > Profile > Profile and settings > My selling tools > API access > NVP/SOAP API integration (Classic)


![Package screenshot](https://github.com/naifalshaye/nova-paypal/blob/master/screenshots/auth.png)


Add these to your .env
```
LARAVEL_PAYPAL_USERNAME=
LARAVEL_PAYPAL_PASSWORD=
LARAVEL_PAYPAL_SIGNATURE=

```
## Usage

use Naif\PayPal\PayPal;

$paypal = new PayPal();


Get Current Balance
```
$balance = $paypal->getBalance();

Response:
[
  "balance" => array:5 [▼
      "ACK" => "Success"
      "L_AMT0" => "120.62"
      "L_SEVERITYCODE0" => null
      "L_ERRORCODE0" => null
      "L_LONGMESSAGE0" => null
    ]
]
```

Get Transactions
```
$transactions = $paypal->getTransactions();
You can specify the number of days and number of transactions to retreive. Default (7 days, 10 transations)

Response:
[
 "transactions" => array:3 [▼
     0 => array:11 [▼
       "timestamp" => "2019-01-17"
       "timezone" => "GMT"
       "type" => "Payment"
       "email" => "naif@naif.io"
       "name" => "Naif Alshaye"
       "transaction_id" => "3DR402287R3992703"
       "status" => "Completed"
       "amt" => "1.00"
       "currency_code" => "USD"
       "fee_amount" => "-0.34"
       "net_amount" => "0.66"
     ]
 ]
]
```

## Support:
naif@naif.io

https://www.linkedin.com/in/naif

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
