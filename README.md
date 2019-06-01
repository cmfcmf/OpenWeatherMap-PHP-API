OpenWeatherMap PHP API
======================
A PHP 7.0+ API to retrieve and parse global weather data from
[OpenWeatherMap.org](http://www.OpenWeatherMap.org).
This library aims to normalise the provided data and remove some inconsistencies.
This library is neither maintained by OpenWeatherMap nor their official PHP API.

[![Build Status](https://travis-ci.org/cmfcmf/OpenWeatherMap-PHP-Api.svg?branch=master)](https://travis-ci.org/cmfcmf/OpenWeatherMap-PHP-Api)
[![license](https://img.shields.io/github/license/cmfcmf/OpenWeatherMap-PHP-Api.svg)](https://github.com/cmfcmf/OpenWeatherMap-PHP-Api/blob/master/LICENSE)
[![release](https://img.shields.io/github/release/cmfcmf/OpenWeatherMap-PHP-Api.svg)](https://github.com/cmfcmf/OpenWeatherMap-PHP-Api/releases)
[![codecov](https://codecov.io/gh/cmfcmf/OpenWeatherMap-PHP-Api/branch/master/graph/badge.svg)](https://codecov.io/gh/cmfcmf/OpenWeatherMap-PHP-Api)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/badges/quality-score.png?s=f31ca08aa8896416cf162403d34362f0a5da0966)](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/)
<br>
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/0addfb24-e2b4-4feb-848e-86b2078ca104/big.png)](https://insight.sensiolabs.com/projects/0addfb24-e2b4-4feb-848e-86b2078ca104)

Installation
============
This library can be found on [Packagist](https://packagist.org/packages/cmfcmf/openweathermap-php-api).
The recommended way to install and use it is through [Composer](http://getcomposer.org).

    composer require "cmfcmf/openweathermap-php-api"

You will also need to choose and install two additional dependencies separately:

1. A [PSR-17](https://www.php-fig.org/psr/psr-17/) compatible HTTP factory implementation.
A list of HTTP factory implementations is available at
[Packagist](https://packagist.org/providers/psr/http-factory-implementation).
2. A [PSR-18](https://www.php-fig.org/psr/psr-18/) compatible HTTP client implementation.
A list of HTTP client implementations is available at
[Packagist](https://packagist.org/providers/psr/http-client-implementation).

Example call
============
```php
<?php
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

// Must point to composer's autoload file.
require 'vendor/autoload.php';

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// You can use every PSR-17 compatible HTTP request factory
// and every PSR-18 compatible HTTP client. This example uses
// `http-interop/http-factory-guzzle` and `php-http/guzzle6-adapter`
// which you need to install separately.
$httpRequestFactory = new RequestFactory();
$httpClient = GuzzleAdapter::createWithConfig([]);

// Create OpenWeatherMap object.
$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory);

try {
    $weather = $owm->getWeather('Berlin', $units, $lang);
} catch(OWMException $e) {
    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
} catch(\Exception $e) {
    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
}

echo $weather->temperature;
```

For more example code and instructions on how to use this library, please take
a look into  the `Examples` folder. Make sure to get an API Key from
http://home.openweathermap.org/ and put it into `Examples/ApiKey.ini`.

- `CurrentWeather.php` Shows how to receive the current weather.
- `WeatherForecast.php` Shows how to receive weather forecasts.
- `WeatherHistory.php` Shows how to receive weather history.
- `UVIndex.php` Shows how to receive uv index data.

Contributing
============
I'm happy about every **pull request** or **issue** you find and open to help
make this API **more awesome**.

## Vagrant

You can use [Vagrant](https://vagrantup.com) to kick-start your development.
Simply run `vagrant up` and `vagrant ssh` to start a PHP VM with all
dependencies included.

## Docker

You can also use Docker to start developing this library. First install dependencies:

    docker run --rm --interactive --tty \
        --volume $PWD:/app \
        --user $(id -u):$(id -g) \
        composer install

And then execute an example:

    docker run --rm --interactive --tty \
        --volume $PWD:/app -w /app \
        php bash

    > php Examples/CurrentWeather.php


License
=======
MIT — Please see the [LICENSE file](https://github.com/Cmfcmf/OpenWeatherMap-PHP-Api/blob/master/LICENSE)
distributed with this source code for further information regarding copyright and licensing.

**Please check out the following official links to read about the terms, pricing
and license of OpenWeatherMap before using the service:**
- [OpenWeatherMap.org/terms](http://OpenWeatherMap.org/terms)
- [OpenWeatherMap.org/appid](http://OpenWeatherMap.org/appid)
