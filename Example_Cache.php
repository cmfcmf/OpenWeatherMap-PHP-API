<?php
/**
 * OpenWeatherMap-PHP-API — An php api to parse weather data from http://www.OpenWeatherMap.org .
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of OpenWeatherMap before using this class.
 * @see http://www.OpenWeatherMap.org
 * @see http://www.OpenWeatherMap.org/about
 * @see http://www.OpenWeatherMap.org/copyright
 * @see http://openweathermap.org/appid
 */

use cmfcmf\OpenWeatherMap;
use cmfcmf\OpenWeatherMap\AbstractCache;

require('cmfcmf/OpenWeatherMap.php');

/**
 * Example cache implementation.
 *
 * @ignore
 */
class ExampleCache extends AbstractCache
{
    /**
     * @inheritdoc
     */
    public function isCached($type, $query, $units, $lang, $mode)
    {
        echo "Checking cache for $type $query $units $lang $mode …<br />";
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getCached($type, $query, $units, $lang, $mode)
    {
        echo "Get cache for $type $query $units $lang $mode …<br />";
        return false;
    }

    /**
     * @inheritdoc
     */
    public function setCached($type, $content, $query, $units, $lang, $mode)
    {
        echo "Set cache for $type $query $units $lang $mode … ({$this->seconds} seconds)<br />";
        return false;
    }
}

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Example 1: Use your own cache implementation. See the example_cache file.
$owm = new OpenWeatherMap('ExampleCache', 100);

$weather = $owm->getWeather('Berlin', $units, $lang);
echo "EXAMPLE 1<hr />\n\n\n";
echo $weather->temperature;
