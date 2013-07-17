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

/**
 * Weather class returned by OpenWeatherMap::getWeather().
 */
class Weather
{
    public $city;
    
    public $temperature;
    
    public $humidity;
    
    public $pressure;
    
    public $wind;
    
    public $clouds;
    
    public $precipitation;
    
    public $sun;
    
    public $weather;
    
    public $lastUpdate;
    
    /**
     * @var $copyright
     * @notice This is no offical text. This hint was made regarding to http://www.http://openweathermap.org/copyright .
     */
    public $copyright = "Weather data from <a href=\"http://www.openweathermap.org\">OpenWeatherMap.org</a>";
    
    public function __construct($query, $units = 'imperial', $lang = 'en', $appid = '')
    {
        // Disable default error handling of SimpleXML (Do not throw E_WARNINGs).
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        
        $answer = OpenWeatherMap::getRawData($query, $units, $lang, $appid, 'xml');
        if ($answer === false) {
            // $query has the wrong format, throw error.
            throw new Exception('Error: $query has the wrong format. See the documentation of OpenWeatherMap::getRawData() to read about valid formats.');
        }
        
        try {
            $xml = new SimpleXMLElement($answer);
        } catch(Exception $e) {
            // Invalid xml format. This happens in case OpenWeatherMap returns an error.
            // OpenWeatherMap always uses json for errors, even if one specifies xml as format.
            $error = json_decode($answer, true);
            if (isset($error['message'])) {
                throw new OpenWeatherMap_Exception($error['message'], $error['cod']);
            } else {
                throw new OpenWeatherMap_Exception('Unknown fatal error: OpenWeatherMap returned the following json object: ' . print_r($error));
            }
        }
        // Check for errors.
        $errors = libxml_get_errors();
        print_r($errors);
        
        $this->city = new _City($xml->city['id'], $xml->city['name'], $xml->city->coord['lon'], $xml->city->coord['lat'], $xml->city->country);
        $this->temperature = new _Temperature(new _Unit($xml->temperature['value'], $xml->temperature['unit']), new _Unit($xml->temperature['min'], $xml->temperature['unit']), new _Unit($xml->temperature['max'], $xml->temperature['unit']));
        $this->humidity = new _Unit($xml->humidity['value'], $xml->humidity['unit']);
        $this->pressure = new _Unit($xml->pressure['value'], $xml->pressure['unit']);
        
        
        // This is kind of a hack, because the units are missing in the xml document.
        if ($units == 'metric') {
            $windSpeedUnit = 'm/s';
        } else {
            $windSpeedUnit = 'mph';
        }
        $this->wind = new _Wind(new _Unit($xml->wind->speed['value'], $windSpeedUnit, $xml->wind->speed['name']), new _Unit($xml->wind->direction['value'], $xml->wind->direction['code'], $xml->wind->direction['name']));
        
        
        $this->clouds = new _Unit($xml->clouds['value'], null, $xml->clouds['name']);
        $this->precipitation = new _Unit($xml->precipitation['value'], $xml->precipitation['unit'], $xml->precipitation['mode']);
        $this->sun = new _Sun(new DateTime($xml->city->sun['rise']), new DateTime($xml->city->sun['set']));
        $this->weather = new _Weather($xml->weather['number'], $xml->weather['value'], $xml->weather['icon']);
        $this->lastUpdate = new DateTime($xml->lastupdate['value']);
    }
}

/**
 * @class General class for each value.
 */
class _Unit
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
        // Units are inconsistent. Only celsius and kelvin are not abbreviated. This check fixes that.
        if ($this->unit == 'celsius') {
            return '°C';
        } else if ($this->unit == 'kelvin') {
            return 'K';
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

class _Temperature
{
    public $now;
    
    public $min;
    
    public $max;
    
    public function __construct(_Unit $now, _Unit $min, _Unit $max)
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

class _Wind
{
    public $speed;
    
    public $direction;
    
    public function __construct(_Unit $speed, _Unit $direction)
    {
        $this->speed = $speed;
        $this->direction = $direction;
    }
}

class _Sun
{
    public $rise;
    
    public $set;
    
    public function __construct(DateTime $rise, DateTime $set)
    {
        $this->rise = $rise;
        $this->set = $set;
    }
}

class _City
{
    public $id;
    
    public $name;
    
    public $lon;
    
    public $lat;
    
    public $country;
    
    public function __construct($id, $name, $lon, $lat, $country)
    {
        $this->id = (int)$id;
        $this->name = (string)$name;
        $this->lon = (float)$lon;
        $this->lat = (float)$lat;
        $this->country = (string)$country;
    }
}

class _Weather
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

class OpenWeatherMap_Exception extends Exception
{

}
