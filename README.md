OpenWeatherMap-PHP-Api
======================
A php api to parse weather data from [OpenWeatherMap.org](http://www.OpenWeatherMap.org). This api tries to normalise and abstract the data and remove inconsistencies.

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/badges/quality-score.png?s=f31ca08aa8896416cf162403d34362f0a5da0966)](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/) [![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/cmfcmf/openweathermap-php-api/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
-----------

If you are looking for an implementation for the [CMS Zikula](http://www.zikula.org), you may want to take a look at [cmfcmf/Weather](https://github.com/cmfcmf/Weather).

For example code and how to use this api, please take a look into `Examples_*.php` files and run them in your browser.
- `Examples_Current.php` Shows how to receive the current weather.
- `Examples_Forecast.php` Shows how to receive weather forecasts.
- `Examples_Cache.php` Shows how to implement a cache.

**Notice:** This api is not made by OpenWeatherMap, nor their offical php api.

Example call
============
```php
<?php
use cmfcmf\OpenWeatherMap;
use cmfcmf\OpenWeatherMap\Exception as OWMException;

// Remove this line if you are using composer.
require('cmfcmf/OpenWeatherMap.php');

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
MIT — Please see the [LICENSE file](https://github.com/cmfcmf/OpenWeatherMap-PHP-Api/blob/master/LICENSE) distributed with this source code for further information regarding copyright and licensing.

**Please visit the following links to read about the usage policies and the license of OpenWeatherMap before using this class.**
- [OpenWeatherMap.org](http://www.OpenWeatherMap.org)
- [OpenWeatherMap.org/about](http://www.OpenWeatherMap.org/about)
- [OpenWeatherMap.org/copyright](http://www.OpenWeatherMap.org/copyright)
- [OpenWeatherMap.org/appid](http://www.OpenWeatherMap.org/appid)

Contribute || Support me
========================
I'm very happy if you open **pull requests** or **issues** to help making this API **more awesome**. 

However if you like this and want to **support** _me_, you may want to **flattr** a few coins?

[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=cmfcmf&url=https://github.com/cmfcmf/OpenWeatherMap-PHP-Api&title=OpenWeatherMap-PHP-Api&language=&tags=github&category=software)
