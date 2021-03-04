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
     * @param float $lat
     * @param float $lon
     * @throws \Exception
     * @internal
     */
    public function __construct($data, $lat = null, $lon = null)
    {
        if (isset($data->dt)) {
            $this->time = \DateTime::createFromFormat('U', $data->dt);
        } else {
            $utctz = new \DateTimeZone('UTC');
            $this->time = new \DateTime($data->date_iso, $utctz);
        }
        $this->location = new Location($data->lat ?? $lat, $data->lon ?? $lon);
        if (isset($data->uvi)) {
            $this->uvIndex = (float)$data->uvi;
        } else {
            $this->uvIndex = (float)$data->value;
        }
    }
}
