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

/**
 * Class CurrentWeatherGroup used to hold the current weather data for a group of cities.
 */
class CurrentWeatherGroup implements \Iterator
{
    /**
     * An array of {@link CurrentWeather} objects.
     *
     * @var CurrentWeather[]
     *
     * @see CurrentWeather The CurrentWeather class.
     */
    private $currentWeathers;

    /**
     * @internal
     */
    private $position = 0;

    /**
     * Create a new current weathers group object.
     *
     * @param \stdClass $json  The current weathers group json.
     * @param string    $units The units used.
     *
     * @internal
     */
    public function __construct(\stdClass $json, $units)
    {
        foreach ($json->list as $currentWeather) {
            $this->currentWeathers[] = new CurrentWeather($currentWeather, $units);
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
        return $this->currentWeathers[$this->position];
    }

    /**
     * @internal
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->current()->city->id;
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
        return isset($this->currentWeathers[$this->position]);
    }
}
