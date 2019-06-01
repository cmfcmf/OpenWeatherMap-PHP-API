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
 * The sun class representing a sun object.
 */
class Sun
{
    /**
     * @var \DateTime The time of the sun rise.
     */
    public $rise;

    /**
     * @var \DateTime The time of the sun set.
     */
    public $set;

    /**
     * Create a new sun object.
     *
     * @param \DateTime $rise The time of the sun rise
     * @param \DateTime $set  The time of the sun set.
     *
     * @throws \LogicException If sunset is before sunrise.
     * @internal
     */
    public function __construct(\DateTime $rise, \DateTime $set)
    {
        if ($set < $rise) {
            throw new \LogicException('Sunset cannot be before sunrise!');
        }
        $this->rise = $rise;
        $this->set = $set;
    }
}
