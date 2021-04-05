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

use Cmfcmf\OpenWeatherMap\Util\Weather;

class WeatherTest extends \PHPUnit\Framework\TestCase
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

    protected function setUp(): void
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
