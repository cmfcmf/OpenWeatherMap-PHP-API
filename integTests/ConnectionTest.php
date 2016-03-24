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

class ConnectionTest extends \PHPUnit_Framework_TestCase
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
    }

    public function testUnauthorizedAccess()
    {
        try {
            $weather = $this->owm->getWeather('Paris');
        } catch (OWMException $e) {
            $this->assertEquals(401, $e->getCode());
            $this->assertRegExp('/^Invalid API key/', $e->getMessage());
        }
    }
}
