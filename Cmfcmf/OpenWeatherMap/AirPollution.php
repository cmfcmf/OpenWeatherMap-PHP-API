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
 * AirPollution class used to hold the air pollution and time of measurement
 */
class AirPollution
{
    /**
     * @var \DateTime
     */
    public $dateTime;

    /**
     * @var Location
     */
    public $location;

    /**
     * @var AirPollutionData[]
     */
    public $data;

    /**
     * Create a new air pollution object.
     *
     * @param object $json
     *
     * @throws \Exception
     * @internal
     */
    public function __construct($json)
    {
        $this->dateTime = new \DateTime($json->time, new \DateTimeZone('UTC'));
        $this->location = new Location($json->location->latitude, $json->location->longitude);
        $airPollutionData = [];
        foreach ($json->data as $measurement) {
            $airPollutionData[] = new AirPollutionData($measurement);
        }
        $this->data = $airPollutionData;
    }

    /**
     * @return AirPollutionData|null
     */
    public function getLastAirPollutionData()
    {
        if (count($this->data) === 0) {
            return null;
        }

        return reset($this->data);
    }
}
