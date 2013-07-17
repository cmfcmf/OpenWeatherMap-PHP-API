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

require_once('Util.php');

/**
 * Main static class for the OpenWeatherMap-PHP-API.
 */
class OpenWeatherMap
{
    /**
     * @const $url The basic api url to fetch data from.
     */
    const url = "http://api.openweathermap.org/data/2.5/weather?";

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
    static public function getRawData($query, $units = 'imperial', $lang = 'en', $appid = '', $mode = 'xml')
    {
        switch($query) {
            case (is_array($query)):
                if (!is_numeric($query['lat']) || !is_numeric($query['lon'])) {
                    return false;
                }
                $query = "lat={$query['lat']}&lon={$query['lon']}";
                break;
            case (is_numeric($query)):
                $query = "id=$query";
                break;
            case (is_string($query)):
                $query = "q=" . urlencode($query);
                break;
            default:
                return false;
        }
        $url = self::url . "$query&units=$units&lang=$lang&mode=$mode";
        if (!empty($appid)) {
            $url .= "&APPID=$appid";
        }
        
        return file_get_contents($url);
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
    static public function getWeather($query, $units = 'imperial', $lang = 'en', $appid = '')
    {
        return new Weather($query, $units, $lang, $appid);
    }
}
