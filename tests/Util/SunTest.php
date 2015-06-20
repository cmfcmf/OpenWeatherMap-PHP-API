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

use Cmfcmf\OpenWeatherMap\Util\Sun;

class SunTest extends \PHPUnit_Framework_TestCase
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


    private function givenThereIsASunObject($rise, $set)
    {
        $this->sun = new Sun($rise, $set);
    }

    /**
     * @expectedException \LogicException
     */
    public function testSunSetBeforeSunRiseException()
    {
        $rise = new \DateTime('2014-01-01 08:00:00');
        $set = new \DateTime('2014-01-01 7:00:00');

        $this->givenThereIsASunObject($rise, $set);
    }
}
