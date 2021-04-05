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

namespace Cmfcmf\OpenWeatherMap\Tests\Util;

use Cmfcmf\OpenWeatherMap\Util\City;

class CityTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider timezoneDataProvider
     */
    public function testTimezoneConversion($offsetString, $offsetSeconds)
    {
        $class = new \ReflectionClass(City::class);
        $method = $class->getMethod("timezoneOffsetInSecondsToHours");
        $method->setAccessible(true);

        $this->assertSame($offsetString, $method->invoke(null, $offsetSeconds));
        $offsetTimezone = new \DateTimeZone($offsetString);
        $this->assertSame($offsetSeconds, $offsetTimezone->getOffset(new \DateTime("now", new \DateTimeZone("GMT"))));
    }

    public function timezoneDataProvider()
    {
        return [
            ["+0100", 3600],
            ["+0100", 3600],
            ["+0030", 1800],
            ["+0015", 900],
            ["+0000", 0],
            ["+0545", 20700],
        ];
    }
}
