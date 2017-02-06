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

use Cmfcmf\OpenWeatherMap\Util\Uvi;

/**
 * Weather class used to hold the current weather data.
 */
class CurrentUvi
{
    /**
     * The city object.
     *
     * @var Util\Uvi
     */
    public $uvi;

    /**
     * Create a new uvi object.
     *
     * @param mixed  $data
     *
     * @internal
     */
    public function __construct($data)
    {
        // generate the object from response JSON.
        // ($time, $latitude, $longitude, $data)
        if (empty($data->message) && empty($data->code)) {
            $this->uvi = new Uvi($data->time, $data->location->latitude, $data->location->longitude, $data->data);
        } else {
            $this->uvi = null;
        }
    }
}
