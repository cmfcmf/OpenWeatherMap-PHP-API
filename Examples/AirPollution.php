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

use Cmfcmf\OpenWeatherMap;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

require_once __DIR__ . '/bootstrap.php';

$cli = false;
$lf = '<br>';
if (php_sapi_name() === 'cli') {
    $lf = "\n";
    $cli = true;
}

// Language of data (try your own language here!):
$lang = 'de';

// Units (can be 'metric' or 'imperial' [default]):
$units = 'metric';

// You can use every PSR-17 compatible HTTP request factory
// and every PSR-18 compatible HTTP client.
$httpRequestFactory = new RequestFactory();
$httpClient = GuzzleAdapter::createWithConfig([]);

$owm = new OpenWeatherMap($myApiKey, $httpClient, $httpRequestFactory);

// Example 1: Get current air pollution in Berlin.
$o3 = $owm->getAirPollution("O3", "52", "13");
$no2 = $owm->getAirPollution("NO2", "52", "13");
$so2 = $owm->getAirPollution("SO2", "52", "13");
$co = $owm->getAirPollution("CO", "52", "13");

echo "O3: ";
if ($o3 === null) {
    echo "no data" . $lf;
} else {
    echo $o3->value . $lf;
}

echo "NO2: ";
if ($no2 === null) {
    echo "no data" . $lf;
} else {
    echo $no2->value;
}

echo "SO2: ";
if ($so2 === null) {
    echo "no data" . $lf;
} else {
    foreach ($so2->values as $data) {
        echo "value: " . $data["value"] . " (precision: " . $data["value"]->getPrecision() . ", pressure: " . $data["pressure"] . ")" . $lf;
    }
}

echo "CO: ";
if ($co === null) {
    echo "no data" . $lf;
} else {
    foreach ($co->values as $data) {
        echo "value: " . $data["value"] . " (precision: " . $data["value"]->getPrecision() . ", pressure: " . $data["pressure"] . ")" . $lf;
    }
}
