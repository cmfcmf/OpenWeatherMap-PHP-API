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

use Cmfcmf\OpenWeatherMap\Util\Sun;

class SunTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Sun
     */
    private $sun;

    public function testSunRise()
    {
        $rise = new \DateTime('2014-01-01 08:00:00');
        $set = new \DateTime('2014-01-01 20:00:00');

        $this->givenThereIsASunObject($rise, $set);

        $this->assertSame($rise, $this->sun->rise);
    }

    public function testSunSet()
    {
        $rise = new \DateTime('2014-01-01 08:00:00');
        $set = new \DateTime('2014-01-01 20:00:00');

        $this->givenThereIsASunObject($rise, $set);

        $this->assertSame($set, $this->sun->set);
    }

    public function testSunSetBeforeSunRiseException()
    {
        $this->expectException(\LogicException::class);

        $rise = new \DateTime('2014-01-01 08:00:00');
        $set = new \DateTime('2014-01-01 7:00:00');

        $this->givenThereIsASunObject($rise, $set);
    }

    private function givenThereIsASunObject($rise, $set)
    {
        $this->sun = new Sun($rise, $set);
    }
}
