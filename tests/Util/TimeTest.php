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

use Cmfcmf\OpenWeatherMap\Util\Time;

class TimeTest extends \PHPUnit\Framework\TestCase
{
    private function createDateTime($time)
    {
        return new \DateTime($time, new \DateTimeZone('UTC'));
    }

    public function testFromTo()
    {
        $fromS = '2014-01-01 08:00:00';
        $toS = '2014-01-01 20:00:00';
        $from = $this->createDateTime($fromS);
        $to = $this->createDateTime($toS);
        $day = $this->createDateTime('2014-01-01');

        $time = new Time($from, $to);
        $this->assertSame($from->format('c'), $time->from->format('c'));
        $this->assertSame($to->format('c'), $time->to->format('c'));
        $this->assertSame($day->format('c'), $time->day->format('c'));

        $time = new Time($fromS, $toS);
        $this->assertSame($from->format('c'), $time->from->format('c'));
        $this->assertSame($to->format('c'), $time->to->format('c'));
        $this->assertSame($day->format('c'), $time->day->format('c'));
    }
    public function testFrom()
    {
        $fromS = '2014-01-01 00:00:00';
        $from = $this->createDateTime($fromS);
        $day = $this->createDateTime('2014-01-01');
        $to = $this->createDateTime('2014-01-01 23:59:59');

        $time = new Time($from);
        $this->assertSame($from->format('c'), $time->from->format('c'));
        $this->assertSame($to->format('c'), $time->to->format('c'));
        $this->assertSame($day->format('c'), $time->day->format('c'));

        $time = new Time($fromS);
        $this->assertSame($from->format('c'), $time->from->format('c'));
        $this->assertSame($to->format('c'), $time->to->format('c'));
        $this->assertSame($day->format('c'), $time->day->format('c'));
    }
}
