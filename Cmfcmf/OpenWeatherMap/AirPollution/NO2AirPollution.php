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

namespace Cmfcmf\OpenWeatherMap\AirPollution;

use Cmfcmf\OpenWeatherMap\Util\Unit;

class NO2AirPollution extends BaseAirPollution
{

    /**
     * @var Unit
     */
    public $value;

    /**
     * @var Unit
     */
    public $valueStratosphere;

    /**
     * @var Unit
     */
    public $valueTroposphere;

    public function __construct($json)
    {
        parent::__construct($json);

        $this->value = new Unit($json->data->no2->value, "g/m³", "", $json->data->no2->precision);
        $this->valueStratosphere = new Unit($json->data->no2_strat->value, "g/m³", "", $json->data->no2_strat->precision);
        $this->valueTroposphere = new Unit($json->data->no2_trop->value, "g/m³", "", $json->data->no2_trop->precision);
    }
}
