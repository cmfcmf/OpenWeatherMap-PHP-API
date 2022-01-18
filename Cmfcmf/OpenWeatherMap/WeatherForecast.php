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

use Cmfcmf\OpenWeatherMap\Util\City;
use Cmfcmf\OpenWeatherMap\Util\Sun;

/**
 * Weather class returned by Cmfcmf\OpenWeatherMap->getWeather().
 *
 * @see \Cmfcmf\OpenWeatherMap::getWeather() The function using it.
 */
class WeatherForecast implements \Iterator
{
    /**
     * A city object.
     *
     * @var Util\City
     */
    public $city;

    /**
     * A sun object
     *
     * @var Util\Sun
     */
    public $sun;

    /**
     * The time of the last update of this weather data.
     *
     * @var \DateTime
     */
    public $lastUpdate;

    /**
     * An array of {@link Forecast} objects.
     *
     * @var Forecast[]
     *
     * @see Forecast The Forecast class.
     */
    private $forecasts;

    /**
     * @internal
     */
    private $position = 0;

    /**
     * Create a new Forecast object.
     *
     * @param        $xml
     * @param string $units
     * @param int    $days How many days of forecast to receive.
     *
     * @internal
     */
    public function __construct($xml, $units, $days)
    {
        $this->city = new City($xml->location->location['geobaseid'], $xml->location->name, $xml->location->location['latitude'], $xml->location->location['longitude'], $xml->location->country, null, $xml->location->timezone);
        $utctz = new \DateTimeZone('UTC');
        $this->sun = new Sun(new \DateTime($xml->sun['rise'], $utctz), new \DateTime($xml->sun['set'], $utctz));
        $this->lastUpdate = new \DateTime($xml->meta->lastupdate, $utctz);

        $counter = 0;
        foreach ($xml->forecast->time as $time) {
            $forecast = new Forecast($time, $units);
            $forecast->city = $this->city;
            $forecast->sun = $this->sun;
            $this->forecasts[] = $forecast;

            $counter++;
            // Make sure to only return the requested number of days.
            if ($days <= 5 && $counter == $days * 8) {
                break;
            } elseif ($days > 5 && $counter == $days) {
                break;
            }
        }
    }

    /**
     * @internal
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @internal
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->forecasts[$this->position];
    }

    /**
     * @internal
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->position;
    }

    /**
     * @internal
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        ++$this->position;
    }

    /**
     * @internal
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return isset($this->forecasts[$this->position]);
    }
}
