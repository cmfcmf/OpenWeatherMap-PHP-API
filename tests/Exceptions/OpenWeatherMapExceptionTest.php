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

class OpenWeatherMapExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var apiKey
     * @var weather
     */
    protected $apiKey;
    protected $weather;

    protected function setUp()
    {
        $ini = parse_ini_file(__DIR__ . '/../ApiKey.ini');
        $apiKey = $ini['api_key'];
        $this->apiKey = $apiKey;
        $this->weather = new OpenWeatherMap($this->apiKey, null, false, 600);
    }

    /**
     * @expectedException Exception
     */
    public function testCacheException()
    {
        try {
            $exception = new OpenWeatherMap($this->apiKey, null, true, 600);
        } catch (\Eception $e) {
            throw $e;
        }
    }

    /**
     * @expectedException Exception
     */
    public function testSecondNotNumbericException()
    {
        try {
            $exception = new OpenWeatherMap($this->apiKey, null, false, 'I am not numberic');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetWeatherForecastException()
    {
        $days = 20;
        $weather = $this->weather;

        try {
            $argException = $weather->getWeatherForecast('Berlin', 'imperial', 'en', '', $days);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetDailyWeatherForecastException()
    {
        $days = 20;
        $weather = $this->weather;

        try {
            $argException = $weather->getDailyWeatherForecast('Berlin', 'imperial', 'en', '', $days);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @expectedException \Cmfcmf\OpenWeatherMap\Exception
     */
    public function testGetWeatherHistoryException()
    {
        $weather = $this->weather;

        try {
            $oWMException = $weather->getWeatherHistory('Berlin', new \DateTime('2015-11-01 00:00:00'), 1, 'hour', 'imperial', 'en', '');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @expectedException \Cmfcmf\OpenWeatherMap\Exception
     */
    public function testGetWeatherHistoryWithEndException()
    {
        $weather = $this->weather;

        try {
            $oWMException = $weather->getWeatherHistory('Berlin', new \DateTime('2015-11-01 00:00:00'), new \DateTime('NOW'), 'hour', 'imperial', 'en', '');
        } catch (\Exception $e) {
            throw $e;
        }
    }

     /**
      * @expectedException InvalidArgumentException
      */
    public function testGetWeatherHistoryInvalidArgumentException()
    {
        $weather = $this->weather;

        try {
            $argException = $weather->getWeatherHistory('Berlin', new \DateTime('NOW'), 1, 'wrong-type', 'imperial', 'en', '');
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetRawDailyForecastDataInvalidArgumentException()
    {
        $weather = $this->weather;
        
        try {
            $argException = $weather->getRawDailyForecastData('Berlin', 'imperial', 'en', '', 'xml', 20);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetRawWeatherHistoryException()
    {
        $weather = $this->weather;
        
        try {
            $argException = $weather->getRawWeatherHistory('Berlin', new \DateTime('NOW'), 1, 'wrong-type', 'imperial', 'en', '');
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetRawWeatherHistoryWithEndDateException()
    {
        $weather = $this->weather;
        
        try {
            $argException = $weather->getRawWeatherHistory('Berlin', new \DateTime('NOW'), 'wrong-endOrCount', 'hour', 'imperial', 'en', '');
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }
     
    /**
     * @expectedException InvalidArgumentException
     */
    public function testBuildQueryUrlParameterException()
    {
        $weather = $this->weather;
        
        try {
            $argException = $weather->getWeather(true, new \DateTime('NOW'), 'wrong-endOrCount', 'hour', 'imperial', 'en', '');
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @expectedException Exception
     */
    public function testParseXMLException()
    {
        $answer = 'I am not a XML fromat data';
        $weather = $this->weather;
        $method = new \ReflectionMethod(
            $weather, 'parseXML'
        );
        $method->setAccessible(true);
        
        try {
            $method->invoke($weather, $answer);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @expectedException Exception
     */
    public function testParseXMLWithIsJsonException()
    {
        $answer = array('message' => 'simple json data');
        $answer = json_encode($answer);
        $weather = $this->weather;
        $method = new \ReflectionMethod(
            $weather, 'parseXML'
        );
        $method->setAccessible(true);

        try {
            $method->invoke($weather, $answer);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @expectedException \Cmfcmf\OpenWeatherMap\Exception
     */
    public function testParseJsonException()
    {
        $weather = $this->weather;
        $answer = 'I am not a json format data';
        $method = new \ReflectionMethod(
            $weather, 'parseJson'
        );
        $method->setAccessible(true);
        
        try {
            $method->invoke($weather, $answer);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
