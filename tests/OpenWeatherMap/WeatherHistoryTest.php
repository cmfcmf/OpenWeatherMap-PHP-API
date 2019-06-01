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
use Cmfcmf\OpenWeatherMap\WeatherHistory;

class WeatherHistoryTest extends \PHPUnit_Framework_TestCase
{
    protected $fakeJson;
    protected $history;

    protected function setUp()
    {
        $this->fakeJson = json_decode(FakeData::WEATHER_HISTORY_JSON, true);
        $this->history = new WeatherHistory($this->fakeJson, 'Berlin');
    }

    public function testRewind()
    {
        $expectIndex = 0;
        $this->history->rewind();
        $position = $this->history->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testCurrent()
    {
        $this->history->rewind();
        $current = $this->history->current();

        $this->assertInternalType('object', $current);
    }

    public function testNext()
    {
        $expectIndex = 1;
        $this->history->next();
        $position = $this->history->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testValid()
    {
        $this->history->rewind();
        $this->history->next();
        $this->assertTrue($this->history->valid());
    }

    public function testJsonHasCountryAndPopulation()
    {
        $fakeJson = json_decode(FakeData::WEATHER_HISTORY_WITH_COUNTRY_JSON, true);
        $history = new WeatherHistory($fakeJson, 'Berlin');

        $history->rewind();
        $this->assertTrue($history->valid());
    }

    public function testJsonWithRainKey()
    {
        $fakeJson = json_decode(FakeData::WEATHER_HISTORY_WITH_RAIN_JSON, true);
        $history = new WeatherHistory($fakeJson, 'Berlin');

        $history->rewind();
        $this->assertTrue($history->valid());
    }
}
