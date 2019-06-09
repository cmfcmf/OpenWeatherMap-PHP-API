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

namespace Cmfcmf\OpenWeatherMap\Tests\OpenWeatherMap;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Tests\TestHttpClient;
use Http\Factory\Guzzle\RequestFactory;

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
        $this->owm = new OpenWeatherMap($this->apiKey, new TestHttpClient(), new RequestFactory());
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
     * @expectedException \InvalidArgumentException
     */
    public function testGetRawDailyForecastDataInvalidArgumentException()
    {
        $this->owm->getRawDailyForecastData('Berlin', 'imperial', 'en', '', 'xml', 20);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider      uvIndexExceptionDataProvider
     */
    public function testGetRawUVIndexWithQueryErrorException($mode, $lat, $lon, $cnt, $start, $end)
    {
        $this->owm->getRawUVIndexData($mode, $lat, $lon, $cnt, $start, $end);
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

    /**
     * @expectedException \Cmfcmf\OpenWeatherMap\Exception
     */
    public function uvIndexExceptionDataProvider()
    {
        return array(
            array('current', 5.4, 1, 5, null, null),
            array('forecast', 5.4, 1.2, '5', null, null),
            array('forecast', 5.4, 1.2, 0, null, null),
            array('forecast', 5.4, 1.2, 9, null, null),
            array('forecast', 5.4, 1.2, 5, new \DateTime(), new \DateTime()),
            array('forecast', 5.4, 12.0, null, '2000-1-1', null),
            array('historic', 5.4, 1.2, null, new \DateTime(), '2000-1-1'),
            array('historic', 5.4, 1.2, 5, new \DateTime(), new \DateTime()),
        );
    }
}
