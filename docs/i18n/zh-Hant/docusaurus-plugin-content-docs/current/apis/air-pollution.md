---
title: 空氣污染 API
sidebar_label: '空氣污染'
---

此 API 允許您檢索當前、預測和歷史的紫外線指數（UV 指數）。

> 對應的 OpenWeatherMap 文件：
>
> - [一氧化碳 (CO)](https://openweathermap.org/api/pollution/co)
> - [臭氧 (O3)](https://openweathermap.org/api/pollution/o3)
> - [二氧化氮 (NO2)](https://openweathermap.org/api/pollution/no2)
> - [二氧化硫 (SO2)](https://openweathermap.org/api/pollution/so2)

## 用法

- `$type`：可以是 `"O3"`、`"NO2"`、`"SO2"` 或 `"CO"` 其中之一。
- `$lat` / `$lng`：緯度和經度必須以字符串形式提供，因為小數點後的位數決定了搜索半徑。指定更多位數會導致更精確的結果，但位數過多可能導致無法獲取結果。
- `$date`：要檢索數據的日期。`"current"` 請求最新可用的信息。您也可以以 ISO 8601 格式指定日期。更多信息請參見 [OpenWeatherMap 文件](https://openweathermap.org/api/pollution/co)。

```php
// $type =
$co = $owm->getAirPollution($type, $lat, $lng, $date = "current");
```

返回值取決於 `$type`，在後續部分進行討論。

## 一氧化碳 (CO)

```php
$co = $owm->getAirPollution("CO", "52", "13");
if ($co === null) {
    // 無可用數據
} else {
    foreach ($co->values as $data) {
        echo $data["value"];
        echo $data["value"]->getPrecision();
        echo $data["pressure"];
    }
}
```

## 臭氧 (O3)

```php
$o3 = $owm->getAirPollution("O3", "52", "13");
if ($o3 === null) {
    // 無可用數據
} else {
    echo $o3->value;
}
```

## 二氧化氮 (NO2)

```php
$no2 = $owm->getAirPollution("NO2", "52", "13");
if ($no2 === null) {
    // 無可用數據
} else {
    echo $no2->value;
    echo $no2->valueStratosphere;
    echo $no2->valueTroposphere;
}
```

## 二氧化硫 (SO2)

```php
$so2 = $owm->getAirPollution("SO2", "52", "13");
if ($so2 === null) {
    // 無可用數據
} else {
    foreach ($so2->values as $data) {
        echo $data["value"];
        echo $data["value"]->getPrecision();
        echo $data["pressure"];
    }
}
```