[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/webtoolsnz/swift-php-sdk/master.svg?style=flat-square)](https://travis-ci.org/webtoolsnz/swift-php-sdk)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/webtoolsnz/swift-php-sdk.svg?style=flat-square)](https://scrutinizer-ci.com/g/webtoolsnz/swift-php-sdk/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/webtoolsnz/swift-php-sdk.svg?style=flat-square)](https://scrutinizer-ci.com/g/webtoolsnz/swift-php-sdk)

Swift SDK
====================
An easy to use PHP SDK for the [Swift SMS Campaign Management Tool](http://swiftsms.co.nz/)

## Installation

Install `webtoolsnz/swift-sdk` using Composer.

```bash
$ composer require webtoolsnz/swift-sdk
```

## Usage Examples

#### Retrieve list of campaigns
```php
use \webtoolsnz\Swift\Swift;
use \webtoolsnz\Swift\Resources\Recipient;

$apiKey = 'INSERT_YOUR_API_KEY_HERE';
$endPoint = 'https://my.swift-app.com.au/api';

$swift = new Swift($endPoint, $apiKey);

$campaigns = $swift->getCampaigns();

var_dump($campaigns);
```

#### Add recipient to campaign
```php
use \webtoolsnz\Swift\Swift;
use \webtoolsnz\Swift\Resources\Recipient;

$apiKey = 'INSERT_YOUR_API_KEY_HERE';
$endPoint = 'https://my.swift-app.com.au/api';

$swift = new Swift($endPoint, $apiKey);

$recipient = new Recipient();
$recipient->first_name = 'Philip';
$recipient->last_name = 'Fry';
$recipient->campaign_id = 123;
$recipient->mobile_number = "021234567";
$recipient->account_id = uniqid();

var_dump($swift->createRecipient($recipient));
```

#### Retrieve a recipient
This will also include the recipients survey responses, if available.

```php
use \webtoolsnz\Swift\Swift;
use \webtoolsnz\Swift\Resources\Recipient;

$apiKey = 'INSERT_YOUR_API_KEY_HERE';
$endPoint = 'https://my.swift-app.com.au/api';

$swift = new Swift($endPoint, $apiKey);

var_dump($swift->getRecipient(123));
```

## License

`swift-php-sdk` is open-sourced software licensed under the MIT License (MIT). Please see [LICENSE](LICENSE) for more information.