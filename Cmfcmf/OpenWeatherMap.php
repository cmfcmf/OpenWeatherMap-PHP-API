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

namespace Cmfcmf;

use Cmfcmf\OpenWeatherMap\AbstractCache;
use Cmfcmf\OpenWeatherMap\CurrentWeather;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Cmfcmf\OpenWeatherMap\Fetcher\CurlFetcher;
use Cmfcmf\OpenWeatherMap\Fetcher\FetcherInterface;
use Cmfcmf\OpenWeatherMap\Fetcher\FileGetContentsFetcher;
use Cmfcmf\OpenWeatherMap\WeatherForecast;
use Cmfcmf\OpenWeatherMap\WeatherHistory;

/**
 * Main class for the OpenWeatherMap-PHP-API. Only use this class.
 *
 * @api
 */
class OpenWeatherMap
{
    /**
     * The copyright notice. This is no official text, it was created by
     * following the guidelines at http://openweathermap.org/copyright.
     *
     * @var string $copyright
     */
    const COPYRIGHT = "Weather data from <a href=\"http://www.openweathermap.org\">OpenWeatherMap.org</a>";

    /**
     * @var string The basic api url to fetch weather data from.
     */
    private $weatherUrl = 'http://api.openweathermap.org/data/2.5/weather?';

    /**
     * @var string The basic api url to fetch weekly forecast data from.
     */
    private $weatherHourlyForecastUrl = 'http://api.openweathermap.org/data/2.5/forecast?';

    /**
     * @var string The basic api url to fetch daily forecast data from.
     */
    private $weatherDailyForecastUrl = 'http://api.openweathermap.org/data/2.5/forecast/daily?';

    /**
     * @var string The basic api url to fetch history weather data from.
     */
    private $weatherHistoryUrl = 'http://api.openweathermap.org/data/2.5/history/city?';

    /**
     * @var AbstractCache|bool $cache The cache to use.
     */
    private $cache = false;

    /**
     * @var int
     */
    private $seconds;

    /**
     * @var bool
     */
    private $wasCached = false;

    /**
     * @var FetcherInterface The url fetcher.
     */
    private $fetcher;

    /**
     * @var string
     */
    private $apiKey = '';

    /**
     * Constructs the OpenWeatherMap object.
     *
     * @param string                $apiKey  The OpenWeatherMap API key. Required and only optional for BC.
     * @param null|FetcherInterface $fetcher The interface to fetch the data from OpenWeatherMap. Defaults to
     *                                       CurlFetcher() if cURL is available. Otherwise defaults to
     *                                       FileGetContentsFetcher() using 'file_get_contents()'.
     * @param bool|string           $cache   If set to false, caching is disabled. Otherwise this must be a class
     *                                       extending AbstractCache. Defaults to false.
     * @param int $seconds                   How long weather data shall be cached. Default 10 minutes.
     *
     * @throws \Exception If $cache is neither false nor a valid callable extending Cmfcmf\OpenWeatherMap\Util\Cache.
     *
     * @api
     */
    public function __construct($apiKey = '', $fetcher = null, $cache = false, $seconds = 600)
    {
        if (!is_string($apiKey) || empty($apiKey)) {
            // BC
            $seconds = $cache !== false ? $cache : 600;
            $cache = $fetcher !== null ? $fetcher : false;
            $fetcher = $apiKey !== '' ? $apiKey : null;
        } else {
            $this->apiKey = $apiKey;
        }

        if ($cache !== false && !($cache instanceof AbstractCache)) {
            throw new \Exception('The cache class must implement the FetcherInterface!');
        }
        if (!is_numeric($seconds)) {
            throw new \Exception('$seconds must be numeric.');
        }
        if (!isset($fetcher)) {
            $fetcher = (function_exists('curl_version')) ? new CurlFetcher() : new FileGetContentsFetcher();
        }
        if ($seconds == 0) {
            $cache = false;
        }

        $this->cache = $cache;
        $this->seconds = $seconds;
        $this->fetcher = $fetcher;
    }

