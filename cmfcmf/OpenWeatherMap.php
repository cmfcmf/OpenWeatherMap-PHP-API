<?php
/**
 * OpenWeatherMap-PHP-API — An php api to parse weather data from http://www.OpenWeatherMap.org .
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of OpenWeatherMap before using this class.
 * @see http://www.OpenWeatherMap.org
 * @see http://www.OpenWeatherMap.org/about
 * @see http://www.OpenWeatherMap.org/copyright
 * @see http://openweathermap.org/appid
 */

namespace cmfcmf {

use cmfcmf\OpenWeatherMap\Weather;

# Install PSR-0-compatible class autoloader
spl_autoload_register(function($class){
    require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

/**
 * Main static class for the OpenWeatherMap-PHP-API.
 */
class OpenWeatherMap
{
    /**
     * @var $url The basic api url to fetch data from.
     */
    private $url = "http://api.openweathermap.org/data/2.5/weather?";

    private $cacheClass = false;
    
    private $seconds;

    /**
     * Constructs the OpenWeatherMap object.
     *
     * @param bool|string $cache If set to false, caching is disabled. If this is a valid class
     * extending cmfcmf\OpenWeatherMap\Util\Cache, caching will be enabled. Default false.
     * @param int $seconds How long weather data shall be cached. Default 10 minutes.
     *
     * @throws Exception If $cache is neither false nor a valid callable extending cmfcmf\OpenWeatherMap\Util\Cache.
     */
    public function __construct($cacheClass = false, $seconds = 600)
    {
        if (!class_exists($cacheClass) && $cacheClass !== false) {
            #throw new \Exception("Class $cacheClass does not exist.");
        }
        if (!is_numeric($seconds)) {
            throw new \Exception("\$seconds must be numeric.");
        }
        if ($seconds == 0) {
            $cacheClass = false;
        }
        
        $this->cacheClass = $cacheClass;
        $this->seconds = $seconds;
    }
    
    /**
     * Directly returns the xml/json/html string returned by OpenWeatherMap.
     *
     * @param array|int|string $query The place to get weather information for. For possible values see below.
     * @param string $units Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string $lang The language to use for descriptions, default is 'en'. For possible values see below.
     * @param string $appid Your app id, default ''. See http://openweathermap.org/appid for more details.
     * @param string $mode The format of the data fetched. Possible values are 'json', 'html' and 'xml' (default).
     *
     * @return bool|string Returns false on failure and the fetched data in the format you specified on success.
     *
     * @warning If an error occured, OpenWeatherMap returns data in json format ALWAYS 
     *
     * There are three ways to specify the place to get weather information for:
     * - Use the city name: $query must be a string containing the city name.
     * - Use the city id: $query must be an integer containing the city id.
     * - Use the coordinates: $query must be an associative array containing the 'lat' and 'lon' values.
     *
     * Available languages are (as of 17. July 2013):
     * - English - en
     * - Russian - ru
     * - Italian - it
     * - Spanish - sp
     * - Ukrainian - ua
     * - German - de
     * - Portuguese - pt
     * - Romanian - ro
     * - Polish - pl
     * - Finnish - fi
     * - Dutch - nl
     * - French - fr
     * - Bulgarian - bg
     * - Swedish - se
     * - Chinese Traditional - zh_tw
     * - Chinese Simplified - zh_cn
     * - Turkish - tr
     */
    public function getRawData($query, $units = 'imperial', $lang = 'en', $appid = '', $mode = 'xml')
    {
        switch($query) {
            case (is_array($query)):
                if (!is_numeric($query['lat']) || !is_numeric($query['lon'])) {
                    return false;
                }
                $queryUrl = "lat={$query['lat']}&lon={$query['lon']}";
                break;
            case (is_numeric($query)):
                $queryUrl = "id=$query";
                break;
            case (is_string($query)):
                $queryUrl = "q=" . urlencode($query);
                break;
            default:
                return false;
        }

        $url = $this->url . "$queryUrl&units=$units&lang=$lang&mode=$mode";
        if (!empty($appid)) {
            $url .= "&APPID=$appid";
        }

        $result = "";
        
        if ($this->cacheClass !== false) {
            $cache = new $this->cacheClass;
            $cache->setSeconds($this->seconds);
            if ($cache->isCached($query, $units, $lang, $mode)) {
                return $cache->getCached();
            }
            $result = $this->fetch($url);
            $cache->setCached($result, $query, $units, $lang, $mode);
        } else {
            $result = $this->fetch($url);
        }

        return $result;
    }
    
    /**
     * Returns the current weather at the place you specified as an object.
     *
     * @param array|int|string $query The place to get weather information for. For possible values see below.
     * @param string $units Can be either 'metric' or 'imperial' (default). This affects almost all units returned.
     * @param string $lang The language to use for descriptions, default is 'en'. For possible values see below.
     * @param string $appid Your app id, default ''. See http://openweathermap.org/appid for more details.
     *
     * @throws Exception If $query has a wrong format. For valid formats see below.
     * @throws OpenWeatherMap_Exception If OpenWeatherMap returns an error.
     *
     * @return object Returns a new Weather object.
     *
     * There are three ways to specify the place to get weather information for:
     * - Use the city name: $query must be a string containing the city name.
     * - Use the city id: $query must be an integer containing the city id.
     * - Use the coordinates: $query must be an associative array containing the 'lat' and 'lon' values.
     *
     * Available languages are (as of 17. July 2013):
     * - English - en
     * - Russian - ru
     * - Italian - it
     * - Spanish - sp
     * - Ukrainian - ua
     * - German - de
     * - Portuguese - pt
     * - Romanian - ro
     * - Polish - pl
     * - Finnish - fi
     * - Dutch - nl
     * - French - fr
     * - Bulgarian - bg
     * - Swedish - se
     * - Chinese Traditional - zh_tw
     * - Chinese Simplified - zh_cn
     * - Turkish - tr
     */
    public function getWeather($query, $units = 'imperial', $lang = 'en', $appid = '')
    {
        return new Weather($query, $units, $lang, $appid, $this->cacheClass, $this->seconds);
    }
    
    private function fetch($url)
    {
        return file_get_contents($url);
    }
}

}
