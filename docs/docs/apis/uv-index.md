---
title: Ultraviolet Index API
sidebar_label: 'API: Ultraviolet Index'
---

This API allows you to retrieve the current, forecast and historic ultraviolet index (UV index).

> [Corresponding OpenWeatherMap Documentation](https://openweathermap.org/api/uvi)

## Current UV index

You can retrieve the current UV index by latitude and longitude. The response includes
the time, location and UV index value.

```php
$uvIndex = $owm->getCurrentUVIndex($lat, $lon);
```

### Example

Get the current UV index in Berlin.

```php
$uvIndex = $owm->getCurrentUVIndex(52.520008, 13.404954);
echo "Current UV index: $uvIndex->uvIndex";
```

## Forecast UV index

You can retrieve a UV index forecast for up to 8 days. The return value is an
array of `UVIndex` objects.

```php
$uvForecast = $owm->getForecastUVIndex($lat, $lon, $cnt = 8)
```

### Example

```php
$forecast = $owm->getForecastUVIndex(52.520008, 13.404954);
foreach ($forecast as $day) {
    echo "{$day->time->format('r')} will have an uv index of: $day->uvIndex";
}
```

## Historic UV index

You can retrieve daily historic UV index data starting in June 2017.

```php
$history = $owm->getHistoricUVIndex($lat, $lon, $from, $to);
```

### Example

Retrieve one month of four month old historic UV data of Berlin.

```php
$history = $owm->getHistoricUVIndex(52.520008, 13.404954,
                                    new DateTime('-4month'),
                                    new DateTime('-3month'));
foreach ($history as $day) {
    echo "{$day->time->format('r')} had an uv index of: $day->uvIndex";
}
```