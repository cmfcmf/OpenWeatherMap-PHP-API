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

namespace Cmfcmf\OpenWeatherMap\Tests\Util;

use \Cmfcmf\OpenWeatherMap\Util\Unit;
use \Cmfcmf\OpenWeatherMap\Util\Temperature;

class TemperatureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $unit = 'Berlin';

    /**
     * @var Temperature
     */
    protected $temperature;

    /**
     * @var string
     */
    protected $nowTemp = '298.77';

    /**
     * @var string
     */
    protected $description = 'This is a description';

    protected function setUp()
    {
        $units = 'Berlin';
        $fakeTempNow = 298.77;
        $fakeTempMin = 298.77;
        $fakeTempMax = 298.774;
        $tempNowUnit = new Unit($fakeTempNow, $units, $this->description);
        $tempMinUnit = new Unit($fakeTempMin, $units, $this->description);
        $tempMaxUnit = new Unit($fakeTempMax, $units, $this->description);
        $this->temperature = new Temperature($tempNowUnit, $tempMinUnit, $tempMaxUnit);
    }

    public function test__toString()
    {
        $expectStr = $this->nowTemp;
        $expectStr .= ' ' . $this->unit;
        $str = $this->temperature->__toString();

        $this->assertSame($expectStr, $str);
        $this->assertInternalType('string', $str);
    }

    public function testGetUnit()
    {
        $expectUnit = $this->unit;
        $unit = $this->temperature->getUnit();

        $this->assertSame($expectUnit, $unit);
        $this->assertInternalType('string', $unit);
    }

    public function testGetValue()
    {
        $expectValue = round($this->nowTemp, 2);
        $value = $this->temperature->getValue();

        $this->assertSame($expectValue, $value);
        $this->assertInternalType('double', $value);
    }

    public function testGetDescription()
    {
        $expectDescription = $this->description;
        $description = $this->temperature->getDescription();

        $this->assertSame($expectDescription, $description);
        $this->assertInternalType('string', $description);
    }

    public function testGetFormatted()
    {
        $expectFormattedString = $this->nowTemp;
        $expectFormattedString .= ' ' . $this->unit;
        $formattedString = $this->temperature->getFormatted();

        $this->assertSame($expectFormattedString, $formattedString);
        $this->assertInternalType('string', $formattedString);
    }
}
