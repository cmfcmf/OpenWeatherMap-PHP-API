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
use Cmfcmf\OpenWeatherMap\Tests\TestFetcher;
use \Cmfcmf\OpenWeatherMap\WeatherHistory;
use \Cmfcmf\OpenWeatherMap\Tests\OpenWeatherMap\ExampleCacheTest;

class OpenWeatherMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var OpenWeatherMap
     */
    protected $owm;

    /**
     * @var ExampleCacheTest
     */
    protected $cache;

    protected function setUp()
    {
        $this->apiKey = 'unicorn-rainbow';
        $this->owm = new OpenWeatherMap($this->apiKey, new TestFetcher(), false, 600);
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
        $weather = $this->owm;
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
        $weather = $this->owm;
        $weather->setApiKey($this->apiKey);
        $apiKey = $weather->getApiKey();

        $this->assertSame($this->apiKey, $apiKey);
    }

    public function testGetApiKey()
    {
        $weather = $this->owm;
        $apiKey = $weather->getApiKey();

        $this->assertSame($this->apiKey, $apiKey);
    }

    public function testGetWeather()
    {
        $currentWeather = $this->owm->getWeather('Berlin', 'imperial', 'en', '');

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeather', $currentWeather);
    }

    public function testGetWeatherGroup()
    {
        $currentWeather = $this->owm->getWeatherGroup('2950159', 'imperial', 'en', '');

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeatherGroup', $currentWeather);
    }

    public function testGetWeatherForecast()
    {
        $days = 1;
        $defaultDay = $this->owm->getWeatherForecast('Berlin', 'imperial', 'en', '', $days);
        
        $days = 16;
        $maxDay = $this->owm->getWeatherForecast('Berlin', 'imperial', 'en', '', $days);

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\WeatherForecast', $defaultDay);
        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\WeatherForecast', $maxDay);
    }

    public function testGetDailyWeatherForecast()
    {
        $days = 16;
        $dailyForecast = $this->owm->getDailyWeatherForecast('Berlin', 'imperial', 'en', '', $days);

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\WeatherForecast', $dailyForecast);
    }

    public function testGetWeatherHistory()
    {
        $this->markTestSkipped('This getWeatherHistory method ignored because the api key need to have a paid permission.');
    }

    public function testWasCached()
    {
        $weather = $this->owm;
        $result = $weather->wasCached();

        $this->assertFalse($result);
    }

    public function testCached()
    {
        $cache = $this->cache;
        $cache->setTempPath(__DIR__.'/temps');
        $weather = new OpenWeatherMap($this->apiKey, new TestFetcher(), $cache, 600);
        $currWeatherData = $weather->getRawWeatherData('Berlin', 'imperial', 'en', $this->apiKey, 'xml');
        $cachedWeatherData = $weather->getRawWeatherData('Berlin', 'imperial', 'en', $this->apiKey, 'xml');
        
        $this->assertInternalType('string', $currWeatherData);
        $this->assertInternalType('string', $cachedWeatherData);
    }

    public function testBuildQueryUrlParameter()
    {
        $weather = $this->owm;
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
