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

class PrecisionPressureValueAirPollution extends BaseAirPollution
{

    /**
     * @var object[]
     */
    public $values;

    public function __construct($json)
    {
        parent::__construct($json);

        $this->values = [];
        foreach ($json->data as $data) {
            $this->values[] = [
                "value" => new Unit($data->value, "g/m³", "", $data->precision),
                "pressure" => new Unit($data->pressure, "hPa"),
            ];
        }
    }
}
