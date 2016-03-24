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

namespace Cmfcmf\OpenWeatherMap\IntegTests;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

class CurrentWeatherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \OpenWeatherMap
     */
    protected $owm;

    protected function setUp()
    {

        // Load the app configuration
        $ini = parse_ini_file(__DIR__ . '/ApiKey.ini');
        $apiKey = $ini['api_key'];

        $this->owm = new OpenWeatherMap();
        $this->owm->setApiKey($apiKey);
    }

    public function testByCity()
    {
        // Default units (imperial) and language (English)
        $weather = $this->owm->getWeather('Paris');
        $this->assertEquals('49.39 F', $weather->temperature);

        // Default language (English)
        $weather = $this->owm->getWeather('Atlanta', 'imperial');
        $this->assertEquals(38.18, $weather->temperature->getValue());
        $weather = $this->owm->getWeather('London', 'metric');
        $this->assertEquals(4.66, $weather->temperature->getValue());
        $this->assertEquals('&deg;C', $weather->temperature->getUnit());

        // No defaults
        $weather = $this->owm->getWeather('Chicago', 'imperial', 'en');
        $this->assertEquals('13.88 F', $weather->temperature->getFormatted());
        $weather = $this->owm->getWeather('Prague', 'metric', 'en');
        $this->assertEquals(3.58, $weather->temperature->now->getValue());
        $this->assertEmpty($weather->temperature->min->getDescription());
        $this->assertEquals('3.58 &deg;C', $weather->temperature->max->getFormatted());
    }

    public function testCityNotFound()
    {
        // City doesn't exist
        try {
            $weather = $this->owm->getWeather('InvalidCity');
        } catch (OWMException $e) {
            $this->assertEquals(404, $e->getCode());
            $this->assertEquals('Error: Not found city', $e->getMessage());
        }
    }

    public function testByCityCountry()
    {
        $weather = $this->owm->getWeather('London,ON');

        // Geo coordinates
        $this->assertEquals('-81.23', $weather->city->lon);
        $this->assertEquals('42.98', $weather->city->lat);

        // Country
        $this->assertEquals('CA', $weather->city->country);
    }

    public function testByCityID()
    {
        $weather = $this->owm->getWeather(4930956);
        $this->assertEquals('Boston', $weather->city->name);
    }

    public function testByCoordinates()
    {
        $weather = $this->owm->getWeather(array('lon' => 37.62, 'lat' => 55.75));
        $this->assertEquals($weather->city->country, 'RU');
    }
}
