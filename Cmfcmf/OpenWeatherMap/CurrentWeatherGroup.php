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
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @internal
     */
    public function current()
    {
        return $this->currentWeathers[$this->position];
    }

    /**
     * @internal
     */
    public function key()
    {
        return $this->current()->city->id;
    }

    /**
     * @internal
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @internal
     */
    public function valid()
    {
        return isset($this->currentWeathers[$this->position]);
    }
}
