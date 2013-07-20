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

namespace cmfcmf\OpenWeatherMap\Util;

class Weather
{
    public $id;
    
    public $description;
    
    public $icon;
    
    private $iconUrl = "http://openweathermap.org/img/w/%s.png";
    
    public function __construct($id, $description, $icon)
    {
        $this->id = (int)$id;
        $this->description = (string)$description;
        $this->icon = (string)$icon;
    }
    
    public function __toString()
    {
        return $this->description;
    }
    
    public function getIconUrl()
    {
        return str_replace("%s", $this->icon, $this->iconUrl);
    }
}
