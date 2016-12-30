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

use \Cmfcmf\OpenWeatherMap\WeatherForecast;

class WeatherForecastTest extends \PHPUnit_Framework_TestCase
{
    protected $fakeXml;
    protected $forecast;

    protected function setUp()
    {
        $fakeXml =
        '<weatherdata>
        <location>
            <name>Berlin</name>
            <type></type>
            <country>DE</country>
            <timezone></timezone>
            <location altitude="0" latitude="52.524368" longitude="13.41053" geobase="geonames" geobaseid="2950159"></location>
        </location>
        <credit></credit>
        <meta>
            <lastupdate></lastupdate>
            <calctime>0.0215</calctime>
            <nextupdate>
            </nextupdate>
        </meta>
        <sun rise="2016-12-28T07:17:18" set="2016-12-28T14:59:55"></sun>
        <forecast>
            <time day="2016-12-20">
                <symbol number="500" name="light rain" var="10d"></symbol>
                <precipitation value="0.25" type="rain"></precipitation>
                <windDirection deg="315" code="NW" name="Northwest"></windDirection>
                <windSpeed mps=" 4.38" name="Gentle Breeze"></windSpeed>
                <temperature day="41" min="40.59" max="41" night="40.59" eve="41" morn="41"></temperature>
                <pressure unit="hPa" value="1048.25"></pressure>
                <humidity value="97" unit="%"></humidity>
                <clouds value="overcast clouds" all="92" unit="%"></clouds>
            </time>
            <time day="' . date('Y-m-d') . '">
                <symbol number="500" name="light rain" var="10d"></symbol>
                <precipitation value="0.24" type="rain"></precipitation>
                <windDirection deg="253" code="WSW" name="West-southwest"></windDirection>
                <windSpeed mps="6.2" name="Moderate breeze"></windSpeed>
                <temperature day="40.14" min="28.96" max="40.14" night="28.96" eve="32.11" morn="39.06"></temperature>
                    <pressure unit="hPa" value="1048.09"></pressure>
                    <humidity value="97" unit="%"></humidity>
                    <clouds value="clear sky" all="0" unit="%"></clouds>
            </time>
        </forecast>
        </weatherdata>';
        $this->fakeXml = new \SimpleXMLElement($fakeXml);
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
        $forecast = $this->forecast;
        $forecast->rewind();
        $current = $forecast->current();

        $this->assertInternalType('object', $current);
    }

    public function testNext()
    {
        $forecast = $this->forecast;
        $forecast->rewind();
        $forecast->next();
        $result = $forecast->valid();

        $this->assertFalse($result);
    }

    public function testValid()
    {
        $forecast = $this->forecast;
        $forecast->rewind();
        $forecast->next();
        $result = $forecast->valid();

        $this->assertFalse($result);
    }
}
