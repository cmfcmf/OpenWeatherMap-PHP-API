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

namespace Cmfcmf\OpenWeatherMap\Tests\Exceptions;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Tests\TestHttpClient;
use Http\Factory\Guzzle\RequestFactory;

class OpenWeatherMapExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var OpenWeatherMap
     */
    protected $owm;

    protected function setUp(): void
    {
        $this->apiKey = 'unicorn-rainbow';
        $this->owm = new OpenWeatherMap($this->apiKey, new TestHttpClient(), new RequestFactory());
    }

    public function testGetWeatherForecastException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $days = 20;
        $this->owm->getWeatherForecast('Berlin', 'imperial', 'en', '', $days);
    }

    public function testGetDailyWeatherForecastException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $days = 20;
        $this->owm->getDailyWeatherForecast('Berlin', 'imperial', 'en', '', $days);
    }

    public function testGetRawDailyForecastDataInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->owm->getRawDailyForecastData('Berlin', 'imperial', 'en', '', 'xml', 20);
    }

    /**
     * @dataProvider uvIndexExceptionDataProvider
     */
    public function testGetRawUVIndexWithQueryErrorException($mode, $lat, $lon, $cnt, $start, $end)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->owm->getRawUVIndexData($mode, $lat, $lon, $cnt, $start, $end);
    }

    public function testBuildQueryUrlParameterException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->owm->getWeather(true, 'imperial', 'en', '');
    }

    public function testParseXMLException()
    {
        $this->expectException(\Cmfcmf\OpenWeatherMap\Exception::class);

        $answer = 'I am not XML formatted data';
        $method = new \ReflectionMethod($this->owm, 'parseXML');
        $method->setAccessible(true);

        $method->invoke($this->owm, $answer);
    }

    public function testParseXMLWithIsJsonException()
    {
        $this->expectException(\Cmfcmf\OpenWeatherMap\Exception::class);

        $answer = array('message' => 'simple json data');
        $answer = json_encode($answer);
        $method = new \ReflectionMethod($this->owm, 'parseXML');
        $method->setAccessible(true);

        $method->invoke($this->owm, $answer);
    }

    public function testParseJsonException()
    {
        $this->expectException(\Cmfcmf\OpenWeatherMap\Exception::class);

        $answer = 'I am not a json format data';
        $method = new \ReflectionMethod($this->owm, 'parseJson');
        $method->setAccessible(true);

        $method->invoke($this->owm, $answer);
    }

    public function uvIndexExceptionDataProvider()
    {
        $this->expectException(\Cmfcmf\OpenWeatherMap\Exception::class);

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
