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

use Cmfcmf\OpenWeatherMap\Util\City;
use Cmfcmf\OpenWeatherMap\Util\Sun;
use Cmfcmf\OpenWeatherMap\Util\Temperature;
use Cmfcmf\OpenWeatherMap\Util\Unit;
use Cmfcmf\OpenWeatherMap\Util\Weather;
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
     * @param mixed  $data
     * @param string $units
     *
     * @internal
     */
    public function __construct($data, $units)
    {
        // This is kind of a hack, because the units are missing in the document.
        if ($units == 'metric') {
            $windSpeedUnit = 'm/s';
        } else {
            $windSpeedUnit = 'mph';
        }

        $utctz = new \DateTimeZone('UTC');

        if ($data instanceof \SimpleXMLElement) {
            $this->city = new City($data->city['id'], $data->city['name'], $data->city->coord['lat'], $data->city->coord['lon'], $data->city->country);
            $this->temperature = new Temperature(new Unit($data->temperature['value'], $data->temperature['unit']), new Unit($data->temperature['min'], $data->temperature['unit']), new Unit($data->temperature['max'], $data->temperature['unit']));
            $this->humidity = new Unit($data->humidity['value'], $data->humidity['unit']);
            $this->pressure = new Unit($data->pressure['value'], $data->pressure['unit']);
            $this->wind = new Wind(
                new Unit($data->wind->speed['value'], $windSpeedUnit, $data->wind->speed['name']),
                property_exists($data->wind, 'direction') ? new Unit($data->wind->direction['value'], $data->wind->direction['code'], $data->wind->direction['name']) : null
            );
            $this->clouds = new Unit($data->clouds['value'], null, $data->clouds['name']);
            $this->precipitation = new Unit($data->precipitation['value'], $data->precipitation['unit'], $data->precipitation['mode']);
            $this->sun = new Sun(new \DateTime($data->city->sun['rise'], $utctz), new \DateTime($data->city->sun['set'], $utctz));
            $this->weather = new Weather($data->weather['number'], $data->weather['value'], $data->weather['icon']);
            $this->lastUpdate = new \DateTime($data->lastupdate['value'], $utctz);
        } else {
            $this->city = new City($data->id, $data->name, $data->coord->lat, $data->coord->lon, $data->sys->country);
            $this->temperature = new Temperature(new Unit($data->main->temp, $units), new Unit($data->main->temp_min, $units), new Unit($data->main->temp_max, $units));
            $this->humidity = new Unit($data->main->humidity, '%');
            $this->pressure = new Unit($data->main->pressure, 'hPa');
            $this->wind = new Wind(
                new Unit($data->wind->speed, $windSpeedUnit),
                property_exists($data->wind, 'deg') ? new Unit($data->wind->deg) : null
            );
            $this->clouds = new Unit($data->clouds->all, '%');

            // the rain field is not always present in the JSON response
            // and sometimes it contains the field '1h', sometimes the field '3h'
            $rain = isset($data->rain) ? (array) $data->rain : array();
            $rainUnit = !empty($rain) ? key($rain) : '';
            $rainValue = !empty($rain) ? current($rain) : 0.0;
            $this->precipitation = new Unit($rainValue, $rainUnit);

            $this->sun = new Sun(\DateTime::createFromFormat('U', $data->sys->sunrise, $utctz), \DateTime::createFromFormat('U', $data->sys->sunset, $utctz));
            $this->weather = new Weather($data->weather[0]->id, $data->weather[0]->description, $data->weather[0]->icon);
            $this->lastUpdate = \DateTime::createFromFormat('U', $data->dt, $utctz);
        }
    }
}
