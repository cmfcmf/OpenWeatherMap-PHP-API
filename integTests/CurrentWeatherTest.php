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
     * @var OpenWeatherMap
     */
	protected $apiKey;
    protected $owm;

    protected function setUp()
    {
        // Load the app configuration
        $ini = parse_ini_file(__DIR__ . '/ApiKey.ini');
        $this->apiKey = $ini['api_key'];

        $this->owm = new OpenWeatherMap();
        $this->owm->setApiKey($this->apiKey);
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
            $this->owm->getWeather('InvalidCity');
        } catch (OWMException $e) {
            $this->assertEquals(404, $e->getCode());
            $this->assertEquals('Error: Not found city', $e->getMessage());
        }
    }

    public function testByCityCountry()
    {
        $weather = $this->owm->getWeather('London,CA');

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
        $this->assertEquals('RU', $weather->city->country);
    }

	public function testCurrentBulkCheck()
	{
		// Download the test data set
		$testDataUrl =
			"https://raw.githubusercontent.com/aseriy/OpenWeatherMap-VirtSrvc/master/testdata/" .
			"$this->apiKey/current/00.json";
		$testDataJson = file_get_contents($testDataUrl);
		$testData = json_decode($testDataJson, true);

		foreach ($testData as $c) {
			$weather = $this->owm->getWeather($c["city_id"], $c["units"], 'en');
	        $this->assertEquals($c["city_name"], $weather->city->name, "city name");
	        $this->assertEquals($c["country"], $weather->city->country, "country in " . $c["city_name"]);
	        $this->assertEquals($c["temp"], $weather->temperature->getValue(), "temperature in " . $c["city_name"]);
	        $this->assertEquals($c["temp_min"], $weather->temperature->min->getValue(), "minimum temperature in " . $c["city_name"]);
	        $this->assertEquals($c["temp_max"], $weather->temperature->max->getValue(), "maximum temperature in " . $c["city_name"]);
	        $this->assertEquals($c["wind_speed"], $weather->wind->speed->getValue(), "wind speed in " . $c["city_name"]);
	        $this->assertEquals($c["pressure"], $weather->pressure->getValue(), "pressure in " . $c["city_name"]);
	        $this->assertEquals($c["humidity"], $weather->humidity->getValue(), "humidity in " . $c["city_name"]);
		}
	}	
}