    /**
     * Sets the API Key.
     *
     * @param string $apiKey API key for the OpenWeatherMap account.
     *
     * @api
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Returns the API Key.
     *
     * @return string
     *
     * @api
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Returns the current weather at the place you specified.
     *
     * @param array|int|string $query The place to get weather information for. For possible values see below.
     * @param string           $units Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string           $lang  The language to use for descriptions, default is 'en'. For possible values see http://openweathermap.org/current#multi.
     * @param string           $appid Your app id, default ''. See http://openweathermap.org/appid for more details.
     *
     * @throws OpenWeatherMap\Exception  If OpenWeatherMap returns an error.
     * @throws \InvalidArgumentException If an argument error occurs.
     *
     * @return CurrentWeather The weather object.
     *
     * There are three ways to specify the place to get weather information for:
     * - Use the city name: $query must be a string containing the city name.
     * - Use the city id: $query must be an integer containing the city id.
     * - Use the coordinates: $query must be an associative array containing the 'lat' and 'lon' values.
     *
     * @api
     */
    public function getWeather($query, $units = 'imperial', $lang = 'en', $appid = '')
    {
        $answer = $this->getRawWeatherData($query, $units, $lang, $appid, 'xml');
        $xml = $this->parseXML($answer);

        return new CurrentWeather($xml, $units);
    }

    /**
     * Returns the forecast for the place you specified. DANGER: Might return
     * fewer results than requested due to a bug in the OpenWeatherMap API!
     *
     * @param array|int|string $query The place to get weather information for. For possible values see ::getWeather.
     * @param string           $units Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string           $lang  The language to use for descriptions, default is 'en'. For possible values see http://openweathermap.org/current#multi.
     * @param string           $appid Your app id, default ''. See http://openweathermap.org/appid for more details.
     * @param int              $days  For how much days you want to get a forecast. Default 1, maximum: 16.
     *
     * @throws OpenWeatherMap\Exception If OpenWeatherMap returns an error.
     * @throws \InvalidArgumentException If an argument error occurs.
     *
     * @return WeatherForecast
     *
     * @api
     */
    public function getWeatherForecast($query, $units = 'imperial', $lang = 'en', $appid = '', $days = 1)
    {
        if ($days <= 5) {
            $answer = $this->getRawHourlyForecastData($query, $units, $lang, $appid, 'xml');
        } elseif ($days <= 16) {
            $answer = $this->getRawDailyForecastData($query, $units, $lang, $appid, 'xml', $days);
        } else {
            throw new \InvalidArgumentException('Error: forecasts are only available for the next 16 days. $days must be 16 or lower.');
        }
        $xml = $this->parseXML($answer);

        return new WeatherForecast($xml, $units, $days);
    }

    /**
     * Returns the weather history for the place you specified.
     *
     * @param array|int|string $query      The place to get weather information for. For possible values see ::getWeather.
     * @param \DateTime        $start
     * @param int              $endOrCount
     * @param string           $type       Can either be 'tick', 'hour' or 'day'.
     * @param string           $units      Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string           $lang       The language to use for descriptions, default is 'en'. For possible values see http://openweathermap.org/current#multi.
     * @param string           $appid      Your app id, default ''. See http://openweathermap.org/appid for more details.
     *
     * @throws OpenWeatherMap\Exception  If OpenWeatherMap returns an error.
     * @throws \InvalidArgumentException If an argument error occurs.
     *
     * @return WeatherHistory
     *
     * @api
     */
    public function getWeatherHistory($query, \DateTime $start, $endOrCount = 1, $type = 'hour', $units = 'imperial', $lang = 'en', $appid = '')
    {
        if (!in_array($type, array('tick', 'hour', 'day'))) {
            throw new \InvalidArgumentException('$type must be either "tick", "hour" or "day"');
        }

        $xml = json_decode($this->getRawWeatherHistory($query, $start, $endOrCount, $type, $units, $lang, $appid), true);

        if ($xml['cod'] != 200) {
            throw new OWMException($xml['message'], $xml['cod']);
        }

        return new WeatherHistory($xml, $query);
    }

