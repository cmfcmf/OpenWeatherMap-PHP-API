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
$lang = 'en';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Get OpenWeatherMap object. Don't use caching (take a look into Example_Cache.php to see how it works).
$owm = new OpenWeatherMap();

// Example 1: Get hourly weather history between 2014-01-01 and today.
$history = $owm->getWeatherHistory('Berlin', new \DateTime('2014-01-01'), new \DateTime('now'), 'hour', $units, $lang);

foreach ($history as $weather) {
    echo "Average temperature at " . $weather->time->format('d.m.Y H:i') . ": " . $weather->temperature . "\n\r<br />";
}
