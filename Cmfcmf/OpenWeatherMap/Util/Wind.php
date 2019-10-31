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
     * @var Unit|null The wind direction.
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
    public function __construct(Unit $speed, Unit $direction = null)
    {
        $this->speed = $speed;
        $this->direction = $direction;
    }
}
