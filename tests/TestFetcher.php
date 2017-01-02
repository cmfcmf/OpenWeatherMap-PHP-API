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

use Cmfcmf\OpenWeatherMap\Fetcher\FetcherInterface;

class TestFetcher implements FetcherInterface
{
    /**
     * Fetch contents from the specified url.
     *
     * @param string $url The url to be fetched.
     *
     * @return string The fetched content.
     *
     * @api
     */
    public function fetch($url)
    {
        $format = strpos($url, 'json') !== false ? 'json' : 'xml';
        if (strpos($url, 'forecast') !== false) {
            return $this->forecast($format);
        } elseif (strpos($url, 'group') !== false) {
            return $this->group($format);
        } else {
            return $this->currentWeather($format);
        }
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
