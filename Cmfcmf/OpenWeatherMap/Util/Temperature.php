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
 * The temperature class representing a temperature object.
 */
class Temperature
{
    /**
     * @var Unit The current temperature.
     */
    public $now;

    /**
     * @var Unit The minimal temperature.
     */
    public $min;

    /**
     * @var Unit The maximal temperature.
     */
    public $max;

    /**
     * @var Unit The day temperature. Might not be null.
     */
    public $day;
    
    /**
     * @var Unit The morning temperature. Might not be null.
     */
    public $morning;
    
    /**
     * @var Unit The evening temperature. Might not be null.
     */
    public $evening;
    
    /**
     * @var Unit The night temperature. Might not be null.
     */
    public $night;

    /**
     * Returns the current temperature as formatted string.
     *
     * @return string The current temperature as a formatted string.
     */
    public function __toString()
    {
        return $this->now->__toString();
    }

    /**
     * Returns the current temperature's unit.
     *
     * @return string The current temperature's unit.
     */
    public function getUnit()
    {
        return $this->now->getUnit();
    }

    /**
     * Returns the current temperature.
     *
     * @return string The current temperature.
     */
    public function getValue()
    {
        return $this->now->getValue();
    }

    /**
     * Returns the current temperature's description.
     *
     * @return string The current temperature's description.
     */
    public function getDescription()
    {
        return $this->now->getDescription();
    }

    /**
     * Returns the current temperature as formatted string.
     *
     * @return string The current temperature as formatted string.
     */
    public function getFormatted()
    {
        return $this->now->getFormatted();
    }

    /**
     * Create a new temperature object.
     *
     * @param Unit $now The current temperature.
     * @param Unit $min The minimal temperature.
     * @param Unit $max The maximal temperature.
     * @param Unit $day The day temperature. Might not be null.
     * @param Unit $morning The morning temperature. Might not be null.
     * @param Unit $evening The evening temperature. Might not be null.
     * @param Unit $night The night temperature. Might not be null.
     *
     * @internal
     */
    public function __construct(Unit $now, Unit $min, Unit $max, Unit $day = null, Unit $morning = null, Unit $evening = null, Unit $night = null)
    {
        $this->now = $now;
        $this->min = $min;
        $this->max = $max;
        $this->day = $day;
        $this->morning = $morning;
        $this->evening = $evening;
        $this->night = $night;
    }
}
