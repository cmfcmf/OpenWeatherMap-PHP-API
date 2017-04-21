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
use Cmfcmf\OpenWeatherMap\Util\Time;
use Cmfcmf\OpenWeatherMap\Util\Unit;
use Cmfcmf\OpenWeatherMap\Util\Weather;
use Cmfcmf\OpenWeatherMap\Util\Wind;

/**
 * Class Forecast.
 */
class Forecast extends CurrentWeather
{
    /**
     * @var Time The time of the forecast.
     */
    public $time;

    /**
     * Create a new weather object for forecasts.
     *
     * @param \SimpleXMLElement $xml   The forecasts xml.
     * @param string            $units Ths units used.
     *
     * @internal
     */
    public function __construct(\SimpleXMLElement $xml, $units)
    {
        if ($units == 'metric') {
            $temperatureUnit = "&deg;C";
        } else {
            $temperatureUnit = 'F';
        }

        $xml->temperature['value'] = round((floatval($xml->temperature['max']) + floatval($xml->temperature['min'])) / 2, 2);

        $this->temperature = new Temperature(new Unit($xml->temperature['value'], $temperatureUnit), new Unit($xml->temperature['min'], $temperatureUnit), new Unit($xml->temperature['max'], $temperatureUnit), new Unit($xml->temperature['day'], $temperatureUnit), new Unit($xml->temperature['morn'], $temperatureUnit), new Unit($xml->temperature['eve'], $temperatureUnit), new Unit($xml->temperature['night'], $temperatureUnit));
        $this->humidity = new Unit($xml->humidity['value'], $xml->humidity['unit']);
        $this->pressure = new Unit($xml->pressure['value'], $xml->pressure['unit']);

        // This is kind of a hack, because the units are missing in the xml document.
        if ($units == 'metric') {
            $windSpeedUnit = 'm/s';
        } else {
            $windSpeedUnit = 'mps';
        }

        $this->wind = new Wind(
            new Unit($xml->windSpeed['mps'], $windSpeedUnit, $xml->windSpeed['name']),
            property_exists($xml, 'windDirection') ? new Unit($xml->windDirection['deg'], $xml->windDirection['code'], $xml->windDirection['name']) : null
        );
        $this->clouds = new Unit($xml->clouds['all'], $xml->clouds['unit'], $xml->clouds['value']);
        $this->precipitation = new Unit($xml->precipitation['value'], null, $xml->precipitation['type']);
        $this->weather = new Weather($xml->symbol['number'], $xml->symbol['name'], $xml->symbol['var']);
        $this->lastUpdate = new \DateTime($xml->lastupdate['value']);

        if (isset($xml['from'])) {
            $this->time = new Time($xml['from'], $xml['to']);
        } else {
            $this->time = new Time($xml['day']);
        }
    }
}
