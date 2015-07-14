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

class UnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Unit
     */
    private $unit;

    const POSITIVE_INT_VALUE = 23;

    const POSITIVE_FLOAT_VALUE = 48.23534;

    const NEGATIVE_INT_VALUE = -30;

    const NEGATIVE_FLOAT_VALUE = -93.45839;

    const ZERO_INT_VALUE = 0;

    const ZERO_FLOAT_VALUE = 0.0;

    public function testGetValueWithPositiveIntValue()
    {
        $this->givenThereIsAUnitWithValue(self::POSITIVE_INT_VALUE);

        $this->assertSame((float)self::POSITIVE_INT_VALUE, $this->unit->getValue());
    }

    public function testGetValueWithPositiveFloatValue()
    {
        $this->givenThereIsAUnitWithValue(self::POSITIVE_FLOAT_VALUE);

        $this->assertSame(self::POSITIVE_FLOAT_VALUE, $this->unit->getValue());
    }

    public function testGetValueWithNegativeIntValue()
    {
        $this->givenThereIsAUnitWithValue(self::NEGATIVE_INT_VALUE);

        $this->assertSame((float)self::NEGATIVE_INT_VALUE, $this->unit->getValue());
    }

    public function testGetValueWithNegativeFloatValue()
    {
        $this->givenThereIsAUnitWithValue(self::NEGATIVE_FLOAT_VALUE);

        $this->assertSame(self::NEGATIVE_FLOAT_VALUE, $this->unit->getValue());
    }

    public function testGetValueWithZeroIntValue()
    {
        $this->givenThereIsAUnitWithValue(self::ZERO_INT_VALUE);

        $this->assertSame((float)self::ZERO_INT_VALUE, $this->unit->getValue());
    }

    public function testGetValueWithZeroFloatValue()
    {
        $this->givenThereIsAUnitWithValue(self::ZERO_FLOAT_VALUE);

        $this->assertSame(self::ZERO_FLOAT_VALUE, $this->unit->getValue());
    }

    private function givenThereIsAUnitWithValue($value, $unit = null)
    {
        $this->unit = $unit === null ? new Unit($value) : new Unit($value, $unit);
    }

    public function testGetUnitWithEmptyUnit()
    {
        $this->givenThereIsAUnitWithUnit("");

        $this->assertSame("", $this->unit->getUnit());
    }

    public function testGetUnitWithStringAsUnit()
    {
        $this->givenThereIsAUnitWithUnit("Hey! I'm cmfcmf");

        $this->assertSame("Hey! I'm cmfcmf", $this->unit->getUnit());
    }

    public function testCelsiusFix()
    {
        $this->givenThereIsAUnitWithUnit("celsius");

        $this->assertSame("&deg;C", $this->unit->getUnit());
    }

    public function testMetricFix()
    {
        $this->givenThereIsAUnitWithUnit("metric");

        $this->assertSame("&deg;C", $this->unit->getUnit());
    }

    public function testFahrenheitFix()
    {
        $this->givenThereIsAUnitWithUnit("fahrenheit");

        $this->assertSame("F", $this->unit->getUnit());
    }

    private function givenThereIsAUnitWithUnit($unit)
    {
        $this->unit = new Unit(0, $unit);
    }

    public function testGetDescriptionWithEmptyDescription()
    {
        $this->givenThereIsAUnitWithDescription("");

        $this->assertSame("", $this->unit->getDescription());
    }

    public function testGetDescriptionWithStringAsDescription()
    {
        $this->givenThereIsAUnitWithDescription("Hey! I'm cmfcmf");

        $this->assertSame("Hey! I'm cmfcmf", $this->unit->getDescription());
    }

    private function givenThereIsAUnitWithDescription($description)
    {
        $this->unit = new Unit(0, "", $description);
    }

    public function testGetFormattedWithoutUnit()
    {
        $this->givenThereIsAUnitWithValue(self::POSITIVE_INT_VALUE);

        $this->assertEquals(self::POSITIVE_INT_VALUE, $this->unit->getFormatted());
        $this->assertEquals($this->unit->getValue(), $this->unit->getFormatted());
    }

    public function testGetFormattedWithUnit()
    {
        $this->givenThereIsAUnitWithValue(self::POSITIVE_INT_VALUE, 'K');

        $this->assertEquals(self::POSITIVE_INT_VALUE . ' K', $this->unit->getFormatted());
        $this->assertEquals($this->unit->getValue() . ' ' . $this->unit->getUnit(), $this->unit->getFormatted());
    }

    public function testToString()
    {
        $this->givenThereIsAUnitWithValue(self::POSITIVE_INT_VALUE, 'K');

        $this->assertEquals($this->unit->getFormatted(), $this->unit);
    }
}
