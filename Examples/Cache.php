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
use Cmfcmf\OpenWeatherMap\AbstractCache;

if (file_exists('../vendor/autoload.php')) {
    // Library is not part of a project. "composer install" was executed directly on this library's composer file.
    require('../vendor/autoload.php');
} else {
    // Library is part of a project.
    /** @noinspection PhpIncludeInspection */
    require('../../../autoload.php');
}

/**
 * Example cache implementation.
 *
 * @ignore
 */
class ExampleCache extends AbstractCache
{
    private function urlToPath($url)
    {
        $tmp = sys_get_temp_dir();
        $dir = $tmp . DIRECTORY_SEPARATOR . "OpenWeatherMapPHPAPI";
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $path = $dir . DIRECTORY_SEPARATOR . md5($url);

        return $path;
    }

    /**
     * @inheritdoc
     */
    public function isCached($url)
    {
        $path = $this->urlToPath($url);
        if (!file_exists($path) || filectime($path) + $this->seconds < time()) {
            echo "Weather data is NOT cached!\n";

            return false;
        }

        echo "Weather data is cached!\n";

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getCached($url)
    {
        return file_get_contents($this->urlToPath($url));
    }

    /**
     * @inheritdoc
     */
    public function setCached($url, $content)
    {
        file_put_contents($this->urlToPath($url), $content);
    }
}

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Example 1: Use your own cache implementation. Cache for 10 seconds only in this example.
$owm = new OpenWeatherMap(null, new ExampleCache(), 10);

$weather = $owm->getWeather('Berlin', $units, $lang);
echo "EXAMPLE 1<hr />\n\n\n";
echo $weather->temperature;
