<?php
/**
 * OpenWeatherMap-PHP-API — A php api to parse weather data from http://www.OpenWeatherMap.org .
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of
 * OpenWeatherMap before using this class:
 *
 * @see http://www.OpenWeatherMap.org
 * @see http://www.OpenWeatherMap.org/terms
 * @see http://openweathermap.org/appid
 */

namespace Cmfcmf\OpenWeatherMap\Tests;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Factory\Guzzle\ResponseFactory;
use GuzzleHttp\Psr7;

class TestHttpClient implements ClientInterface
{
    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    public function __construct() {
        $this->responseFactory = new ResponseFactory();
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $url = $request->getUri();
        $format = strpos($url, 'json') !== false ? 'json' : 'xml';
        $content = "";
        if (strpos($url, 'forecast') !== false) {
            $content = $this->forecast($format);
        } elseif (strpos($url, 'group') !== false) {
            $content = $this->group($format);
        } else {
            $content = $this->currentWeather($format);
        }

        $response = $this->responseFactory->createResponse(200);
        return $response->withBody(Psr7\stream_for($content));
    }

    private function currentWeather($format)
    {
        if ($format == 'xml') {
            return FakeData::CURRENT_WEATHER_XML;
        }
    }

    private function forecast($format)
    {
        if ($format == 'xml') {
            return FakeData::forecastXML();
        }
    }

    private function group($format)
    {
        if ($format == 'json') {
            return FakeData::WEATHER_GROUP_JSON;
        }
    }
}
