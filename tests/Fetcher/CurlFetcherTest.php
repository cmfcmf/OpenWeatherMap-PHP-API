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

namespace Cmfcmf\OpenWeatherMap\Tests\Fetcher;

use \Cmfcmf\OpenWeatherMap\Fetcher\CurlFetcher;

/**
 * @requires function curl_version
 */
class CurlFetcherTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidUrl()
    {
        $fetcher = new CurlFetcher();

        $content = $fetcher->fetch('http://notexisting.example.com');

        $this->assertSame(false, $content);
    }

    public function testEmptyUrl()
    {
        $fetcher = new CurlFetcher();

        $content = $fetcher->fetch('');

        $this->assertSame(false, $content);
    }

    public function testValidUrl()
    {
        $fetcher = new CurlFetcher();

        $content = $fetcher->fetch('http://httpbin.org/html');

        $this->assertContains('Herman Melville', $content);
    }
}
