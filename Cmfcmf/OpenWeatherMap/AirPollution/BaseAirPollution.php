<?php

/*
 * OpenWeatherMap-PHP-API — A PHP API to parse weather data from https://OpenWeatherMap.org.
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of
 * OpenWeatherMap data before using this library:
 *
 * @see https://OpenWeatherMap.org/price
 * @see https://OpenWeatherMap.org/terms
 * @see https://OpenWeatherMap.org/appid
 */

namespace Cmfcmf\OpenWeatherMap\AirPollution;

use Cmfcmf\OpenWeatherMap\Util\Location;

abstract class BaseAirPollution
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
     * @param object $json
     *
     * @throws \Exception
     * @internal
     */
    public function __construct($json)
    {
        $this->time = new \DateTime($json->time, new \DateTimeZone('UTC'));
        $this->location = new Location($json->location->latitude, $json->location->longitude);
    }
}
