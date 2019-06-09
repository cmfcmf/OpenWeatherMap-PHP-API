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
 * The weather class representing a weather object.
 */
class Weather
{
    /**
     * @var int The weather id.
     */
    public $id;

    /**
     * @var string The weather description.
     */
    public $description;

    /**
     * @var string the icon name.
     */
    public $icon;

    /**
     * @var string The url for icons.
     *
     * @see self::getIconUrl() to see how it is used.
     */
    private static $iconUrl = "//openweathermap.org/img/w/%s.png";

    /**
     * Create a new weather object.
     *
     * @param int    $id          The icon id.
     * @param string $description The weather description.
     * @param string $icon        The icon name.
     *
     * @internal
     */
    public function __construct($id, $description, $icon)
    {
        $this->id = (int)$id;
        $this->description = (string)$description;
        $this->icon = (string)$icon;
    }

    /**
     * Get the weather description.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->description;
    }

    /**
     * Get the icon url.
     *
     * @return string The icon url.
     */
    public function getIconUrl()
    {
        return sprintf(self::$iconUrl, $this->icon);
    }

    /**
     * Change the url template for icon urls. Please note: This will change the url template for
     * all instances of this library.
     *
     * @param string $iconUrl The url template to build the icon urls.
     */
    public static function setIconUrlTemplate($iconUrl)
    {
        self::$iconUrl = $iconUrl;
    }
}
