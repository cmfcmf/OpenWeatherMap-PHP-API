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

class OpenWeatherMapExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var OpenWeatherMap
     */
    protected $owm;

    protected function setUp()
    {
        $this->apiKey = 'unicorn-rainbow';
        $this->owm = new OpenWeatherMap($this->apiKey, new TestFetcher(), false, 600);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCacheException()
    {
        new OpenWeatherMap($this->apiKey, null, true, 600);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSecondNotNumericException()
    {
        new OpenWeatherMap($this->apiKey, null, false, 'I am not numeric');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetWeatherForecastException()
    {
        $days = 20;
        $this->owm->getWeatherForecast('Berlin', 'imperial', 'en', '', $days);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetDailyWeatherForecastException()
    {
        $days = 20;
        $this->owm->getDailyWeatherForecast('Berlin', 'imperial', 'en', '', $days);
    }

    /**
     * @expectedException \Cmfcmf\OpenWeatherMap\Exception
     */
    public function testGetWeatherHistoryException()
    {
        $this->owm->getWeatherHistory('Berlin', new \DateTime('2015-11-01 00:00:00'), 1, 'hour', 'imperial', 'en', '');
    }

    /**
     * @expectedException \Cmfcmf\OpenWeatherMap\Exception
     */
    public function testGetWeatherHistoryWithEndException()
    {
        $this->owm->getWeatherHistory('Berlin', new \DateTime('2015-11-01 00:00:00'), new \DateTime('now'), 'hour', 'imperial', 'en', '');
    }

     /**
      * @expectedException \InvalidArgumentException
      */
    public function testGetWeatherHistoryInvalidArgumentException()
    {
        $this->owm->getWeatherHistory('Berlin', new \DateTime('now'), 1, 'wrong-type', 'imperial', 'en', '');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetRawDailyForecastDataInvalidArgumentException()
    {
        $this->owm->getRawDailyForecastData('Berlin', 'imperial', 'en', '', 'xml', 20);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetRawWeatherHistoryException()
    {
        $this->owm->getRawWeatherHistory('Berlin', new \DateTime('now'), 1, 'wrong-type', 'imperial', 'en', '');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetRawWeatherHistoryWithEndDateException()
    {
        $this->owm->getRawWeatherHistory('Berlin', new \DateTime('now'), 'wrong-endOrCount', 'hour', 'imperial', 'en', '');
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider      uviExceptionDataProvider
     */
    public function testGetRawUviWithQueryErrorException($query)
    {
        $this->owm->getRawUviData($query);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider      uviExceptionDataProvider
     */
    public function testGetRawUviHistoryWithQueryErrorException($query)
    {
        $this->owm->getRawUviHistory($query);
    }
     
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBuildQueryUrlParameterException()
    {
        $this->owm->getWeather(true, 'imperial', 'en', '');
    }

    /**
     * @expectedException \Cmfcmf\OpenWeatherMap\Exception
     */
    public function testParseXMLException()
    {
        $answer = 'I am not XML formatted data';
        $method = new \ReflectionMethod($this->owm, 'parseXML');
        $method->setAccessible(true);
        
        $method->invoke($this->owm, $answer);
    }

    /**
     * @expectedException \Cmfcmf\OpenWeatherMap\Exception
     */
    public function testParseXMLWithIsJsonException()
    {
        $answer = array('message' => 'simple json data');
        $answer = json_encode($answer);
        $method = new \ReflectionMethod($this->owm, 'parseXML');
        $method->setAccessible(true);

        $method->invoke($this->owm, $answer);
    }

    /**
     * @expectedException \Cmfcmf\OpenWeatherMap\Exception
     */
    public function testParseJsonException()
    {
        $answer = 'I am not a json format data';
        $method = new \ReflectionMethod($this->owm, 'parseJson');
        $method->setAccessible(true);
        
        $method->invoke($this->owm, $answer);
    }

    public function uviExceptionDataProvider()
    {
        return array(
            array('error-query-format'),
            array(array())
        );
    }
}
