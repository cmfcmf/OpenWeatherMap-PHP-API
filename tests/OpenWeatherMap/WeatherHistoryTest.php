<?php
/**
 * Copyright Zikula Foundation 2014 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPv3 (or at your option any later version).
 * @package OpenWeatherMap-PHP-Api
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

namespace Cmfcmf\OpenWeatherMap\Tests\OpenWeatherMap;

use Cmfcmf\OpenWeatherMap\Tests\FakeData;
use \Cmfcmf\OpenWeatherMap\WeatherHistory;

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
