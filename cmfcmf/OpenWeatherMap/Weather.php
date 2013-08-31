<?php
/**
 * OpenWeatherMap-PHP-API — An php api to parse weather data from http://www.OpenWeatherMap.org .
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of OpenWeatherMap before using this class.
 * @see http://www.OpenWeatherMap.org
 * @see http://www.OpenWeatherMap.org/about
 * @see http://www.OpenWeatherMap.org/copyright
 * @see http://openweathermap.org/appid
 */

namespace cmfcmf\OpenWeatherMap;

use cmfcmf\OpenWeatherMap,
    cmfcmf\OpenWeatherMap\Exception as OWMException,
    cmfcmf\OpenWeatherMap\Util\City,
    cmfcmf\OpenWeatherMap\Util\Sun,
    cmfcmf\OpenWeatherMap\Util\Temperature,
    cmfcmf\OpenWeatherMap\Util\Unit,
    cmfcmf\OpenWeatherMap\Util\Weather as WeatherObj,
    cmfcmf\OpenWeatherMap\Util\Wind;

/**
 * Weather class returned by {@link OpenWeatherMap::getWeather()}.
 */
class Weather
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
     * The copyright notice. This is no offical text, this hint was made regarding to http://www.http://openweathermap.org/copyright.
     *
     * @var $copyright
     *
     * @see http://www.http://openweathermap.org/copyright http://www.http://openweathermap.org/copyright
     */
    public $copyright = "Weather data from <a href=\"http://www.openweathermap.org\">OpenWeatherMap.org</a>";

    /**
     * Create a new weather object.
     * @param        $query
     * @param string $units
     * @param string $lang
     * @param string $appid
     * @param bool   $cacheClass
     * @param int    $seconds
     *
     * @throws OWMException If OpenWeatherMap returns an error.
     * @throws \Exception If the parameters are invalid.
     *
     * @internal
     */
    public function __construct($query, $units = 'imperial', $lang = 'en', $appid = '', $cacheClass = false, $seconds = 600)
    {
        // Disable default error handling of SimpleXML (Do not throw E_WARNINGs).
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        
        $owm = new OpenWeatherMap($cacheClass, $seconds);
        
        $answer = $owm->getRawWeatherData($query, $units, $lang, $appid, 'xml');
        if ($answer === false) {
            // $query has the wrong format, throw error.
            throw new \Exception('Error: $query has the wrong format. See the documentation of OpenWeatherMap::getRawData() to read about valid formats.');
        }
        
        try {
            $xml = new \SimpleXMLElement($answer);
        } catch(\Exception $e) {
            // Invalid xml format. This happens in case OpenWeatherMap returns an error.
            // OpenWeatherMap always uses json for errors, even if one specifies xml as format.
            $error = json_decode($answer, true);
            if (isset($error['message'])) {
                throw new OWMException($error['message'], $error['cod']);
            } else {
                throw new OWMException('Unknown fatal error: OpenWeatherMap returned the following json object: ' . print_r($error));
            }
        }
        
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
        $this->sun = new Sun(new \DateTime($xml->city->sun['rise']), new \DateTime($xml->city->sun['set']));
        $this->weather = new WeatherObj($xml->weather['number'], $xml->weather['value'], $xml->weather['icon']);
        $this->lastUpdate = new \DateTime($xml->lastupdate['value']);
    }
}
