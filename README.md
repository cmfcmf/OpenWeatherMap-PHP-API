OpenWeatherMap-PHP-Api
======================
A php api to parse weather data from [OpenWeatherMap.org](http://www.OpenWeatherMap.org). This api tries to normalise and abstract the data and remove inconsistencies.

[![Build Status](https://travis-ci.org/cmfcmf/OpenWeatherMap-PHP-Api.png?branch=master)](https://travis-ci.org/cmfcmf/OpenWeatherMap-PHP-Api)[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/badges/quality-score.png?s=f31ca08aa8896416cf162403d34362f0a5da0966)](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/)[![Code Coverage](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/badges/coverage.png?s=65153e7cfb13e050d734c645e38f2dd7ea7a6860)](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/0addfb24-e2b4-4feb-848e-86b2078ca104/big.png)](https://insight.sensiolabs.com/projects/0addfb24-e2b4-4feb-848e-86b2078ca104)
-----------

For example code and how to use this api, please take a look into `Examples_*.php` files and run them in your browser.
- `Examples_Current.php` Shows how to receive the current weather.
- `Examples_Forecast.php` Shows how to receive weather forecasts.
- [*NEW*] `Examples_History.php` Shows how to receive weather history.
- `Examples_Cache.php` Shows how to implement a cache.

**Notice:** This api is not made by OpenWeatherMap, nor their official php api.

Contribute!
===========
I'm very happy if you open **pull requests** or **issues** to help making this API **more awesome**.

Installation
============
This library can be found on [Packagist](https://packagist.org/packages/cmfcmf/openweathermap-php-api).
The recommended way to install this is through [composer](http://getcomposer.org).

Edit your `composer.json` and add:

```json
{
    "require": {
        "cmfcmf/openweathermap-php-api": "~2.0"
    }
}
```

And install dependencies:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```


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
MIT — Please see the [LICENSE file](https://github.com/Cmfcmf/OpenWeatherMap-PHP-Api/blob/master/LICENSE) distributed with this source code for further information regarding copyright and licensing.

**Please check out the following links to read about the usage policies and the license of OpenWeatherMap before using the service.**
- [OpenWeatherMap.org](http://www.OpenWeatherMap.org)
- [OpenWeatherMap.org/terms](http://www.OpenWeatherMap.org/terms)
- [OpenWeatherMap.org/appid](http://www.OpenWeatherMap.org/appid)
