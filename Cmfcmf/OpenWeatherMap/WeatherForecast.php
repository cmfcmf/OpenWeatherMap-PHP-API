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

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Util\City;
use Cmfcmf\OpenWeatherMap\Util\Sun;

/**
 * Weather class returned by Cmfcmf\OpenWeatherMap->getWeather().
 *
 * @see Cmfcmf\OpenWeatherMap::getWeather() The function using it.
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
        $this->city = new City(-1, $xml->location->name, $xml->location->location['longitude'], $xml->location->location['latitude'], $xml->location->country);
        $this->sun = new Sun(new \DateTime($xml->sun['rise']), new \DateTime($xml->sun['set']));
        $this->lastUpdate = new \DateTime($xml->meta->lastupdate);

        $counter = 0;
        foreach ($xml->forecast->time as $time) {
            $forecast = new Forecast($time, $units);
            $forecast->city = $this->city;
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
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @internal
     */
    public function current()
    {
        return $this->forecasts[$this->position];
    }

    /**
     * @internal
     */
    public function key()
    {
        return $this->position;
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
        return isset($this->forecasts[$this->position]);
    }
}
