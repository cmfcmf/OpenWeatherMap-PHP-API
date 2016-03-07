OpenWeatherMap PHP API
======================
A php API to retrieve and parse global weather data from 
[OpenWeatherMap.org](http://www.OpenWeatherMap.org).
This library aims to normalise the provided data and remove some inconsistencies.
This library is neither maintained by OpenWeatherMap nor their official PHP API.

[![Build Status](https://travis-ci.org/cmfcmf/OpenWeatherMap-PHP-Api.png?branch=master)](https://travis-ci.org/cmfcmf/OpenWeatherMap-PHP-Api)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/badges/quality-score.png?s=f31ca08aa8896416cf162403d34362f0a5da0966)](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/)
[![Code Coverage](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/0addfb24-e2b4-4feb-848e-86b2078ca104/big.png)](https://insight.sensiolabs.com/projects/0addfb24-e2b4-4feb-848e-86b2078ca104)
-----------

For example code and how to use this API, please take a look into 
`Examples_*.php` files and open them in your browser.
- `Examples_Current.php` Shows how to receive the current weather.
- `Examples_Forecast.php` Shows how to receive weather forecasts.
- `Examples_History.php` Shows how to receive weather history.
- `Examples_Cache.php` Shows how to implement a cache.


Contribute!
===========
I'm happy about every **pull request** or **issue** you find and open to help 
making this API **more awesome**.

You can use [Vagrant](https://vagrantup.com) to kick-start your development.
Simply run `vagrant up`, `vagrant ssh` and `cd` into `/vagrant` to start 
developing.

Installation
============
This library can be found on [Packagist](https://packagist.org/packages/cmfcmf/openweathermap-php-api).
The recommended way to install and use this is through [Composer](http://getcomposer.org).
Execute `composer require "cmfcmf/openweathermap-php-api": "~2.0"` in your
project root.

Example call
============
```php
<?php
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

// Must point to composer's autoload file.
require('vendor/autoload.php');

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Get OpenWeatherMap object. Don't use caching (take a look into Example_Cache.php to see how it works).
$owm = new OpenWeatherMap();

try {
    $weather = $owm->getWeather('Berlin', $units, $lang);
} catch(OWMException $e) {
    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
    echo "<br />\n";
} catch(\Exception $e) {
    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
    echo "<br />\n";
}

echo $weather->temperature;
```

License
=======
MIT — Please see the [LICENSE file](https://github.com/Cmfcmf/OpenWeatherMap-PHP-Api/blob/master/LICENSE)
distributed with this source code for further information regarding copyright and licensing.

**Please check out the following official links to read about the terms, pricing 
and license of OpenWeatherMap before using the service.**
- [OpenWeatherMap.org](http://OpenWeatherMap.org)
- [OpenWeatherMap.org/terms](http://OpenWeatherMap.org/terms)
- [OpenWeatherMap.org/appid](http://OpenWeatherMap.org/appid)
