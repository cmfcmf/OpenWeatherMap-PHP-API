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

use Cmfcmf\OpenWeatherMap\Util\Temperature;
use Cmfcmf\OpenWeatherMap\Util\Unit;
use Cmfcmf\OpenWeatherMap\Util\Weather;
use Cmfcmf\OpenWeatherMap\Util\Wind;

/**
 * Class WeatherHistory.
 */
class History
{
    /**
     * The city object.
     *
     * @var Util\City
     */
    public $city;

    /**
     * The temperature object.
     *
     * @var Util\Temperature
     */
    public $temperature;

    /**
     * @var Util\Unit
     */
    public $humidity;

    /**
     * @var Util\Unit
     */
    public $pressure;

    /**
     * @var Util\Wind
     */
    public $wind;

    /**
     * @var Util\Unit
     */
    public $clouds;

    /**
     * @var Util\Unit
     */
    public $precipitation;

    /**
     * @var Util\Weather
     */
    public $weather;

    /**
     * @var \DateTime The time of the history.
     */
    public $time;

    /**
     * @param $city
     * @param $weather
     * @param $temperature
     * @param $pressure
     * @param $humidity
     * @param $clouds
     * @param $rain
     * @param $wind
     * @param $time
     *
     * @internal
     */
    public function __construct($city, $weather, $temperature, $pressure, $humidity, $clouds, $rain, $wind, $time)
    {
        $this->city = $city;
        $this->weather = new Weather($weather['id'], $weather['description'], $weather['icon']);
        $this->temperature = new Temperature(new Unit($temperature['now'] - 273.15, "\xB0C"), new Unit($temperature['min'] - 273.15, "\xB0C"), new Unit($temperature['max'] - 273.15, "\xB0C"));
        $this->pressure = new Unit($pressure, 'kPa');
        $this->humidity = new Unit($humidity, '%');
        $this->clouds = new Unit($clouds, '%');
        $this->precipitation = new Unit($rain['val'], $rain['unit']);
        $this->wind = new Wind(new Unit($wind['speed']), new Unit($wind['deg']));
        $this->time = $time;
    }
}
