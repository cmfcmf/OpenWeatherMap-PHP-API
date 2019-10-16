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

namespace Cmfcmf\OpenWeatherMap;

/**
 * AirPollution class used to hold the air pollution and time of measurement
 */
class AirPollutionData
{
    /**
     * @var float measurement precision
     */
    public $precision;

    /**
     * @var float atmospheric pressure at the point of measurement in hPa
     */
    public $pressure;

    /**
     * @var float volume mixing ratio
     */
    public $value;

    /**
     * Create a new air pollution data object.
     *
     * @param object $json
     *
     * @internal
     */
    public function __construct($json)
    {
        $this->precision = (float)$json->precision;
        $this->pressure = (float)$json->pressure;
        $this->value = (float)$json->value;
    }

    /**
     * @return float
     */
    public function getPrecision(): float
    {
        return $this->precision;
    }

    /**
     * @return float
     */
    public function getPressure(): float
    {
        return $this->pressure;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
    
}
