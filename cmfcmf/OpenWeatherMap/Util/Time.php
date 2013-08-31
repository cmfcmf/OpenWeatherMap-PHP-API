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

class Time
{
    public $from;
    
    public $to;
    
    public $day;
    
    public function __construct($from, $to = null)
    {
        if (isset($to)) {
            $from = new \DateTime($from);
            $to = new \DateTime($to);
            $day = new \DateTime($from->format('Y-m-d'));
        } else {
            $from = new \DateTime($from);
            $day = clone $from;
            $to = clone $from;
            $to = $to->add(new \DateInterval('PT23H59M59S'));
        }
        
        $this->from = $from;
        $this->to = $to;
        $this->day = $day;
    }
}
