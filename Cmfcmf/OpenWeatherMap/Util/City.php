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
class City
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
     * @var float The longitude of the city.
     */
    public $lon;

    /**
     * @var float The latitude of the city.
     */
    public $lat;

    /**
     * @var string The abbreviation of the country the city is located in.
     */
    public $country;

    /**
     * @var int The city's population
     */
    public $population;

    /**
     * Create a new city object.
     *
     * @param int    $id         The city id.
     * @param string $name       The name of the city.
     * @param float  $lon        The longitude of the city.
     * @param float  $lat        The latitude of the city.
     * @param string $country    The abbreviation of the country the city is located in
     * @param int    $population The city's population.
     *
     * @internal
     */
    public function __construct($id, $name = null, $lon = null, $lat = null, $country = null, $population = null)
    {
        $this->id = (int)$id;
        $this->name = isset($name) ? (string)$name : null;
        $this->lon = isset($lon) ? (float)$lon : null;
        $this->lat = isset($lat) ? (float)$lat : null;
        $this->country = isset($country) ? (string)$country : null;
        $this->population = isset($population) ? (int)$population : null;
    }
}
