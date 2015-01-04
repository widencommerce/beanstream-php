Beanstream PHP API
==================

Composer ready PHP wrapper for [Beanstream API](http://developer.beanstream.com/documentation/).

## Installation

The recommended way to install the library is using [Composer](https://getcomposer.org).

```json
{
    "require": {
        "propa/beanstream": "dev-master"
    }
}
```

## Handling Exceptions

If server returns an unexpected response or error, PHP API throws *\Beanstream\Exception*.
Positive error codes correspond to Beanstream API errors, see
[Take Payment Errors](http://developer.beanstream.com/documentation/take-payments/errors/),
[Analyze Payment Errors](http://developer.beanstream.com/documentation/analyze-payments/errors/),
[Tokenize Payments Errors](http://developer.beanstream.com/documentation/tokenize-payments/errors/).
Negative codes correspond to [cURL errors](http://curl.haxx.se/libcurl/c/libcurl-errors.html)
(original cURL error codes are positive, in *\Beanstream\Exception* those are just reversed).
Exception with zero error code are PHP API specific, e.g. *The curl extension is required* or
*Unexpected response format*.

Generally, any unsuccessful request, e.g. insufficient data or declined transaction, results in *\Beanstream\Exception*,
thus *try..catch* is recommended for intercepting and handling them, see example below.

## Your First Integration

The sample below is an equivalent of original [example](http://developer.beanstream.com/documentation/your-first-integration/)
from Beanstream.

```php
<?php

//Initialize SDK Settings to use with REST API
//See Beanstream Dashboard > Administration > Account Settings > Order Settings
$merchant_id = ''; //INSERT MERCHANT ID (must be a 9 digit string)
$api_keys = array(
	'payments' => '', //INSERT PAYMENTS API KEY
	'profiles' => '', //INSERT PROFILES API KEY
	'reporting' => '' //INSERT REPORTING API KEY
	);
$api_version = 'v1'; //default
$platform = 'www'; //default

//Create Beanstream Gateway
$beanstream = new Beanstream\Gateway($merchant_id, $api_keys, $platform, $api_version);

//Example Card Payment Data
$payment_data = array(
        'order_number' => 1234567890,
        'amount' => 1.00,
        'payment_method' => 'card',
        'card' => array(
            'name' => 'Mr. Card Testerson',
            'number' => '4030000010001234',
            'expiry_month' => '07',
            'expiry_year' => '22',
            'cvd' => '123'
        ),
	    'billing' => array(
	        'name' => 'Billing Name',
	        'email_address' => 'email@email.com',
	        'phone_number' => '1234567890',
	        'address_line1' => '456-123 Billing St.',
	        'city' => 'Billingsville',
	        'province' => 'BC',
	        'postal_code' => 'V8J9I5',
	        'country' => 'CA'
		),
	    'shipping' => array(
	        'name' => 'Shipping Name',
	        'email_address' => 'email@email.com',
	        'phone_number' => '1234567890',
	        'address_line1' => '789-123 Shipping St.',
	        'city' => 'Shippingsville',
	        'province' => 'BC',
	        'postal_code' => 'V8J9I5',
	        'country' => 'CA'
		)
);
$complete = TRUE; //used for P/PA/PAC

//Try to submit a Card Payment
try {

	$result = $beanstream->payments()->makeCardPayment($payment_data, $complete);
    
    /*
     * Handle successful transaction, payment method returns
     * transaction details as result, so $result contains that data
     * in the form of associative array.
     */
} catch (\Beanstream\Exception $e) {
    /*
     * Handle transaction error, $e->code can be checked for a
     * specific error, e.g. 211 corresponds to transaction being
     * DECLINED, 314 - to missing or invalid payment information
     * etc.
     */
}
```

See examples.php for more examples.

## Tips

### Authentication

Beansteam defines separate API access passcodes for payment, profile and search requests. It is possible though
to use same value for all of them, so one should either initialize seperate *\Beanstream\Messanger* instance
for each request type or configure API passcodes in Beansteam merchant panel to be the same (see
*administration -> account settings -> order settings* for payment and search passcodes,
*configuration -> payment profile configuration* for profile passcode).

### Billing Address Province

Beanstream requires *province* filed submitted along with *billing* data to be two-letter code. It only requires it when
spedified *country* is *US* or *CA*, for other country codes set it to *--* even if corresponding country does have states
or provinces.
