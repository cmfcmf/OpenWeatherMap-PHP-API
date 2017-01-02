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
     * @param string $url The unique url of the cached content.
     *
     * @return bool False if no cached information is available, otherwise true.
     *
     * You need to check if a cached result is outdated here. Return false in that case.
     */
    abstract public function isCached($url);

    /**
     * Returns cached weather data.
     *
     * @param string $url The unique url of the cached content.
     *
     * @return string|bool The cached data if it exists, false otherwise.
     */
    abstract public function getCached($url);

    /**
     * Saves cached weather data.
     *
     * @param string $url     The unique url of the cached content.
     * @param string $content The weather data to cache.
     *
     * @return bool True on success, false on failure.
     */
    abstract public function setCached($url, $content);

    /**
     * Set after how much seconds the cache shall expire.
     *
     * @param int $seconds
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;
    }
}
