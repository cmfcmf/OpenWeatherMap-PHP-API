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
 * The time class representing a time object.
 */
class Time
{
    /**
     * @var \DateTime The start time for the forecast.
     */
    public $from;

    /**
     * @var \DateTime The end time for the forecast.
     */
    public $to;

    /**
     * @var \DateTime The day of the forecast.
     */
    public $day;

    /**
     * Create a new time object.
     *
     * @param string|\DateTime $from The start time for the forecast.
     * @param string|\DateTime $to   The end time for the forecast.
     *
     * @internal
     */
    public function __construct($from, $to = null)
    {
        if (isset($to)) {
            $from = ($from instanceof \DateTime) ? $from : new \DateTime((string)$from);
            $to = ($to instanceof \DateTime) ? $to : new \DateTime((string)$to);
            $day = new \DateTime($from->format('Y-m-d'));
        } else {
            $from = ($from instanceof \DateTime) ? $from : new \DateTime((string)$from);
            $day = clone $from;
            $to = clone $from;
            $to = $to->add(new \DateInterval('PT23H59M59S'));
        }

        $this->from = $from;
        $this->to = $to;
        $this->day = $day;
    }
}
