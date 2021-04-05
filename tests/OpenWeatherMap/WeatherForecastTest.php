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

use Cmfcmf\OpenWeatherMap\Tests\FakeData;
use Cmfcmf\OpenWeatherMap\Tests\MyTestCase;
use Cmfcmf\OpenWeatherMap\WeatherForecast;

class WeatherForecastTest extends MyTestCase
{
    /**
     * @var string
     */
    protected $fakeXml;

    /**
     * @var WeatherForecast
     */
    protected $forecast;

    protected function setUp(): void
    {
        $this->fakeXml = new \SimpleXMLElement(FakeData::forecastXML());
        $this->forecast = new WeatherForecast($this->fakeXml, 'Berlin', 2);
    }

    public function testRewind()
    {
        $forecast = new WeatherForecast($this->fakeXml, 'metric', 2);
        $expectIndex = 0;
        $forecast->rewind();
        $position = $forecast->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testCurrent()
    {
        $this->forecast->rewind();
        $current = $this->forecast->current();

        $this->assertInternalType('object', $current);
    }

    public function testNext()
    {
        $this->forecast->next();
        $this->assertTrue($this->forecast->valid());
    }

    public function testValid()
    {
        $this->assertTrue($this->forecast->valid());
    }
}
