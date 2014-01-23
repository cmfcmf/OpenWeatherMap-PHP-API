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

namespace Cmfcmf\OpenWeatherMap;

/**
 * Abstract cache class to be overwritten by custom cache implementations.
 */
abstract class AbstractCache
{
    /**
     * @var int $seconds Cache time in seconds.
     */
    protected $seconds;

    /**
     * Checks whether a cached weather data is available.
     *
     * @param string $type The type of the cached data. Can be either 'weather', 'hourlyForecast' or 'dailyForecast'.
     * @param array|int|string $query The query parameters used.
     * @param string $units The units requested.
     * @param string $lang  The language requested.
     * @param string $mode The mode requested ('xml' or'json').
     *
     * @return \DateTime|bool A \DateTime object containing the time when the weather information was last updated, false if no
     * cached information is available.
     *
     * @note This is not the time when the weather was cached, but the {@link Weather::$lastUpdate} value of the cached weather.
     * @note You need to check here if a cached result is outdated. Return false in that case.
     */
    public abstract function isCached($type, $query, $units, $lang, $mode);

    /**
     * Returns cached weather data.
     *
     * @param string $type The type of the cached data. Can be either 'weather', 'hourlyForecast' or 'dailyForecast'.
     * @param array|int|string $query The query parameters used.
     * @param string $units The units requested.
     * @param string $lang  The language requested.
     * @param string $mode The mode requested ('xml' or'json').
     *
     * @return string|bool The cached data if it exists, false otherwise.
     */
    public abstract function getCached($type, $query, $units, $lang, $mode);

    /**
     * Saves cached weather data.
     *
     * @param string $type The type of the cached data. Can be either 'weather', 'hourlyForecast' or 'dailyForecast'.
     * @param string $content The weather data to cache.
     * @param array|int|string $query The query parameters used.
     * @param string $units The units requested.
     * @param string $lang  The language requested.
     * @param string $mode The mode requested ('xml' or'json').
     *
     * @return bool True on success, false on failure.
     */
    public abstract function setCached($type, $content, $query, $units, $lang, $mode);

    /**
     * Set after how much seconds the cache shall expire.
     * @param int $seconds
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;
    }
}
