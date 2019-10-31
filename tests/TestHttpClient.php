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

    /**
     * @var int
     */
    private $errorWithStatusCode;

    public function __construct()
    {
        $this->responseFactory = new ResponseFactory();
        $this->errorWithStatusCode = null;
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
        } elseif (strpos($url, "pollution") !== false) {
            $content = FakeData::AIR_POLLUTION_CO;
        } else {
            $content = $this->currentWeather($format);
        }

        $response = $this->responseFactory->createResponse($this->errorWithStatusCode !== null ? $this->errorWithStatusCode : 200);
        $this->errorWithStatusCode = null;
        return $response->withBody(Psr7\stream_for($content));
    }

    public function returnErrorForNextRequest($code)
    {
        $this->errorWithStatusCode = $code;
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
