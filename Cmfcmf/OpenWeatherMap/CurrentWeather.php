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
use Cmfcmf\OpenWeatherMap\Util\Temperature;
use Cmfcmf\OpenWeatherMap\Util\Unit;
use Cmfcmf\OpenWeatherMap\Util\Weather as WeatherObj;
use Cmfcmf\OpenWeatherMap\Util\Wind;

/**
 * Weather class used to hold the current weather data.
 */
class CurrentWeather
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
     * @var Util\Sun
     */
    public $sun;

    /**
     * @var Util\Weather
     */
    public $weather;

    /**
     * @var \DateTime
     */
    public $lastUpdate;

    /**
     * Create a new weather object.
     *
     * @param \SimpleXMLElement $xml
     * @param string            $units
     *
     * @internal
     */
    public function __construct(\SimpleXMLElement $xml, $units)
    {
        $this->city = new City($xml->city['id'], $xml->city['name'], $xml->city->coord['lon'], $xml->city->coord['lat'], $xml->city->country);
        $this->temperature = new Temperature(new Unit($xml->temperature['value'], $xml->temperature['unit']), new Unit($xml->temperature['min'], $xml->temperature['unit']), new Unit($xml->temperature['max'], $xml->temperature['unit']));
        $this->humidity = new Unit($xml->humidity['value'], $xml->humidity['unit']);
        $this->pressure = new Unit($xml->pressure['value'], $xml->pressure['unit']);

        // This is kind of a hack, because the units are missing in the xml document.
        if ($units == 'metric') {
            $windSpeedUnit = 'm/s';
        } else {
            $windSpeedUnit = 'mph';
        }
        $this->wind = new Wind(new Unit($xml->wind->speed['value'], $windSpeedUnit, $xml->wind->speed['name']), new Unit($xml->wind->direction['value'], $xml->wind->direction['code'], $xml->wind->direction['name']));

        $this->clouds = new Unit($xml->clouds['value'], null, $xml->clouds['name']);
        $this->precipitation = new Unit($xml->precipitation['value'], $xml->precipitation['unit'], $xml->precipitation['mode']);
        $utctz = new \DateTimeZone('UTC');
        $this->sun = new Sun(new \DateTime($xml->city->sun['rise'], $utctz), new \DateTime($xml->city->sun['set'], $utctz));
        $this->weather = new WeatherObj($xml->weather['number'], $xml->weather['value'], $xml->weather['icon']);
        $this->lastUpdate = new \DateTime($xml->lastupdate['value'], $utctz);
    }
}
