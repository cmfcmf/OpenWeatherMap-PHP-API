<?php

use cmfcmf\OpenWeatherMap;

require('cmfcmf/OpenWeatherMap.php');

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// Example 1: Use your own cache implementation. See the example_cache file.
$owm = new OpenWeatherMap('examplecache', 100);

$weather = $owm->getWeather('Berlin', $units, $lang);
echo "EXAMPLE 1<hr />\n\n\n";
echo $weather->temperature;
