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

namespace Cmfcmf\OpenWeatherMap\Fetcher;

/**
 * Interface FetcherInterface.
 *
 * @api
 */
interface FetcherInterface
{
    /**
     * Fetch contents from the specified url.
     *
     * @param string $url The url to be fetched.
     *
     * @return string The fetched content.
     *
     * @api
     */
    public function fetch($url);
}
