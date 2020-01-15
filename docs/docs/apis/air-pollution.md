---
title: Air Pollution API
sidebar_label: 'API: Air Pollution'
---

This API allows you to retrieve the current, forecast and historic ultraviolet index (UV index).

> Corresponding OpenWeatherMap documentation:
>
> - [Carbon Monoxide (CO)](https://openweathermap.org/api/pollution/co)
> - [Ozone (O3)](https://openweathermap.org/api/pollution/o3)
> - [Nitrogen Dioxide (NO2)](https://openweathermap.org/api/pollution/no2)
> - [Sulfor Dioxide (SO2)](https://openweathermap.org/api/pollution/so2)

## Usage

- `$type`: Can be one of `"O3"`, `"NO2"`, `"SO2"`, or `"CO"`.
- `$lat` / `$lng`: Latitude and longitude must be provided as strings, because
  the number of digits after the decimal point determines the search radius.
  Specifying more digits leads to closer results, but too many digits can lead
  to no result at all.
- `$date`: Date to retrieve data from. `"current"` requests the newest available
  information. You can also specify a date in ISO 8601 format. More information on
  that can be found [in the OpenWeatherMap documentation](https://openweathermap.org/api/pollution/co).

```php
// $type =
$co = $owm->getAirPollution($type, $lat, $lng, $date = "current");
```

The return value depends on the `$type` and is discussed in the next sections.

### Carbon Monoxide (CO)

```php
$co = $owm->getAirPollution("CO", "52", "13");
if ($co === null) {
    // No data available
} else {
    foreach ($co->values as $data) {
        echo $data["value"];
        echo $data["value"]->getPrecision();
        echo $data["pressure"];
    }
}
```

### Ozone (O3)

```php
$o3 = $owm->getAirPollution("O3", "52", "13");
if ($o3 === null) {
    // No data available
} else {
    echo $o3->value;
}
```

### Nitrogen Dioxide (NO2)

```php
$no2 = $owm->getAirPollution("NO2", "52", "13");
if ($no2 === null) {
    // No data available
} else {
    echo $no2->value;
    echo $no2->valueStratosphere;
    echo $no2->valueTroposphere;
}
```

### Sulfor Dioxide (SO2)

```php
$so2 = $owm->getAirPollution("SO2", "52", "13");
if ($so2 === null) {
    // No data available
} else {
    foreach ($so2->values as $data) {
        echo $data["value"];
        echo $data["value"]->getPrecision();
        echo $data["pressure"];
    }
}
```