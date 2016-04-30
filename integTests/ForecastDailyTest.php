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

class ForecastDailyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OpenWeatherMap
     */
    protected $owm;

    protected function setUp()
    {
        $ini = parse_ini_file(__DIR__ . '/ApiKey.ini');
        $apiKey = $ini['api_key'];

        $this->owm = new OpenWeatherMap($apiKey);
    }

    public function testTemperatureMetric()
    {
        $forecast = $this->owm->getWeatherForecast('Berlin', 'metric', 'de', '', 10);

        $now = new \DateTime();
        $this->assertEquals($now->format('d.m.Y H:i'), $forecast->lastUpdate->format('d.m.Y H:i'));

        $this->assertEquals('Berlin', $forecast->city->name);
        $this->assertEquals('05:00:53', $forecast->sun->rise->format("H:i:s"));
        $this->assertEquals('17:25:40', $forecast->sun->set->format("H:i:s"));

        $this->assertEquals(10, iterator_count($forecast));

        $forecast_arr = iterator_to_array($forecast);

        $this->assertEquals('4.59 &deg;C', $forecast_arr[0]->temperature);
        $this->assertEquals('7.34 &deg;C', $forecast_arr[1]->temperature);
        $this->assertEquals('5.58 &deg;C', $forecast_arr[2]->temperature->now);
        $this->assertEquals('6.14 &deg;C', $forecast_arr[3]->temperature);
        $this->assertEquals('7.56 &deg;C', $forecast_arr[4]->temperature);
        $this->assertEquals('10.24 &deg;C', $forecast_arr[5]->temperature);
        $this->assertEquals('9.34 &deg;C', $forecast_arr[6]->temperature);
        $this->assertEquals('10.93 &deg;C', $forecast_arr[7]->temperature->now);
        $this->assertEquals('8.8 &deg;C', $forecast_arr[8]->temperature);
        $this->assertEquals('8.02 &deg;C', $forecast_arr[9]->temperature);

        $this->assertEquals('2.71 &deg;C', $forecast_arr[0]->temperature->min);
        $this->assertEquals('9.07 &deg;C', $forecast_arr[1]->temperature->max);
        $this->assertEquals('8.31 &deg;C', $forecast_arr[2]->temperature->day);
        $this->assertEquals('2.93 &deg;C', $forecast_arr[3]->temperature->morning);
        $this->assertEquals('8.99 &deg;C', $forecast_arr[4]->temperature->evening);
        $this->assertEquals('8.91 &deg;C', $forecast_arr[5]->temperature->night);

        $this->assertEquals('&deg;C', $forecast_arr[6]->temperature->getUnit());
        $this->assertEquals('10.93', $forecast_arr[7]->temperature->getValue());
        $this->assertEmpty($forecast_arr[8]->temperature->getDescription());
        $this->assertEquals('8.02 &deg;C', $forecast_arr[9]->temperature->getFormatted());
    }

    public function testTemperatureImperial()
    {
        $forecast = $this->owm->getWeatherForecast('New York', 'imperial', 'en', '', 10);

        $now = new \DateTime();
        $this->assertEquals($now->format('m-d-Y H:i'), $forecast->lastUpdate->format('m-d-Y H:i'));

        $this->assertEquals('New York', $forecast->city->name);
        $this->assertEquals('10:53:25', $forecast->sun->rise->format("H:i:s"));
        $this->assertEquals('23:11:57', $forecast->sun->set->format("H:i:s"));

        $this->assertEquals(10, iterator_count($forecast));

        $forecast_arr = iterator_to_array($forecast);

        $this->assertEquals('48.88 F', $forecast_arr[0]->temperature);
        $this->assertEquals('55.56 F', $forecast_arr[1]->temperature);
        $this->assertEquals('57.08 F', $forecast_arr[2]->temperature->now);
        $this->assertEquals('50.85 F', $forecast_arr[3]->temperature);
        $this->assertEquals('47.79 F', $forecast_arr[4]->temperature);
        $this->assertEquals('46.21 F', $forecast_arr[5]->temperature);
        $this->assertEquals('47.73 F', $forecast_arr[6]->temperature);
        $this->assertEquals('43.52 F', $forecast_arr[7]->temperature->now);
        $this->assertEquals('34.79 F', $forecast_arr[8]->temperature);
        $this->assertEquals('30.35 F', $forecast_arr[9]->temperature);

        $this->assertEquals('47.75 F', $forecast_arr[0]->temperature->min);
        $this->assertEquals('64.53 F', $forecast_arr[1]->temperature->max);
        $this->assertEquals('69.4 F', $forecast_arr[2]->temperature->day);
        $this->assertEquals('58.71 F', $forecast_arr[3]->temperature->morning);
        $this->assertEquals('49.5 F', $forecast_arr[4]->temperature->evening);
        $this->assertEquals('43.63 F', $forecast_arr[5]->temperature->night);

        $this->assertEquals('F', $forecast_arr[6]->temperature->getUnit());
        $this->assertEquals('43.52', $forecast_arr[7]->temperature->getValue());
        $this->assertEmpty($forecast_arr[8]->temperature->getDescription());
        $this->assertEquals('30.35 F', $forecast_arr[9]->temperature->getFormatted());
    }

    public function testWindMetric()
    {
        $forecast = $this->owm->getWeatherForecast('Moscow', 'metric', 'ru', '', 7);

        $this->assertEquals('Moscow', $forecast->city->name);
        $this->assertEquals('RU', $forecast->city->country);
        $this->assertEquals(524901, $forecast->city->id);
        $this->assertEquals('37.615555', $forecast->city->lon);
        $this->assertEquals('55.75222', $forecast->city->lat);

        $this->assertEquals('03:22:56', $forecast->sun->rise->format("H:i:s"));
        $this->assertEquals('15:50:08', $forecast->sun->set->format("H:i:s"));

        $this->assertEquals(7, iterator_count($forecast));

        $forecast_arr = iterator_to_array($forecast);

        $this->assertEquals('5.41 m/s', $forecast_arr[0]->wind->speed);
        $this->assertEquals('61 ENE', $forecast_arr[1]->wind->direction);
    }
}
