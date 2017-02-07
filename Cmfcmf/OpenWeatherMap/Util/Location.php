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

namespace Cmfcmf\OpenWeatherMap\Util;

/**
 * The city class representing a city object.
 */
class Location
{
    /**
     * @var float The latitude of the city.
     */
    public $lat;

    /**
     * @var float The longitude of the city.
     */
    public $lon;

    /**
     * Create a new location object.
     *
     * @param float  $lat The latitude of the city.
     * @param float  $lon The longitude of the city.
     *
     * @internal
     */
    public function __construct($lat = null, $lon = null)
    {
        $this->lat = isset($lat) ? (float)$lat : null;
        $this->lon = isset($lon) ? (float)$lon : null;
    }
}
