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

namespace Cmfcmf\OpenWeatherMap\Util;

/**
 * The city class representing a city object.
 */
class City extends Location
{
    /**
     * @var int The city id.
     */
    public $id;

    /**
     * @var string The name of the city.
     */
    public $name;

    /**
     * @var string The abbreviation of the country the city is located in.
     */
    public $country;

    /**
     * @var int The city's population
     */
    public $population;

    /**
     * @var int The shift in seconds from UTC
     */
    public $timezone;
    /**
     * Create a new city object.
     *
     * @param int    $id         The city id.
     * @param string $name       The name of the city.
     * @param float  $lat        The latitude of the city.
     * @param float  $lon        The longitude of the city.
     * @param string $country    The abbreviation of the country the city is located in
     * @param int    $population The city's population.
     * @param int    $timezone   The shift in seconds from UTC.
     *
     * @internal
     */
    public function __construct($id, $name = null, $lat = null, $lon = null, $country = null, $population = null, $timezone = null)
    {
        $this->id = (int)$id;
        $this->name = isset($name) ? (string)$name : null;
        $this->country = isset($country) ? (string)$country : null;
        $this->population = isset($population) ? (int)$population : null;
        $this->timezone = isset($timezone) ? (int)$timezone : null;

        parent::__construct($lat, $lon);
    }
}
