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
use \Cmfcmf\OpenWeatherMap\WeatherForecast;

class WeatherForecastTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $fakeXml;

    /**
     * @var WeatherForecast
     */
    protected $forecast;

    protected function setUp()
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
        $this->forecast->rewind();
        $this->forecast->next();
        $result = $this->forecast->valid();

        $this->assertFalse($result);
    }

    public function testValid()
    {
        $this->forecast->rewind();
        $this->forecast->next();
        $result = $this->forecast->valid();

        $this->assertFalse($result);
    }
}
