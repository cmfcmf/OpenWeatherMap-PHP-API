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

require_once __DIR__ . '/bootstrap.php';

/**
 * Example cache implementation.
 *
 * @ignore
 */
class ExampleCache extends AbstractCache
{
    protected $tmp;

    public function __construct()
    {
        $this->tmp = sys_get_temp_dir();
    }

    private function urlToPath($url)
    {
        $dir = $this->tmp . DIRECTORY_SEPARATOR . "OpenWeatherMapPHPAPI";
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

    /**
     * @inheritdoc
     */
    public function setTempPath($path)
    {
        if (!is_dir($path)) {
            mkdir($path);
        }
        
        $this->tmp = $path;
    }
}

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Example 1: Use your own cache implementation. Cache for 10 seconds only in this example.
$cache = new ExampleCache();
$cache->setTempPath(__DIR__.'/temps');
$owm = new OpenWeatherMap($myApiKey, null, $cache, 10);

$weather = $owm->getWeather('Berlin', $units, $lang);
echo "EXAMPLE 1<hr />\n\n\n";
echo $weather->temperature;
