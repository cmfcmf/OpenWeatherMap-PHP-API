<?php

/*
 * OpenWeatherMap-PHP-API — A PHP API to parse weather data from https://OpenWeatherMap.org.
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of
 * OpenWeatherMap data before using this library:
 *
 * @see https://OpenWeatherMap.org/price
 * @see https://OpenWeatherMap.org/terms
 * @see https://OpenWeatherMap.org/appid
 */

namespace Cmfcmf\OpenWeatherMap\Tests\OpenWeatherMap;

use Cmfcmf\OpenWeatherMap\CurrentWeather;
use Cmfcmf\OpenWeatherMap\Tests\FakeData;

class CurrentWeatherTest extends \PHPUnit\Framework\TestCase
{
    public function testWindDirection()
    {
        $fakeXml = new \SimpleXMLElement(FakeData::CURRENT_WEATHER_XML);
        $weather = new CurrentWeather($fakeXml, "metric");
        $this->assertSame($weather->wind->direction->getValue(), 300.0);

        $fakeXml = new \SimpleXMLElement(FakeData::CURRENT_WEATHER_XML_NO_WIND_DIRECTION);
        $weather = new CurrentWeather($fakeXml, "metric");
        $this->assertNull($weather->wind->direction);
    }
}
