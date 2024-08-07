---
title: 天氣預報 API
sidebar_label: '天氣預報'
---

此 API 允許您檢索 16 天/每日和 5 天/3 小時的天氣預報。

> 對應的 OpenWeatherMap 文件：
> - [5 天/3 小時預報](https://openweathermap.org/forecast5)
> - [16 天/每日預報](https://openweathermap.org/forecast16)

`$owm->getWeatherForecast()` 函式接受以下參數：

| 名稱 | 類型 | 預設值 | 描述 |
|------|------|---------|-------------|
| `$query` | `mixed` | -- | 見下文 |
| `$units` | `"imperial"`&#124;`"metric"` | `"imperial"` | 使用的單位 |
| `$lang` | `string` | `en` | [官方文件](https://openweathermap.org/forecast16#multi)底部列出語言之一 |
| `$appid` | `string` | `''` | 已棄用，始終設置為 `''` |
| `$days` | `int` (1 - 16) | `1` | 要檢索預報的天數。如果 `$days` 在 1 到 5 之間，則使用 5 天/3 小時預報 API。如果 `$days` 在 6 到 16 之間，則使用 16 天/每日預報 API。|

如果您希望在有 3 小時預報時檢索每日預報，可以使用 `->getDailyWeatherForecast()`。

## `$query` 參數

第一個參數確定要獲取天氣數據的位置。有幾種可能的函式：

### 根據城市名稱

指定國家是可選的。

```php
$forecasts = $owm->getWeatherForecast('Berlin,DE', $units, $lang, '', $days);
```

### 根據城市 ID

一個城市 ID：
```php
$forecasts = $owm->getWeatherForecast(2172797, $units, $lang, '', $days);
```

### 根據郵政編碼

指定國家是可選的。

```php
// 印度，海得拉巴
$forecasts = $owm->getWeatherForecast('zip:500001,IN', $units, $lang, '', $days);
```

### 根據座標

```php
$forecasts = $owm->getWeatherForecast(['lat' => 77.73038, 'lon' => 41.89604],
                                     $units, $lang, '', $days);
```

## `$forecasts` 物件

`$forecasts` 是 `Cmfcmf\OpenWeatherMap\WeatherForecast` 的實例。它提供以下數據：

| 名稱 | 類型 | 描述 |
|------|------|-------------|
| `lastUpdate` | `\ḐateTimeInterface` | 數據的最後更新時間 |
| `city->id` | `int` | 內部城市 ID |
| `city->name` | `string` | 城市名稱 |
| `city->country` | `string` | 城市國家代碼 |
| `city->timezone` | `\DateTimeZone`&#124;`null` | 城市時區 |
| `city->lon` | `float` | 城市經度 |
| `city->lat` | `float` | 城市緯度 |

要檢索預報，請迭代該對象：

```php
foreach ($forecasts as $forecast) {
    // 執行操作
}
```

### `$forecast` 物件

`$forecast` 是 `Cmfcmf\OpenWeatherMap\Forecast` 的實例，繼承自 `Cmfcmf\OpenWeatherMap\CurrentWeather` 對象。

| 名稱 | 類型 | 描述 |
|------|------|-------------|
| `time->day` | `\DateTimeInterface` | 預報日期 |
| `time->from` | `\DateTimeInterface` | 預報的確切開始時間。對於 16 天/每日預報，這對應於 `time->day`。對於 5 天/3 小時預報，它對應於 3 小時窗口的開始。|
| `time->to` | `\DateTimeInterface` | 預報的確切結束時間。對於 16 天/每日預報，這對應於 `time->day` 的 `23:59:59`。對於 5 天/3 小時預報，它對應於 3 小時窗口的結束。|
| `...` | `...` | `CurrentWeather` 對象的所有其他屬性，如[此處](current-weather.md#weather-object)所述。|

### 僅適用於 5 天/3 小時預報

| 名稱 | 類型 | 描述 |
|------|------|-------------|
| `temperature->now` | `Unit` | 注意：這應該命名為 `temperature->avg`，僅因向後兼容性而命名為 `temperature->now`！返回給定位置的平均溫度（例如，大城市可能有多個溫度測量站） |
| `temperature->min` | `Unit` | 給定位置的最低溫度 |
| `temperature->max` | `Unit` | 給定位置的最高溫度 |

### 僅適用於 16 天/每日預報

| 名稱 | 類型 | 描述 |
|------|------|-------------|
| `temperature->morning` | `Unit` | 早晨的溫度 |
| `temperature->now` | `Unit` | 白天的溫度 |
| `temperature->evening` | `Unit` | 晚上的溫度 |
| `temperature->night` | `Unit` | 夜晚的溫度 |
| `temperature->min` | `Unit` | 白天的最低溫度 |
| `temperature->max` | `Unit` | 白天的最高溫度 |
