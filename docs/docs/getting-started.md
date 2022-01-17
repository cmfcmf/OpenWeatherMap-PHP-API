---
title: Getting Started
---

*OpenWeatherMap PHP API* is a PHP client for weather APIs from [OpenWeatherMap.org](http://www.OpenWeatherMap.org).

This project aims to normalise the provided data and remove inconsistencies.
It is **not** maintained by OpenWeatherMap and **not** an official API wrapper.

Please note that only the following APIs are supported:

- [Current Weather Data](apis/current-weather.md)
- [16-day/daily and 5-day/3-hourly Forecasts](apis/weather-forecast.md)
- [Air Pollution (CO, O3, SO2, NO2)](apis/air-pollution.md)
- [Ultraviolet Index](apis/uv-index.md)

> I am open for pull requests to add support for other APIs from OpenWeatherMap
> as long as they do not require a paid subscription. That is because I have no
> means to test paid APIs without paying myself.

## PHP Requirements

- **PHP 7.1 and later (including PHP 8)** (if you are still on PHP 5.x, you'll have to use version 2.x of this library)
- PHP json extension
- PHP libxml extension
- PHP simplexml extension

## Installation

This project can be found on [Packagist](https://packagist.org/packages/cmfcmf/openweathermap-php-api)
and is best installed using [Composer](http://getcomposer.org):

```bash
composer require "cmfcmf/openweathermap-php-api"
```

### Required PSR-17/-18 dependencies

You will also need to have two additional dependencies installed:

1. A [PSR-17](https://www.php-fig.org/psr/psr-17/) compatible HTTP factory implementation.
2. A [PSR-18](https://www.php-fig.org/psr/psr-18/) compatible HTTP client implementation.

I you are integrating this project into a PHP framework, it most likely already comes with these.
Otherwise, go through the lists of implementations on Packagist and choose ones that fit your project:

- [List of PSR-17-compatible implementations](https://packagist.org/providers/psr/http-factory-implementation)
- [List of PSR-18-compatible implementations](https://packagist.org/providers/psr/http-client-implementation)

If you don't know which to choose, try these:

```bash
composer require "http-interop/http-factory-guzzle:^1.0" \
                "php-http/guzzle6-adapter:^2.0 || ^1.0"
```
