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

if (file_exists('../vendor/autoload.php')) {
    // Library is not part of a project. "composer install" was executed directly on this library's composer file.
    require('../vendor/autoload.php');
} else {
    // Library is part of a project.
    /** @noinspection PhpIncludeInspection */
    require('../../../autoload.php');
}

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Get OpenWeatherMap object. Don't use caching (take a look into Example_Cache.php to see how it works).
$owm = new OpenWeatherMap();

// Example 1: Get forecast for the next 10 days for Berlin.
$forecast = $owm->getWeatherForecast('Berlin', $units, $lang, '', 10);
echo "EXAMPLE 1<hr />\n\n\n";

echo "City: " . $forecast->city->name;
echo "<br />\n";
echo "LastUpdate: " . $forecast->lastUpdate->format('d.m.Y H:i');
echo "<br />\n";
echo "Sunrise : " . $forecast->sun->rise->format("H:i:s") . " Sunset : " . $forecast->sun->set->format("H:i:s");
echo "<br />\n";
echo "<br />\n";

foreach ($forecast as $weather) {
    // Each $weather contains a Cmfcmf\ForecastWeather object which is almost the same as the Cmfcmf\Weather object.
    // Take a look into 'Examples_Current.php' to see the available options.
    echo "Weather forecast at " . $weather->time->day->format('d.m.Y') . " from " . $weather->time->from->format('H:i') . " to " . $weather->time->to->format('H:i');
    echo "<br />\n";
    echo $weather->temperature;
    echo "<br />\n";
    echo "---";
    echo "<br />\n";
}

// Example 2: Get forecast for the next 3 days for Berlin.
$forecast = $owm->getWeatherForecast('Berlin', $units, $lang, '', 3);
echo "EXAMPLE 2<hr />\n\n\n";

foreach ($forecast as $weather) {
    echo "Weather forecast at " . $weather->time->day->format('d.m.Y') . " from " . $weather->time->from->format('H:i') . " to " . $weather->time->to->format('H:i') . "<br />";
    echo $weather->temperature . "<br />\n";
    echo "---<br />\n";
}
