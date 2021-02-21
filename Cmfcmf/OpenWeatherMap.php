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

namespace Cmfcmf;

use Cmfcmf\OpenWeatherMap\AirPollution;
use Cmfcmf\OpenWeatherMap\CurrentWeather;
use Cmfcmf\OpenWeatherMap\CurrentWeatherGroup;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Cmfcmf\OpenWeatherMap\NotFoundException as OWMNotFoundException;
use Cmfcmf\OpenWeatherMap\UVIndex;
use Cmfcmf\OpenWeatherMap\WeatherForecast;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

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
    const COPYRIGHT = "Weather data from <a href=\"https://openweathermap.org\">OpenWeatherMap.org</a>";

    /**
     * @var string The basic api url to fetch weather data from.
     */
    private $weatherUrl = 'https://api.openweathermap.org/data/2.5/weather?';

    /**
     * @var string The basic api url to fetch weather group data from.
     */
    private $weatherGroupUrl = 'https://api.openweathermap.org/data/2.5/group?';

    /**
     * @var string The basic api url to fetch weekly forecast data from.
     */
    private $weatherHourlyForecastUrl = 'https://api.openweathermap.org/data/2.5/forecast?';

    /**
     * @var string The basic api url to fetch daily forecast data from.
     */
    private $weatherDailyForecastUrl = 'https://api.openweathermap.org/data/2.5/forecast/daily?';

    /**
     * @var string The basic api url to fetch uv index data from.
     */
    private $uvIndexUrl = 'https://api.openweathermap.org/data/2.5/uvi';

    /**
     * @var string The basic api url to fetch air pollution data from.
     */
    private $airPollutionUrl = 'https://api.openweathermap.org/pollution/v1/';

    /**
     * @var CacheItemPoolInterface|null $cache The cache to use.
     */
    private $cache = null;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var bool
     */
    private $wasCached = false;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var RequestFactoryInterface
     */
    private $httpRequestFactory;

    /**
     * @var string
     */
    private $apiKey = '';

    /**
     * Constructs the OpenWeatherMap object.
     *
     * @param string                      $apiKey             The OpenWeatherMap API key. Required.
     * @param ClientInterface             $httpClient         A PSR-18 compatible HTTP client implementation.
     * @param RequestFactoryInterface     $httpRequestFactory A PSR-17 compatbile HTTP request factory implementation.
     * @param null|CacheItemPoolInterface $cache              If set to null, caching is disabled. Otherwise this must be
     *                                                        a PSR-6 compatible cache instance.
     * @param int                         $ttl                How long weather data shall be cached. Defaults to 10 minutes.
     *                                                        Only used if $cache is not null.
     *
     * @api
     */
    public function __construct($apiKey, $httpClient, $httpRequestFactory, $cache = null, $ttl = 600)
    {
        if (!is_string($apiKey) || empty($apiKey)) {
            throw new \InvalidArgumentException("You must provide an API key.");
        }

        if (!is_numeric($ttl)) {
            throw new \InvalidArgumentException('$ttl must be numeric.');
        }

        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient;
        $this->httpRequestFactory = $httpRequestFactory;
        $this->cache = $cache;
        $this->ttl = $ttl;
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
     * There are four ways to specify the place to get weather information for:
     * - Use the city name: $query must be a string containing the city name.
     * - Use the city id: $query must be an integer containing the city id.
     * - Use the coordinates: $query must be an associative array containing the 'lat' and 'lon' values.
     * - Use the zip code: $query must be a string, prefixed with "zip:"
     *
     * Zip code may specify country. e.g., "zip:77070" (Houston, TX, US) or "zip:500001,IN" (Hyderabad, India)
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
     * Returns the current weather for a group of city ids.
     *
     * @param array  $ids   The city ids to get weather information for
     * @param string $units Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string $lang  The language to use for descriptions, default is 'en'. For possible values see http://openweathermap.org/current#multi.
     * @param string $appid Your app id, default ''. See http://openweathermap.org/appid for more details.
     *
     * @throws OpenWeatherMap\Exception  If OpenWeatherMap returns an error.
     * @throws \InvalidArgumentException If an argument error occurs.
     *
     * @return CurrentWeatherGroup
     *
     * @api
     */
    public function getWeatherGroup($ids, $units = 'imperial', $lang = 'en', $appid = '')
    {
        $answer = $this->getRawWeatherGroupData($ids, $units, $lang, $appid);
        $json = $this->parseJson($answer);

        return new CurrentWeatherGroup($json, $units);
    }

    /**
     * Returns the forecast for the place you specified.
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
     * Returns the DAILY forecast for the place you specified.
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
    public function getDailyWeatherForecast($query, $units = 'imperial', $lang = 'en', $appid = '', $days = 1)
    {
        if ($days > 16) {
            throw new \InvalidArgumentException('Error: forecasts are only available for the next 16 days. $days must be 16 or lower.');
        }

        $answer = $this->getRawDailyForecastData($query, $units, $lang, $appid, 'xml', $days);
        $xml = $this->parseXML($answer);
        return new WeatherForecast($xml, $units, $days);
    }

    /**
     * Returns the current uv index at the location you specified.
     *
     * @param float $lat The location's latitude.
     * @param float $lon The location's longitude.
     *
     * @throws OpenWeatherMap\Exception  If OpenWeatherMap returns an error.
     * @throws \InvalidArgumentException If an argument error occurs.
     *
     * @return UVIndex
     *
     * @api
     */
    public function getCurrentUVIndex($lat, $lon)
    {
        $answer = $this->getRawUVIndexData('current', $lat, $lon);
        $json = $this->parseJson($answer);

        return new UVIndex($json);
    }

    /**
     * Returns a forecast of the uv index at the specified location.
     * The optional $cnt parameter determines the number of days to forecase.
     * The maximum supported number of days is 8.
     *
     * @param float $lat The location's latitude.
     * @param float $lon The location's longitude.
     * @param int   $cnt Number of returned days (default to 8).
     *
     * @throws OpenWeatherMap\Exception  If OpenWeatherMap returns an error.
     * @throws \InvalidArgumentException If an argument error occurs.
     *
     * @return UVIndex[]
     *
     * @api
     */
    public function getForecastUVIndex($lat, $lon, $cnt = 8)
    {
        $answer = $this->getRawUVIndexData('forecast', $lat, $lon, $cnt);
        $data = $this->parseJson($answer);
        if (is_object($data)) {
            $lat = $data->coord->lat;
            $lon = $data->coord->lon;
            $data = $data->list;
        }
        return array_map(function ($entry) use ($lat, $lon) {
            return new UVIndex($entry, $lat, $lon);
        }, $data);
    }

    /**
     * Returns the historic uv index at the specified location.
     *
     * @param float     $lat   The location's latitude.
     * @param float     $lon   The location's longitude.
     * @param \DateTime $start Starting point of time period.
     * @param \DateTime $end   Final point of time period.
     *
     * @throws OpenWeatherMap\Exception  If OpenWeatherMap returns an error.
     * @throws \InvalidArgumentException If an argument error occurs.
     *
     * @return UVIndex[]
     *
     * @api
     */
    public function getHistoricUVIndex($lat, $lon, $start, $end)
    {
        $answer = $this->getRawUVIndexData('historic', $lat, $lon, null, $start, $end);
        $data = $this->parseJson($answer);
        if (is_object($data)) {
            $lat = $data->coord->lat;
            $lon = $data->coord->lon;
            $data = $data->list;
        }
        return array_map(function ($entry) use ($lat, $lon) {
            return new UVIndex($entry, $lat, $lon);
        }, $data);
    }

    /**
     * Returns air pollution data
     *
     * @param string $type One of CO, O3, SO2, and NO2.
     * @param string $lat The location's latitude.
     * @param string $lon The location's longitude.
     * @param string $date The date to gather data from. If you omit this parameter or supply "current", returns current data.
     *
     * @return AirPollution\COAirPollution|AirPollution\NO2AirPollution|AirPollution\O3AirPollution|AirPollution\SO2AirPollution|null The air pollution data or null if no data was found.
     *
     * We use strings as $lat and $lon, since the exact number of digits in $lat and $lon determines the search range.
     * For example, there is a difference between using "1.5" and "1.5000".
     * We also use a string for $date, since it may either be "current" or an (abbreviated) ISO 8601 timestamp like 2016Z.
     *
     * @throws OWMException|\Exception
     *
     * @api
     */
    public function getAirPollution($type, $lat, $lon, $date = "current")
    {
        $answer = $this->getRawAirPollutionData($type, $lat, $lon, $date);
        if ($answer === null) {
            return null;
        }
        $json = $this->parseJson($answer);
        switch ($type) {
            case "O3":
                return new AirPollution\O3AirPollution($json);
            case "NO2":
                return new AirPollution\NO2AirPollution($json);
            case "SO2":
                return new AirPollution\SO2AirPollution($json);
            case "CO":
                return new AirPollution\COAirPollution($json);
            default:
                throw new \LogicException();
        }
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
     * Directly returns the JSON string returned by OpenWeatherMap for the group of current weather.
     * Only a JSON response format is supported for this webservice.
     *
     * @param array  $ids   The city ids to get weather information for
     * @param string $units Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string $lang  The language to use for descriptions, default is 'en'. For possible values see http://openweathermap.org/current#multi.
     * @param string $appid Your app id, default ''. See http://openweathermap.org/appid for more details.
     *
     * @return string Returns false on failure and the fetched data in the format you specified on success.
     *
     * @api
     */
    public function getRawWeatherGroupData($ids, $units = 'imperial', $lang = 'en', $appid = '')
    {
        $url = $this->buildUrl($ids, $units, $lang, $appid, 'json', $this->weatherGroupUrl);

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
     * Directly returns the json string returned by OpenWeatherMap for the UV index data.
     *
     * @param string    $mode  The type of requested data (['historic', 'forecast', 'current']).
     * @param float     $lat   The location's latitude.
     * @param float     $lon   The location's longitude.
     * @param int       $cnt   Number of returned days (only allowed for 'forecast' data).
     * @param \DateTime $start Starting point of time period (only allowed and required for 'historic' data).
     * @param \DateTime $end   Final point of time period (only allowed and required for 'historic' data).
     *
     * @return bool|string Returns the fetched data.
     *
     * @api
     */
    public function getRawUVIndexData($mode, $lat, $lon, $cnt = null, $start = null, $end = null)
    {
        if (!in_array($mode, array('current', 'forecast', 'historic'), true)) {
            throw new \InvalidArgumentException("$mode must be one of 'historic', 'forecast', 'current'.");
        }
        if (!is_float($lat) || !is_float($lon)) {
            throw new \InvalidArgumentException('$lat and $lon must be floating point numbers');
        }
        if (isset($cnt) && (!is_int($cnt) || $cnt > 8 || $cnt < 1)) {
            throw new \InvalidArgumentException('$cnt must be an int between 1 and 8');
        }
        if (isset($start) && !$start instanceof \DateTime) {
            throw new \InvalidArgumentException('$start must be an instance of \DateTime');
        }
        if (isset($end) && !$end instanceof \DateTime) {
            throw new \InvalidArgumentException('$end must be an instance of \DateTime');
        }
        if ($mode === 'current' && (isset($start) || isset($end) || isset($cnt))) {
            throw new \InvalidArgumentException('Neither $start, $end, nor $cnt must be set for current data.');
        } elseif ($mode === 'forecast' && (isset($start) || isset($end) || !isset($cnt))) {
            throw new \InvalidArgumentException('$cnt needs to be set and both $start and $end must not be set for forecast data.');
        } elseif ($mode === 'historic' && (!isset($start) || !isset($end) || isset($cnt))) {
            throw new \InvalidArgumentException('Both $start and $end need to be set and $cnt must not be set for historic data.');
        }

        $url = $this->buildUVIndexUrl($mode, $lat, $lon, $cnt, $start, $end);
        return $this->cacheOrFetchResult($url);
    }

    /**
     * Fetch raw air pollution data
     *
     * @param  string $type One of CO, O3, SO2, and NO2.
     * @param  string $lat  The location's latitude.
     * @param  string $lon  The location's longitude.
     * @param  string $date The date to gather data from. If you omit this parameter or supply "current", returns current data.
     *
     * @return string|null The air pollution data or null if no data was found.
     *
     * We use strings as $lat and $lon, since the exact number of digits in $lat and $lon determines the search range.
     * For example, there is a difference between using "1.5" and "1.5000".
     * We also use a string for $date, since it may either be "current" or an (abbreviated) ISO 8601 timestamp like 2016Z.
     *
     * @api
     */
    public function getRawAirPollutionData($type, $lat, $lon, $date = "current")
    {
        if (!in_array($type, ["CO", "O3", "SO2", "NO2"])) {
            throw new \InvalidArgumentException('Invalid $type received.');
        }
        if (!is_string($lat) || !is_string($lon) || !is_string($date)) {
            throw new \InvalidArgumentException('$lat, $lon and $date all must be strings.');
        }

        $url = $this->airPollutionUrl . strtolower($type) . "/$lat,$lon/$date.json?appid=" . $this->apiKey;

        try {
            return $this->cacheOrFetchResult($url);
        } catch (OWMNotFoundException $e) {
            return null;
        }
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
     * Fetches the result or delivers a cached version of the result.
     *
     * @param string $url
     *
     * @return string
     */
    private function cacheOrFetchResult($url)
    {
        if ($this->cache !== null) {
            $key = str_replace(
                ["{", "}", "(", ")", "/", "\\", "@", ":"],
                ["_", "_", "_", "_", "_", "_",  "_", "_"],
                $url
            );
            $item = $this->cache->getItem($key);
            if ($item->isHit()) {
                $this->wasCached = true;
                return $item->get();
            }
        }

        $response = $this->httpClient->sendRequest($this->httpRequestFactory->createRequest("GET", $url));
        $result = $response->getBody()->getContents();
        if ($response->getStatusCode() !== 200) {
            if (false !== strpos($result, 'not found') && $response->getStatusCode() === 404) {
                throw new OWMNotFoundException();
            }
            throw new OWMException('OpenWeatherMap returned a response with status code ' . $response->getStatusCode() . ' and the following content `'. $result . '`');
        }

        if ($this->cache !== null) {
            $item->set($result);
            $item->expiresAfter($this->ttl);
            $this->cache->save($item);
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
     * @param string             $mode          The type of requested data.
     * @param float              $lat           The location's latitude.
     * @param float              $lon           The location's longitude.
     * @param int                $cnt           Number of returned days.
     * @param \DateTime          $start         Starting point of time period.
     * @param \DateTime          $end           Final point of time period.
     *
     * @return string
     */
    private function buildUVIndexUrl($mode, $lat, $lon, $cnt = null, \DateTime $start = null, \DateTime $end = null)
    {
        $params = array(
            'appid' => $this->apiKey,
            'lat' => $lat,
            'lon' => $lon,
        );

        switch ($mode) {
            case 'historic':
                $requestMode = '/history';
                $params['start'] = $start->format('U');
                $params['end'] = $end->format('U');
                break;
            case 'forecast':
                $requestMode = '/forecast';
                $params['cnt'] = $cnt;
                break;
            case 'current':
                $requestMode = '';
                break;
            default:
                throw new \InvalidArgumentException("Invalid mode $mode for uv index url");
        }

        return sprintf($this->uvIndexUrl . '%s?%s', $requestMode, http_build_query($params));
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
            case is_array($query) && is_numeric($query[0]):
                return 'id='.implode(',', $query);
            case is_numeric($query):
                return "id=$query";
            case is_string($query) && strpos($query, 'zip:') === 0:
                $subQuery = str_replace('zip:', '', $query);
                return 'zip='.urlencode($subQuery);
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
                throw new OWMException($error['message'], isset($error['cod']) ? $error['cod'] : 0);
            } else {
                throw new OWMException('Unknown fatal error: OpenWeatherMap returned the following json object: ' . $answer);
            }
        }
    }

    /**
     * @param string $answer The content returned by OpenWeatherMap.
     *
     * @return \stdClass|array
     * @throws OWMException If the content isn't valid JSON.
     */
    private function parseJson($answer)
    {
        $json = json_decode($answer);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new OWMException('OpenWeatherMap returned an invalid json object. JSON error was: "' .
                $this->json_last_error_msg() . '". The retrieved json was: ' . $answer);
        }
        if (isset($json->message)) {
            throw new OWMException('An error occurred: '. $json->message);
        }

        return $json;
    }

    private function json_last_error_msg()
    {
        if (function_exists('json_last_error_msg')) {
            return json_last_error_msg();
        }

        static $ERRORS = array(
            JSON_ERROR_NONE => 'No error',
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'State mismatch (invalid or malformed JSON)',
            JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
            JSON_ERROR_SYNTAX => 'Syntax error',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
        );

        $error = json_last_error();
        return isset($ERRORS[$error]) ? $ERRORS[$error] : 'Unknown error';
    }
}
