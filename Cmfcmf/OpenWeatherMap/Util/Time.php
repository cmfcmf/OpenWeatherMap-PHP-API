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
     * @param string|\DateTime      $from The start time for the forecast.
     * @param string|\DateTime|null $to   The end time for the forecast.
     *
     * @internal
     */
    public function __construct($from, $to = null)
    {
        $utctz = new \DateTimeZone('UTC');
        if (isset($to)) {
            $from = ($from instanceof \DateTime) ? $from : new \DateTime((string)$from, $utctz);
            $to = ($to instanceof \DateTime) ? $to : new \DateTime((string)$to, $utctz);
            $day = new \DateTime($from->format('Y-m-d'), $utctz);
        } else {
            $from = ($from instanceof \DateTime) ? $from : new \DateTime((string)$from, $utctz);
            $day = $from = new \DateTime($from->format('Y-m-d'), $utctz);
            $to = clone $from;
            $to = $to->add(new \DateInterval('PT23H59M59S'));
        }

        $this->from = $from;
        $this->to = $to;
        $this->day = $day;
    }
}
