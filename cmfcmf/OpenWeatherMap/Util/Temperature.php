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

class Temperature
{
    public $now;
    
    public $min;
    
    public $max;
    
    public function __construct(Unit $now, Unit $min, Unit $max)
    {
        $this->now = $now;
        $this->min = $min;
        $this->max = $max;
    }
    
    public function __toString()
    {
        return $this->now->__toString();
    }
    
    public function getUnit()
    {
        return $this->now->getUnit();
    }
    
    public function getValue()
    {
        return $this->now->getValue();
    }
    
    public function getDescription()
    {
        return $this->now->getDescription();
    }
    
    public function getFormatted()
    {
        return $this->now->getFormatted();
    }
}
