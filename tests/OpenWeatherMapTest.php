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

use \Cmfcmf\OpenWeatherMap;
use \Cmfcmf\OpenWeatherMap\WeatherHistory;
use \Cmfcmf\OpenWeatherMap\Tests\OpenWeatherMap\ExampleCacheTest;

class OpenWeatherMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var apiKey
     * @var weather
     * @var cache
     */
    protected $apiKey;
    protected $weather;
    protected $cache;

    protected function setUp()
    {
        $ini = parse_ini_file(__DIR__ . '/ApiKey.ini');
        $apiKey = $ini['api_key'];
        $this->apiKey = $apiKey;
        $this->weather = new OpenWeatherMap($this->apiKey, null, false, 600);
        $this->cache = new ExampleCacheTest();
    }

    protected function tearDown()
    {
        $fileList = glob(__DIR__.'/temps/OpenWeatherMapPHPAPI/*');
        foreach ($fileList as $fileName) {
            @unlink($fileName);
        }

        @rmdir(__DIR__.'/temps/OpenWeatherMapPHPAPI');
        @rmdir(__DIR__.'/temps');
    }

    public function testApiKeyIsEmpty()
    {
        $expectApiKey = '';
        $weather = new OpenWeatherMap($expectApiKey, null, false, 600);
        $apiKey = $weather->getApiKey();

        $this->assertSame($expectApiKey, $apiKey);
    }

    public function testApiKeyNotNull()
    {
        $weather = $this->weather;
        $apiKey = $weather->getApiKey();

        $this->assertSame($this->apiKey, $apiKey);
    }

    public function testSecondIsZero()
    {
        $weather = new OpenWeatherMap($this->apiKey, null, false, 0);
        $apiKey = $weather->getApiKey();

        $this->assertSame($this->apiKey, $apiKey);
    }

    public function testSetApiKey()
    {
        $weather = $this->weather;
        $weather->setApiKey($this->apiKey);
        $apiKey = $weather->getApiKey();

        $this->assertSame($this->apiKey, $apiKey);
    }

    public function testGetApiKey()
    {
        $weather = $this->weather;
        $apiKey = $weather->getApiKey();

        $this->assertSame($this->apiKey, $apiKey);
    }

    public function testGetWeather()
    {
        $weather = $this->weather;
        $currentWeather = $weather->getWeather('Berlin', 'imperial', 'en', '');

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeather', $currentWeather);
    }

    public function testGetWeatherGroup()
    {
        $weather = $this->weather;
        $currentWeather = $weather->getWeatherGroup('2950159', 'imperial', 'en', '');

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeatherGroup', $currentWeather);
    }

    public function testGetWeatherForecast()
    {
        $days = 1;
        $weather = $this->weather;
        $defaultDay = $weather->getWeatherForecast('Berlin', 'imperial', 'en', '', $days);
        
        $days = 16;
        $maxDay = $weather->getWeatherForecast('Berlin', 'imperial', 'en', '', $days);

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\WeatherForecast', $defaultDay);
        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\WeatherForecast', $maxDay);
    }

    public function testGetDailyWeatherForecast()
    {
        $days = 16;
        $weather = $this->weather;
        $dailyForecast = $weather->getDailyWeatherForecast('Berlin', 'imperial', 'en', '', $days);

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\WeatherForecast', $dailyForecast);
    }

    public function testGetWeatherHistory()
    {
        $this->markTestSkipped('This getWeatherHistory method ignored because the api key need to have a paid permission.');
    }

    public function testWasCached()
    {
        $weather = $this->weather;
        $result = $weather->wasCached();

        $this->assertFalse($result);
    }

    public function testCached()
    {
        $sampleUrl = 'http://api.openweathermap.org/data/2.5/weather?q=Berlin&units=imperial&lang=en&mode=json&APPID=50b2ae8523a458183982bf56254556dc';

        $cache = $this->cache;
        $cache->setTempPath(__DIR__.'/temps');
        $weather = new OpenWeatherMap($this->apiKey, null, $cache, 600);
        $currWeatherData = $weather->getRawWeatherData('Berlin', 'imperial', 'en', $this->apiKey, 'json');
        $cachedWeatherData = $weather->getRawWeatherData('Berlin', 'imperial', 'en', $this->apiKey, 'json');
        
        $this->assertInternalType('string', $currWeatherData);
        $this->assertInternalType('string', $cachedWeatherData);
    }

    public function testBuildQueryUrlParameter()
    {
        $weather = $this->weather;
        $queryWithNumbericArray = $weather->getWeather(array('2950159'), 'imperial', 'en', '');
        $queryWithLatLonArray = $weather->getWeather(array('lat' => 52.524368, 'lon' => 13.410530), 'imperial', 'en', '');

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeather', $queryWithNumbericArray);
        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeather', $queryWithLatLonArray);
    }

    public function testAbstractCache()
    {
        $sut = $this->getMockForAbstractClass('\Cmfcmf\OpenWeatherMap\AbstractCache');
        $this->assertNull($sut->setSeconds(10));
    }
}
