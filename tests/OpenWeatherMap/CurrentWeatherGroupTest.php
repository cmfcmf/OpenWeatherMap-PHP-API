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

use \Cmfcmf\OpenWeatherMap\CurrentWeatherGroup;
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
        $currentWeatherGroup = $this->currentWeatherGroup;
        $currentWeatherGroup->rewind();
        $position = $currentWeatherGroup->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testCurrent()
    {
        $currentWeatherGroup = $this->currentWeatherGroup;
        $currentWeatherGroup->rewind();
        $current = $currentWeatherGroup->current();

        $this->assertInternalType('object', $current);
    }
    public function testNext()
    {
        $expectIndex = 1851632;
        $currentWeatherGroup = $this->currentWeatherGroup;
        $currentWeatherGroup->next();
        $position = $currentWeatherGroup->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testValid()
    {
        $currentWeatherGroup = $this->currentWeatherGroup;
        $currentWeatherGroup->rewind();
        $currentWeatherGroup->next();
        $result = $currentWeatherGroup->valid();

        $this->assertTrue($result);
    }
}
