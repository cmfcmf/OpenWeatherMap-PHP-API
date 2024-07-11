---
title: Usage
---

All APIs can be accessed through the `Cmfcmf\OpenWeatherMap` object.
To construct this object, you need to supply your API key, the PSR-18-compatible
HTTP client and the PSR-17-compatible HTTP request factory:

```php
use Cmfcmf\OpenWeatherMap;

$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory);
```

> **Note:** From now on, we will refer to the instance of `Cmfcmf\OpenWeatherMap` as `$owm`.

## Example

```php
<?php
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

// If you are not using a PHP framework that has included Composer's autoloader for you,
// you'll need to `require` the autoloader script before working with this API:
require 'vendor/autoload.php';

// If you installed the recommended PSR-17/18 implementations, here's how to create the
// necessary `$httpClient` and `$httpRequestFactory`:
$httpRequestFactory = new RequestFactory();
$httpClient = GuzzleAdapter::createWithConfig([]);

$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory);

try {
    $weather = $owm->getWeather('Berlin', 'metric', 'de');
} catch(OWMException $e) {
    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
} catch(\Exception $e) {
    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
}

echo $weather->temperature;
```

## `Unit` objects

Most values like temperature, precipitation, etc., are returned as instances of the
`Cmfcmf\OpenWeatherMap\Util\Unit` class. These objects provide you with
the value (e.g., `26.9`),
the unit (e.g., `°C`),
and sometimes a description (e.g., `heavy rain`).
To make this clearer, let's look at a concrete example:

```php
$weather = $owm->getWeather('Berlin', 'metric');
// @var Cmfcmf\OpenWeatherMap\Util\Unit $temperature
$temperature = $weather->temperature->now;

$temperature->getValue(); // 26.9
$temperature->getUnit(); // "°C"
$temperature->getDescription(); // ""
$temperature->getFormatted(); // "26.9 °C"
$temperature->__toString(); // "26.9 °C"
```

## Caching requests

You can automatically cache requests by supplying a [PSR-6-compatible](https://www.php-fig.org/psr/psr-6/)
cache as the fourth constructor parameter and the time to live as the fifth parameter:

```php {7}
use Cmfcmf\OpenWeatherMap;

// Cache time in seconds, defaults to 600 = 10 minutes.
$ttl = 600;

$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory,
                          $cache, $ttl);
```

You can check whether the last request was cached by calling `->wasCached()`:

```php {3}
$owm->getRawWeatherData('Berlin');

if ($owm->wasCached()) {
  echo "last request was cached";
} else {
  echo "last request was not cached";
}
```

## Exception handling

Make sure to handle exceptions appropriately.
Whenever the OpenWeatherMap API returns an exception, it is converted into an instance of
`Cmfcmf\OpenWeatherMap\Exception`.
As a special case, the API will throw a `Cmfcmf\OpenWeatherMap\NotFoundException` if the city/location/coordinates you are querying cannot be found. This exception inherits from `Cmfcmf\OpenWeatherMap\Exception`.

If anything else goes wrong, an exception inheriting from `\Exception` is thrown.

```php {5,7}
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Cmfcmf\OpenWeatherMap\NotFoundException as OWMNotFoundException;

try {
    $weather = $owm->getWeather('Berlin');
} catch (OWMNotFoundException $e) {
    // TODO: Handle "city was not found" exception
    // You can opt to skip the handler for `OWMNotFoundException`, because it extends `OWMException`.
} catch (OWMException $e) {
    // TODO: Handle API exception
} catch (\Exception $e) {
    // TODO: Handle general exception
}
```