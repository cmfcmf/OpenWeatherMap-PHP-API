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

use Cmfcmf\OpenWeatherMap\Util\Location;

/**
 * UVIndex class used to hold the uv index for a given date, time and location.
 */
class UVIndex
{
    /**
     * @var \DateTime
     */
    public $time;

    /**
     * @var Location
     */
    public $location;

    /**
     * @var float
     */
    public $uvIndex;

    /**
     * Create a new current uv index object.
     *
     * @param object $data
     *
     * @internal
     */
    public function __construct($data)
    {
        $this->time = new \DateTime($data->time);
        $this->location = new Location($data->location->latitude, $data->location->longitude);
        $this->uvIndex = (float)$data->data;
    }
}
