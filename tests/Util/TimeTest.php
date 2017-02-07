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

use Cmfcmf\OpenWeatherMap\Util\Time;

class TimeTest extends \PHPUnit_Framework_TestCase
{
    public function testFromTo()
    {
        $fromS = '2014-01-01 08:00:00';
        $toS = '2014-01-01 20:00:00';
        $from = new \DateTime($fromS);
        $to = new \DateTime($toS);
        $day = new \DateTime('2014-01-01');

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
        $from = new \DateTime($fromS);
        $day = new \DateTime('2014-01-01');
        $to = new \DateTime('2014-01-01 23:59:59');

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