    /**
     * Directly returns the xml/json/html string returned by OpenWeatherMap for the current weather.
     *
     * @param array|int|string $query The place to get weather information for. For possible values see ::getWeather.
     * @param string           $units Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string           $lang  The language to use for descriptions, default is 'en'. For possible values see http://openweathermap.org/current#multi.
     * @param string           $appid Your app id, default ''. See http://openweathermap.org/appid for more details.
     * @param string           $mode  The format of the data fetched. Possible values are 'json', 'html' and 'xml' (default).
     *
     * @return string Returns false on failure and the fetched data in the format you specified on success.
     *
     * Warning: If an error occurs, OpenWeatherMap ALWAYS returns json data.
     *
     * @api
     */
    public function getRawWeatherData($query, $units = 'imperial', $lang = 'en', $appid = '', $mode = 'xml')
    {
        $url = $this->buildUrl($query, $units, $lang, $appid, $mode, $this->weatherUrl);

        return $this->cacheOrFetchResult($url);
    }

    /**
     * Directly returns the xml/json/html string returned by OpenWeatherMap for the hourly forecast.
     *
     * @param array|int|string $query The place to get weather information for. For possible values see ::getWeather.
     * @param string           $units Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string           $lang  The language to use for descriptions, default is 'en'. For possible values see http://openweathermap.org/current#multi.
     * @param string           $appid Your app id, default ''. See http://openweathermap.org/appid for more details.
     * @param string           $mode  The format of the data fetched. Possible values are 'json', 'html' and 'xml' (default).
     *
     * @return string Returns false on failure and the fetched data in the format you specified on success.
     *
     * Warning: If an error occurs, OpenWeatherMap ALWAYS returns json data.
     *
     * @api
     */
    public function getRawHourlyForecastData($query, $units = 'imperial', $lang = 'en', $appid = '', $mode = 'xml')
    {
        $url = $this->buildUrl($query, $units, $lang, $appid, $mode, $this->weatherHourlyForecastUrl);

        return $this->cacheOrFetchResult($url);
    }

    /**
     * Directly returns the xml/json/html string returned by OpenWeatherMap for the daily forecast.
     *
     * @param array|int|string $query The place to get weather information for. For possible values see ::getWeather.
     * @param string           $units Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string           $lang  The language to use for descriptions, default is 'en'. For possible values see http://openweathermap.org/current#multi.
     * @param string           $appid Your app id, default ''. See http://openweathermap.org/appid for more details.
     * @param string           $mode  The format of the data fetched. Possible values are 'json', 'html' and 'xml' (default)
     * @param int              $cnt   How many days of forecast shall be returned? Maximum (and default): 16
     *
     * @throws \InvalidArgumentException If $cnt is higher than 16.
     *
     * @return string Returns false on failure and the fetched data in the format you specified on success.
     *
     * Warning: If an error occurs, OpenWeatherMap ALWAYS returns json data.
     *
     * @api
     */
    public function getRawDailyForecastData($query, $units = 'imperial', $lang = 'en', $appid = '', $mode = 'xml', $cnt = 16)
    {
        if ($cnt > 16) {
            throw new \InvalidArgumentException('$cnt must be 16 or lower!');
        }
        $url = $this->buildUrl($query, $units, $lang, $appid, $mode, $this->weatherDailyForecastUrl) . "&cnt=$cnt";

        return $this->cacheOrFetchResult($url);
    }

    /**
     * Directly returns the xml/json/html string returned by OpenWeatherMap for the weather history.
     *
     * @param array|int|string $query      The place to get weather information for. For possible values see ::getWeather.
     * @param \DateTime        $start      The \DateTime object of the date to get the first weather information from.
     * @param \DateTime|int    $endOrCount Can be either a \DateTime object representing the end of the period to
     *                                     receive weather history data for or an integer counting the number of
     *                                     reports requested.
     * @param string           $type       The period of the weather history requested. Can be either be either "tick",
     *                                     "hour" or "day".
     * @param string           $units      Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string           $lang       The language to use for descriptions, default is 'en'. For possible values see http://openweathermap.org/current#multi.
     * @param string           $appid      Your app id, default ''. See http://openweathermap.org/appid for more details.
     *
     * @throws \InvalidArgumentException
     *
     * @return string Returns false on failure and the fetched data in the format you specified on success.
     *
     * Warning If an error occurred, OpenWeatherMap ALWAYS returns data in json format.
     *
     * @api
     */
    public function getRawWeatherHistory($query, \DateTime $start, $endOrCount = 1, $type = 'hour', $units = 'imperial', $lang = 'en', $appid = '')
    {
        if (!in_array($type, array('tick', 'hour', 'day'))) {
            throw new \InvalidArgumentException('$type must be either "tick", "hour" or "day"');
        }

        $url = $this->buildUrl($query, $units, $lang, $appid, 'json', $this->weatherHistoryUrl);
        $url .= "&type=$type&start={$start->format('U')}";
        if ($endOrCount instanceof \DateTime) {
            $url .= "&end={$endOrCount->format('U')}";
        } elseif (is_numeric($endOrCount) && $endOrCount > 0) {
            $url .= "&cnt=$endOrCount";
        } else {
            throw new \InvalidArgumentException('$endOrCount must be either a \DateTime or a positive integer.');
        }

        return $this->cacheOrFetchResult($url);
    }

