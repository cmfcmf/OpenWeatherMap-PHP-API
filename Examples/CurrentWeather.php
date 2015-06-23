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

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

if (file_exists('../vendor/autoload.php')) {
    // Library is not part of a project. "composer install" was executed directly on this library's composer file.
    require('../vendor/autoload.php');
} else {
    // Library is part of a project.
    /** @noinspection PhpIncludeInspection */
    require('../../../autoload.php');
}

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Get OpenWeatherMap object. Don't use caching (take a look into Example_Cache.php to see how it works).
$owm = new OpenWeatherMap();

// Example 1: Get current temperature in Berlin.
$weather = $owm->getWeather('Berlin', $units, $lang);
echo "EXAMPLE 1<hr />\n\n\n";

// $weather contains all available weather information for Berlin.
// Let's get the temperature:

// Returns it as formatted string (using __toString()):
echo $weather->temperature;
echo "<br />\n";

// Returns it as formatted string (using a method):
echo $weather->temperature->getFormatted();
echo "<br />\n";

// Returns the value only:
echo $weather->temperature->getValue();
echo "<br />\n";

// Returns the unit only:
echo $weather->temperature->getUnit();
echo "<br />\n";

/**
 * In the example above we're using a "shortcut". OpenWeatherMap returns the minimum temperature of a day,
 * the maximum temperature and the temperature right now. If you don't specify which temperature you want, it will default
 * to the current temperature. See below how to access the other values. Notice that each of them has implemented the methods
 * "getFormatted()", "getValue()", "getUnit()".
 */

// Returns the current temperature:
echo "Current: " . $weather->temperature->now;
echo "<br />\n";

// Returns the minimum temperature:
echo "Minimum: " . $weather->temperature->min;
echo "<br />\n";

// Returns the maximum temperature:
echo "Maximum: " . $weather->temperature->max;
echo "<br />\n";

/**
 * When speaking about "current" and "now", this means when the weather data was last updated. You can get this
 * via a DateTime object:
 */
echo "Last update: " . $weather->lastUpdate->format('r');
echo "<br />\n";

// Example 2: Get current pressure and humidity in Hongkong.
$weather = $owm->getWeather('Hongkong', $units, $lang);
echo "<br /><br />\n\n\nEXAMPLE 2<hr />\n\n\n";

/**
 * You can use the methods above to only get the value or the unit.
 */

echo "Pressure: " . $weather->pressure;
echo "<br />\n";
echo "Humidity: " . $weather->humidity;
echo "<br />\n";

// Example 3: Get today's sunrise and sunset times.
echo "<br /><br />\n\n\nEXAMPLE 3<hr />\n\n\n";

/**
 * These functions return a DateTime object.
 */

echo "Sunrise: " . $weather->sun->rise->format('r');
echo "<br />\n";
echo "Sunset: " . $weather->sun->set->format('r');
echo "<br />\n";

// Example 4: Get current temperature from coordinates (Greenland :-) ).
$weather = $owm->getWeather(array('lat' => 77.73038, 'lon' => 41.89604), $units, $lang);
echo "<br /><br />\n\n\nEXAMPLE 4<hr />\n\n\n";

echo "Temperature: " . $weather->temperature;
echo "<br />\n";

// Example 5: Get current temperature from city id. The city is an internal id used by OpenWeatherMap. See example 6 too.
$weather = $owm->getWeather(2172797, $units, $lang);
echo "<br /><br />\n\n\nEXAMPLE 5<hr />\n\n\n";

echo "City: " . $weather->city->name;
echo "<br />\n";

echo "Temperature: " . $weather->temperature;
echo "<br />\n";

// Example 6: Get information about a city.
$weather = $owm->getWeather('Paris', $units, $lang);
echo "<br /><br />\n\n\nEXAMPLE 6<hr />\n\n\n";

echo "Id: " . $weather->city->id;
echo "<br />\n";

echo "Name: " . $weather->city->name;
echo "<br />\n";

echo "Lon: " . $weather->city->lon;
echo "<br />\n";

echo "Lat: " . $weather->city->lat;
echo "<br />\n";

echo "Country: " . $weather->city->country;
echo "<br />\n";

// Example 7: Get wind information.
echo "<br /><br />\n\n\nEXAMPLE 7<hr />\n\n\n";

echo "Speed: " . $weather->wind->speed;
echo "<br />\n";

echo "Direction: " . $weather->wind->direction;
echo "<br />\n";

/**
 * For speed and direction there is a description available, which isn't always translated.
 */

echo "Speed: " . $weather->wind->speed->getDescription();
echo "<br />\n";

echo "Direction: " . $weather->wind->direction->getDescription();
echo "<br />\n";

// Example 8: Get information about the clouds.
echo "<br /><br />\n\n\nEXAMPLE 8<hr />\n\n\n";

// The number in braces seems to be an indicator how cloudy the sky is.
echo "Clouds: " . $weather->clouds->getDescription() . " (" . $weather->clouds . ")";
echo "<br />\n";

// Example 9: Get information about precipitation.
echo "<br /><br />\n\n\nEXAMPLE 9<hr />\n\n\n";

echo "Precipation: " . $weather->precipitation->getDescription() . " (" . $weather->precipitation . ")";
echo "<br />\n";

// Example 10: Show copyright notice. WARNING: This is no offical text. This hint was created regarding to http://www.http://openweathermap.org/copyright .
echo "<br /><br />\n\n\nEXAMPLE 10<hr />\n\n\n";

echo $owm::COPYRIGHT;
echo "<br />\n";

// Example 11: Get raw xml data.
echo "<br /><br />\n\n\nEXAMPLE 11<hr />\n\n\n";

echo "<pre><code>" . htmlspecialchars($owm->getRawWeatherData('Berlin', $units, $lang, null, 'xml')) . "</code></pre>";
echo "<br />\n";

// Example 12: Get raw json data.
echo "<br /><br />\n\n\nEXAMPLE 12<hr />\n\n\n";

echo "<code>" . htmlspecialchars($owm->getRawWeatherData('Berlin', $units, $lang, null, 'json')) . "</code>";
echo "<br />\n";

// Example 13: Get raw html data.
echo "<br /><br />\n\n\nEXAMPLE 13<hr />\n\n\n";

echo $owm->getRawWeatherData('Berlin', $units, $lang, null, 'html');
echo "<br />\n";

// Example 14: Error handling.
echo "<br /><br />\n\n\nEXAMPLE 14<hr />\n\n\n";

// Try wrong city name.
try {
    $weather = $owm->getWeather("ThisCityNameIsNotValidAndDoesNotExist", $units, $lang);
} catch (OWMException $e) {
    echo $e->getMessage() . ' (Code ' . $e->getCode() . ').';
    echo "<br />\n";
}

// Try invalid $query.
try {
    $weather = $owm->getWeather(new \DateTime('now'), $units, $lang);
} catch (\Exception $e) {
    echo $e->getMessage() . ' (Code ' . $e->getCode() . ').';
    echo "<br />\n";
}

// Full error handling would look like this:
try {
    $weather = $owm->getWeather(-1, $units, $lang);
} catch (OWMException $e) {
    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
    echo "<br />\n";
} catch (\Exception $e) {
    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
    echo "<br />\n";
}

// Example 15: Using an api key:
$owm->getWeather('Berlin', $units, $lang, 'Your-Api-Key-Here');
