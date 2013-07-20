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

/**
 * @class General class for each value.
 */
class Unit
{
    private $value;
    
    private $unit;
    
    private $description;
    
    public function __construct($value = 0.0, $unit = "", $description = "")
    {
        $this->value = (float)$value;
        $this->unit = (string)$unit;
        $this->description = (string)$description;
    }
    
    public function __toString()
    {
        return $this->getFormatted();
    }
    
    public function getUnit()
    {
        // Units are inconsistent. Only celsius and fahrenheit are not abbreviated. This check fixes that.
        if ($this->unit == 'celsius') {
            return '°C';
        } else if ($this->unit == 'fahrenheit') {
            return 'F';
        } else {
            return $this->unit;
        }
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getFormatted()
    {
        if ($this->getUnit() != "") {
            return "{$this->getValue()} {$this->getUnit()}";
        } else {
            return "{$this->getValue()}";
        }
    }
}

