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

namespace Cmfcmf\OpenWeatherMap\Tests;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\CurrentWeather;
use Cmfcmf\OpenWeatherMap\Exception;
use Cmfcmf\OpenWeatherMap\Tests\MyTestCase;
use Cmfcmf\OpenWeatherMap\Tests\TestHttpClient;
use Cache\Adapter\PHPArray\ArrayCachePool;
use Cmfcmf\OpenWeatherMap\Util\City;
use Cmfcmf\OpenWeatherMap\Util\Location;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Factory\Guzzle\StreamFactory;
use Mjelamanov\GuzzlePsr18\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

class OpenWeatherMapTest extends MyTestCase
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
     * @var OpenWeatherMap
     */
    protected $openWeather;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var TestHttpClient
     */
    protected $httpClient;

    protected function setUp(): void
    {
        $ini = parse_ini_file(__DIR__.'/../Examples/ApiKey.ini');
        $this->apiKey = $ini['api_key'];
        $this->httpClient = new TestHttpClient();
        $this->owm = new OpenWeatherMap($this->apiKey, $this->httpClient, new RequestFactory());
        $this->openWeather = new OpenWeatherMap($this->apiKey, GuzzleAdapter::createWithConfig([]), new RequestFactory());
        $this->cache =  new ArrayCachePool();
    }

    public function testApiKeyNotNull()
    {
        $weather = $this->owm;
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

    public function testInvalidData()
    {
        $this->expectException(\Cmfcmf\OpenWeatherMap\Exception::class);
        $this->httpClient->returnErrorForNextRequest(500);
        $this->owm->getWeather('Berlin', 'imperial', 'en', '');
    }

    public function testGetWeather()
    {
        $currentWeather = $this->owm->getWeather('Berlin', 'imperial', 'en', '');

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeather', $currentWeather);
    }

    public function testGetWeatherGroup()
    {
        $currentWeather = $this->owm->getWeatherGroup(array('2950159'), 'imperial', 'en', '');
        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeatherGroup', $currentWeather);

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

    public function testGetCurrentUVIndex()
    {
        $owm = $this->openWeather;
        $result = $owm->getCurrentUVIndex(40.7, -74.2);
        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\UVIndex', $result);
    }

    public function testGetForecastUVIndex()
    {
        $owm = $this->openWeather;

        try {
            $result = $owm->getForecastUVIndex(40.7, -74.2, 5);
        } catch (Exception $e) {
            // OWM might not actually have data for the timespan.
            $this->assertSame('An error occurred: not found', $e->getMessage());
        }
        $this->assertContainsOnlyInstancesOf('\Cmfcmf\OpenWeatherMap\UVIndex', $result);
    }

    public function coordinatesByLocationNameUrlDataProvider(): array
    {
        return [
            [
                'Bundaberg',
                sprintf(
                    'http://api.openweathermap.org/geo/1.0/direct?appid=%s&q=%s',
                    '2f8796eefe67558dc205b09dd336d022',
                    'Bundaberg'
                )
            ],
            [
                'Bundaberg',
                sprintf(
                    'http://api.openweathermap.org/geo/1.0/direct?appid=%s&q=%s%%2C%s',
                    '2f8796eefe67558dc205b09dd336d022',
                    'Bundaberg',
                    'Queensland'
                ),
                'Queensland'
            ],
            [
                'Bundaberg',
                sprintf(
                    'http://api.openweathermap.org/geo/1.0/direct?appid=%s&q=%s%%2C%s%%2C%s',
                    '2f8796eefe67558dc205b09dd336d022',
                    'Bundaberg',
                    'Queensland',
                    'AU'
                ),
                'Queensland',
                'AU',
            ],
            [
                'Bundaberg',
                sprintf(
                    'http://api.openweathermap.org/geo/1.0/direct?appid=%s&q=%s%%2C%%2C%s&limit=%d',
                    '2f8796eefe67558dc205b09dd336d022',
                    'Bundaberg',
                    'AU',
                    20
                ),
                null,
                'AU',
                20,
            ],
            [
                'Bundaberg',
                sprintf(
                    'http://api.openweathermap.org/geo/1.0/direct?appid=%s&q=%s&limit=%d',
                    '2f8796eefe67558dc205b09dd336d022',
                    'Bundaberg',
                    20
                ),
                null,
                null,
                20,
            ],
        ];
    }

    /**
     * @dataProvider coordinatesByLocationNameUrlDataProvider
     */
    public function testCorrectlyBuildsCoordinatesByLocationNameUrl(
        $city,
        $generatedUrl,
        $stateCode = null,
        $countryCode = null,
        $limit = null
    ) {
        $requestFactory = $this->createMock(RequestFactory::class);
        $requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', $generatedUrl);

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->method('getBody')
            ->willReturn((new StreamFactory())->createStream('{}'));
        $response
            ->method('getStatusCode')
            ->willReturn(200);
        $httpClient = $this->createMock(Client::class);
        $httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn($response);

        $this->owm = new OpenWeatherMap(
            $this->apiKey,
            $httpClient,
            $requestFactory
        );
        $data = $this->owm->getCoordinatesByLocationName($city, $stateCode, $countryCode, $limit);
    }

    public function testRetrieveCoordinatesByLocationName()
    {
        $result = <<<EOF
[{"name":"Bundaberg","local_names":{"ar":"بوندابيرج"},"zh":"班达伯格","en":"Bundaberg","ja":"バンダバーグ","ru":"Бундаберг","uk":"Бундаберг","lat":-24.8653253,"lon":152.3516785,"country":"AU","state":"Queensland"}]
EOF;

        $expected = [
            new City (
                -1,
                'Bundaberg',
                -24.8653253,
                152.3516785,
                "AU",
                null,
                null,
                "Queensland",
                [
                    "ar" => "بوندابيرج",
                    "en" => "Bundaberg",
                    "ja" => "バンダバーグ",
                    "ru" => "Бундаберг",
                    "uk" => "Бундаберг",
                    "zh" => "班达伯格",
                ]
            ),
        ];

        $mock = new MockHandler([
            new Response(200, [], $result),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new Client(
            new GuzzleClient(['handler' => $handlerStack])
        );

        $this->owm = new OpenWeatherMap(
            $this->apiKey,
            $httpClient,
            $this->createMock(RequestFactory::class)
        );
        $owm = $this->openWeather;
        $data = $owm->getCoordinatesByLocationName('Bundaberg');

        $this->assertEquals($expected, $data);
    }

    public function testGetHistoryUVIndex()
    {
        $owm = $this->openWeather;

        try {
            $start = new \DateTime('1969-08-15');
            $end = new \DateTime('1969-08-18');
            $result = $owm->getHistoricUVIndex(40.7, -74.2, $start, $end);
        } catch (Exception $e) {
            // OWM might not actually have data for the timespan.
            $this->assertSame('An error occurred: not found', $e->getMessage());
        }
        $this->assertContainsOnlyInstancesOf('\Cmfcmf\OpenWeatherMap\UVIndex', $result);
    }

    public function testGetDailyWeatherForecast()
    {
        $days = 16;
        $dailyForecast = $this->owm->getDailyWeatherForecast('Berlin', 'imperial', 'en', '', $days);

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\WeatherForecast', $dailyForecast);
    }

    public function testGetAirPollution()
    {
        $airPollutionCurrent = $this->owm->getAirPollution("CO", "40", "-74", "current");
        $this->assertInstanceOf(OpenWeatherMap\AirPollution\COAirPollution::class, $airPollutionCurrent);
        $airPollutionPast = $this->owm->getAirPollution("CO", "40", "-74", "2016Z");
        $this->assertInstanceOf(OpenWeatherMap\AirPollution\COAirPollution::class, $airPollutionPast);
    }

    public function testWasCached()
    {
        $weather = $this->owm;
        $result = $weather->wasCached();

        $this->assertFalse($result);
    }

    public function testCached()
    {
        $weather = new OpenWeatherMap($this->apiKey, new TestHttpClient(), new RequestFactory(), $this->cache, 600);
        $currWeatherData = $weather->getRawWeatherData('Berlin', 'imperial', 'en', $this->apiKey, 'xml');
        $this->assertFalse($weather->wasCached());
        $cachedWeatherData = $weather->getRawWeatherData('Berlin', 'imperial', 'en', $this->apiKey, 'xml');
        $this->assertTrue($weather->wasCached());

        $this->assertInternalType('string', $currWeatherData);
        $this->assertInternalType('string', $cachedWeatherData);
        $this->assertSame($currWeatherData, $cachedWeatherData);
    }

    public function testBuildQueryUrlParameter()
    {
        $weather = $this->owm;
        $queryWithNumbericArray = $weather->getWeather(array('2950159'), 'imperial', 'en', '');
        $queryWithLatLonArray = $weather->getWeather(array('lat' => 52.524368, 'lon' => 13.410530), 'imperial', 'en', '');

        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeather', $queryWithNumbericArray);
        $this->assertInstanceOf('\Cmfcmf\OpenWeatherMap\CurrentWeather', $queryWithLatLonArray);
    }
}
