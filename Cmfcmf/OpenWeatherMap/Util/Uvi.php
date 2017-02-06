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
class Uvi
{
    /**
     * @var string The date time.
     */
    public $time;
    
    /**
     * @var float The latitude.
     */
    public $latitude;

    /**
     * @var float The longitude.
     */
    public $longitude;

    /**
     * @var float The UVI data.
     */
    public $data;

    /**
     * Create a new city object.
     *
     * @param string $time       The current time or time slot.
     * @param float  $latitude   The name of the city.
     * @param float  $longitude  The longitude of the city.
     * @param float  $data       The UVI value.
     *
     * @internal
     */
    public function __construct($time, $latitude, $longitude, $data)
    {
        $this->time = $time;
        $this->latitude = (float)$latitude;
        $this->longitude = (float)$longitude;
        $this->data = (float)$data;
    }
}
