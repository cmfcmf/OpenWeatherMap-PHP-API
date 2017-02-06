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

use \Cmfcmf\OpenWeatherMap\Util\Weather;

class WeatherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Weather
     */
    protected $weather;

    /**
     * @var string
     */
    protected $description = 'thunderstorm with light rain';

    /**
     * @var string
     */
    protected $iconName = '11d';

    protected function setUp()
    {
        $this->weather = new Weather(200, $this->description, $this->iconName);
    }

    public function test__toString()
    {
        $expectDescription = $this->description;
        $description = $this->weather->__toString();

        $this->assertSame($expectDescription, $description);
    }

    public function testGetIconUrl()
    {
        $expectIconLink = '//openweathermap.org/img/w/11d.png';
        $weather = $this->weather;
        $iconLink = $weather->getIconUrl();

        $this->assertSame($expectIconLink, $iconLink);
    }

    public function testSetIconUrlTemplate()
    {
        $expectIconLink = '//openweathermap.org';
        $weather = $this->weather;
        $weather::setIconUrlTemplate($expectIconLink);
        $resultLink = $weather->getIconUrl();

        $this->assertSame($expectIconLink, $resultLink);
    }
}
