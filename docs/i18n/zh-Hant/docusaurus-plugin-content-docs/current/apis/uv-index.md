---
title: 紫外線指數 API
sidebar_label: '紫外線指數'
---

此 API 允許您檢索當前、預測和歷史的紫外線指數（UV 指數）。

> [對應的 OpenWeatherMap 文件](https://openweathermap.org/api/uvi)

## 當前紫外線指數

您可以通過緯度和經度檢索當前的紫外線指數。響應包括時間、位置和 UV 指數值。

```php
$uvIndex = $owm->getCurrentUVIndex($lat, $lon);
```

### 範例

獲取柏林的當前紫外線指數。

```php
$uvIndex = $owm->getCurrentUVIndex(52.520008, 13.404954);
echo "當前紫外線指數：$uvIndex->uvIndex";
```

## 預測紫外線指數

您可以檢索最多 8 天的紫外線指數預測。返回值是一個 `UVIndex` 對象的數組。

```php
$uvForecast = $owm->getForecastUVIndex($lat, $lon, $cnt = 8)
```

### 範例

```php
$forecast = $owm->getForecastUVIndex(52.520008, 13.404954);
foreach ($forecast as $day) {
    echo "{$day->time->format('r')} 的紫外線指數將為：$day->uvIndex";
}
```

## 歷史紫外線指數

您可以檢索從 2017 年 6 月開始的每日歷史紫外線指數數據。

```php
$history = $owm->getHistoricUVIndex($lat, $lon, $from, $to);
```

### 範例

檢索柏林四個月前的一個月歷史紫外線數據。

```php
$history = $owm->getHistoricUVIndex(52.520008, 13.404954,
                                    new DateTime('-4month'),
                                    new DateTime('-3month'));
foreach ($history as $day) {
    echo "{$day->time->format('r')} 的紫外線指數為：$day->uvIndex";
}
```