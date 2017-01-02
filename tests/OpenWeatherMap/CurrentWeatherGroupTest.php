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
