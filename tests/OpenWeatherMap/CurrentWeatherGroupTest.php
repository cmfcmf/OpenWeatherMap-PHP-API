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

use Cmfcmf\OpenWeatherMap\CurrentWeatherGroup;
use Cmfcmf\OpenWeatherMap\Tests\FakeData;

class CurrentWeatherGroupTest extends \PHPUnit_Framework_TestCase
{
    protected $fakeJson;
    protected $currentWeatherGroup;

    public function setUp()
    {
        $this->fakeJson = json_decode(FakeData::WEATHER_GROUP_JSON);
        $this->currentWeatherGroup = new CurrentWeatherGroup($this->fakeJson, 'metric');
    }

    public function testRewind()
    {
        $expectIndex = 1851632;
        $this->currentWeatherGroup->rewind();
        $position = $this->currentWeatherGroup->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testCurrent()
    {
        $this->currentWeatherGroup->rewind();
        $current = $this->currentWeatherGroup->current();

        $this->assertInternalType('object', $current);
    }
    public function testNext()
    {
        $expectIndex = 1851632;
        $this->currentWeatherGroup->next();
        $position = $this->currentWeatherGroup->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testValid()
    {
        $this->currentWeatherGroup->rewind();
        $this->currentWeatherGroup->next();
        $result = $this->currentWeatherGroup->valid();

        $this->assertTrue($result);
    }
}
