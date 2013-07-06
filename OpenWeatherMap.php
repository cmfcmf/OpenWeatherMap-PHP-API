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
 */

require_once('Util.php');

class OpenWeatherMap
{
    const url = "http://api.openweathermap.org/data/2.5/weather?";

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
    
    static public function getWeather($query, $units = 'imperial', $lang = 'en', $appid = '')
    {
        return new Weather($query, $units, $lang, $appid);
    }
}
