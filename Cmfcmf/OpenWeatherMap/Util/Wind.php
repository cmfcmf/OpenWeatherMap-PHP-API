<?php
/**
 * OpenWeatherMap-PHP-API — A php api to parse weather data from http://www.OpenWeatherMap.org .
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of
 * OpenWeatherMap before using this class:
 *
 * @see http://www.OpenWeatherMap.org
 * @see http://www.OpenWeatherMap.org/terms
 * @see http://openweathermap.org/appid
 */

namespace Cmfcmf\OpenWeatherMap\Util;

/**
 * The wind class representing a wind object.
 */
class Wind
{
    /**
     * @var Unit The wind speed.
     */
    public $speed;

    /**
     * @var Unit The wind direction.
     */
    public $direction;

    /**
     * Create a new wind object.
     *
     * @param Unit $speed     The wind speed.
     * @param Unit $direction The wind direction.
     *
     * @internal
     */
    public function __construct(Unit $speed, Unit $direction)
    {
        $this->speed = $speed;
        $this->direction = $direction;
    }
}
