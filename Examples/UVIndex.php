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

// You can use every PSR-17 compatible HTTP request factory
// and every PSR-18 compatible HTTP client.
$httpRequestFactory = new RequestFactory();
$httpClient = GuzzleAdapter::createWithConfig([]);

$owm = new OpenWeatherMap($myApiKey, $httpClient, $httpRequestFactory);

// Example 1: Get current uv index in Berlin.
$uvIndex = $owm->getCurrentUVIndex(52.520008, 13.404954);
echo "EXAMPLE 1$lf";

echo "Current uv index: $uvIndex->uvIndex";
echo $lf;

// Example 2: Get uv index forecast in Berlin.
$forecast = $owm->getForecastUVIndex(52.520008, 13.404954);
echo "EXAMPLE 2$lf";

foreach ($forecast as $day) {
    echo "{$day->time->format('r')} will have an uv index of: $day->uvIndex";
    echo $lf;
}


// Example 3: Get historic uv index in Berlin.
$history = $owm->getHistoricUVIndex(52.520008, 13.404954, new DateTime('-4month'), new DateTime('-3month'));
echo "EXAMPLE 3$lf";

foreach ($history as $day) {
    echo "{$day->time->format('r')} had an uv index of: $day->uvIndex";
    echo $lf;
}
