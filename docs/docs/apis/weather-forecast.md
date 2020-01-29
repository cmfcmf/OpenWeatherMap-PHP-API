---
title: Weather Forecast API
sidebar_label: 'Weather Forecast'
---

This API allows you to retrieve 16-day/daily and 5-day/3-hourly weather forecasts.

> Corresponding OpenWeatherMap Documentation:
> - [5-day/3-hourly Forecasts](https://openweathermap.org/forecast5)
> - [16-day/daily Forecasts](https://openweathermap.org/forecast16)

The `$owm->getWeatherForecast()` method takes the following parameters:

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$query` | `mixed` | -- | See below
| `$units` | `"imperial"`&#124;`"metric"` | `"imperial"` | Units to use |
| `$lang` | `string` | `en` | One of the languages listed at the very bottom of [the official documentation](https://openweathermap.org/forecast16#multi) |
| `$appid` | `string` | `''` | Deprecated, always set to `''` |
| `$days` | `int` (1 - 16) | `1` | Number of days to retrieve the forecast for. If `$days` is between 1 and 5, the 5-day/3-hourly forecast API is used. If `$days` is between 6 and 16, the 16-day/daily forecast API is used. |

You can use `->getDailyWeatherForecast()` if instead if you want to retrieve a daily forecast even when a 3-horuly forecast is available.

## `$query` parameter

The first parameter determines the location to get weather data from.
Several possible approaches are possible:

### by city name

Specifying the country is optional.

```php
$forecasts = $owm->getWeatherForecast('Berlin,DE', $units, $lang, '', $days);
```

### by city id

One city id:
```php
$forecasts = $owm->getWeatherForecast(2172797, $units, $lang, '', $days);
```

### by zip code

Specifying the country is optional.

```php
// Hyderabad, India
$forecasts = $owm->getWeatherForecast('zip:500001,IN', $units, $lang, '', $days);
```

### by coordinates

```php
$forecasts = $owm->getWeatherForecast(['lat' => 77.73038, 'lon' => 41.89604],
                                     $units, $lang, '', $days);
```

## `$forecasts` object

The `$forecasts` is an instance of `Cmfcmf\OpenWeatherMap\WeatherForecast`.
It provides the following data:

| Name | Type | Description |
|------|------|-------------|
| `lastUpdate` | `\ḐateTimeInterface` | When the data was last updated |
| `city->id` | `int` | Internal city id |
| `city->name` | `string` | Name of the city |
| `city->country` | `string` | City country code |
| `city->timezone` | `\DateTimeZone`&#124;`null` | City timezone |
| `city->lon` | `float` | City longitude |
| `city->lat` | `float` | City latitude |

To retrieve the forecasts, iterate over the object:

```php
foreach ($forecasts as $forecast) {
    // Do something
}
```

### `$forecast` object

The `$forecast` is an instance of `Cmfcmf\OpenWeatherMap\Forecast` that extends the `Cmfcmf\OpenWeatherMap\CurrentWeather` object.

| Name | Type | Description |
|------|------|-------------|
| `time->day` | `\DateTimeInterface` | The day of the forecast |
| `time->from` | `\DateTimeInterface` | The exact start time of the forecast. For 16-day/daily forecasts, this corresponds to `time->day`. For 5-day/3-hourly forecasts, it corresponds to the start of the 3-hour window. |
| `time->to` | `\DateTimeInterface` | The exact end time of the forecast. For 16-day/daily forecasts, this corresponds to `time->day` at `23:59:59`. For 5-day/3-hourly forecasts, it corresponds to the end of the 3-hour window.  |
| `...` | `...` | All other properties from the `CurrentWeather` object, as described [here](current-weather.md#weather-object). |

### only for 5-day/3-hourly forecasts

| Name | Type | Description |
|------|------|-------------|
| `temperature->now` | `Unit` | Note: This should be named `temperature->avg` and is only named `temperature->now` for backwards compatibility! Returns the average temperature for the given location (i.e, a big city might have multiple temperature measurement stations) |
| `temperature->min` | `Unit` | Minimum temperature for the given locaiton |
| `temperature->max` | `Unit` | Maximum temperature for the given locaiton |

### only for 16-day/hourly forecasts

| Name | Type | Description |
|------|------|-------------|
| `temperature->morning` | `Unit` | Temperature at morning |
| `temperature->now` | `Unit` | Temperature at day |
| `temperature->evening` | `Unit` | Temperature at evening |
| `temperature->night` | `Unit` | Temperature at night |
| `temperature->min` | `Unit` | Minimum temperature at day |
| `temperature->max` | `Unit` | Maximum temperature at day |
