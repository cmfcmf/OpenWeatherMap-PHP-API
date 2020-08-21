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
     * @var \DateTimeZone|null The shift in seconds from UTC
     */
    public $timezone;

    /**
     * Create a new city object.
     *
     * @param int    $id             The city id.
     * @param string $name           The name of the city.
     * @param float  $lat            The latitude of the city.
     * @param float  $lon            The longitude of the city.
     * @param string $country        The abbreviation of the country the city is located in
     * @param int    $population     The city's population.
     * @param int    $timezoneOffset The shift in seconds from UTC.
     *
     * @internal
     */
    public function __construct($id, $name = null, $lat = null, $lon = null, $country = null, $population = null, $timezoneOffset = null)
    {
        $this->id = (int)$id;
        $this->name = isset($name) ? (string)$name : null;
        $this->country = isset($country) ? (string)$country : null;
        $this->population = isset($population) ? (int)$population : null;
        $this->timezone = isset($timezoneOffset) ? new \DateTimeZone(self::timezoneOffsetInSecondsToHours((int)$timezoneOffset)) : null;

        parent::__construct($lat, $lon);
    }

    /**
     * @param int $offset The timezone offset in seconds from UTC.
     * @return int        The timezone offset in +/-HH:MM form.
     */
    private static function timezoneOffsetInSecondsToHours($offset)
    {
        $minutes = floor(abs($offset) / 60) % 60;
        $hours = floor(abs($offset) / 3600);

        $result = $offset < 0 ? "-" : "+";
        $result .= str_pad($hours, 2, "0", STR_PAD_LEFT);
        $result .= str_pad($minutes, 2, "0", STR_PAD_LEFT);

        return $result;
    }
}