    /**
     * Returns whether or not the last result was fetched from the cache.
     *
     * @return bool true if last result was fetched from cache, false otherwise.
     */
    public function wasCached()
    {
        return $this->wasCached;
    }

    /**
     * @deprecated Use {@link self::getRawWeatherData()} instead.
     */
    public function getRawData($query, $units = 'imperial', $lang = 'en', $appid = '', $mode = 'xml')
    {
        return $this->getRawWeatherData($query, $units, $lang, $appid, $mode);
    }

    /**
     * Fetches the result or delivers a cached version of the result.
     *
     * @param string $url
     *
     * @return string
     */
    private function cacheOrFetchResult($url)
    {
        if ($this->cache !== false) {
            /** @var AbstractCache $cache */
            $cache = $this->cache;
            $cache->setSeconds($this->seconds);
            if ($cache->isCached($url)) {
                $this->wasCached = true;
                return $cache->getCached($url);
            }
            $result = $this->fetcher->fetch($url);
            $cache->setCached($url, $result);
        } else {
            $result = $this->fetcher->fetch($url);
        }
        $this->wasCached = false;

        return $result;
    }

    /**
     * Build the url to fetch weather data from.
     *
     * @param        $query
     * @param        $units
     * @param        $lang
     * @param        $appid
     * @param        $mode
     * @param string $url   The url to prepend.
     *
     * @return bool|string The fetched url, false on failure.
     */
    private function buildUrl($query, $units, $lang, $appid, $mode, $url)
    {
        $queryUrl = $this->buildQueryUrlParameter($query);

        $url = $url."$queryUrl&units=$units&lang=$lang&mode=$mode&APPID=";
        $url .= empty($appid) ? $this->apiKey : $appid;

        return $url;
    }

    /**
     * Builds the query string for the url.
     *
     * @param mixed $query
     *
     * @return string The built query string for the url.
     *
     * @throws \InvalidArgumentException If the query parameter is invalid.
     */
    private function buildQueryUrlParameter($query)
    {
        switch ($query) {
            case is_array($query) && isset($query['lat']) && isset($query['lon']) && is_numeric($query['lat']) && is_numeric($query['lon']):
                return "lat={$query['lat']}&lon={$query['lon']}";
            case is_numeric($query):
                return "id=$query";
            case is_string($query):
                return 'q='.urlencode($query);
            default:
                throw new \InvalidArgumentException('Error: $query has the wrong format. See the documentation of OpenWeatherMap::getWeather() to read about valid formats.');
        }
    }

    /**
     * @param string $answer The content returned by OpenWeatherMap.
     *
     * @return \SimpleXMLElement
     * @throws OWMException If the content isn't valid XML.
     */
    private function parseXML($answer)
    {
        // Disable default error handling of SimpleXML (Do not throw E_WARNINGs).
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        try {
            return new \SimpleXMLElement($answer);
        } catch (\Exception $e) {
            // Invalid xml format. This happens in case OpenWeatherMap returns an error.
            // OpenWeatherMap always uses json for errors, even if one specifies xml as format.
            $error = json_decode($answer, true);
            if (isset($error['message'])) {
                throw new OWMException($error['message'], $error['cod']);
            } else {
                throw new OWMException('Unknown fatal error: OpenWeatherMap returned the following json object: ' . $answer);
            }
        }
    }
}
