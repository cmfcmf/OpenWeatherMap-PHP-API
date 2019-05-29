<?php
/**
 * OpenWeatherMap-PHP-API — A php api to parse weather data from http://www.OpenWeatherMap.org .
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of
 * OpenWeatherMap before using this class:
 *
 * @see http://www.OpenWeatherMap.org
 * @see http://www.OpenWeatherMap.org/terms
 * @see http://openweathermap.org/appid
 */
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

require_once __DIR__ . '/bootstrap.php';

$cli = false;
$lf = '<br>';
if (php_sapi_name() === 'cli') {
    $lf = "\n";
    $cli = true;
}

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Get OpenWeatherMap object. Don't use caching (take a look into Example_Cache.php to see how it works).
$owm = new OpenWeatherMap();
$owm->setApiKey($myApiKey);

// Example 1: Get current uv index in Berlin.
$uvIndex = $owm->getCurrentUVIndex(52.520008, 13.404954);
echo "EXAMPLE 1$lf";

echo "Current uv index: $uvIndex->uvIndex";
echo $lf;

// Example 2: Get uv index forecast in Berlin.
$forecast = $owm->getForecastUVIndex(52.520008, 13.404954);
echo "EXAMPLE 2$lf";

foreach ($forecast as $day) {
    echo "{$day->time->format('r')} will have an uv index of: $day->uvIndex";
    echo $lf;
}


// Example 3: Get historic uv index in Berlin.
$history = $owm->getHistoricUVIndex(52.520008, 13.404954, new DateTime('-4month'), new DateTime('-3month'));
echo "EXAMPLE 3$lf";

foreach ($history as $day) {
    echo "{$day->time->format('r')} had an uv index of: $day->uvIndex";
    echo $lf;
}
