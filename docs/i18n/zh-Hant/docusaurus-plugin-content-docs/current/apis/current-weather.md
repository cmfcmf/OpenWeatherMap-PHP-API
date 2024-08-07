---
title: 當前天氣 API
sidebar_label: '當前天氣'
---

此 API 允許您檢索當前的天氣數據。

> [對應的 OpenWeatherMap 文件](https://openweathermap.org/current)

`$owm->getWeather()` 函式接受以下參數：

| 名稱 | 類型 | 預設值 | 描述 |
|------|------|---------|-------------|
| `$query` | `mixed` | -- | 請參見下文 |
| `$units` | `"imperial"`&#124;`"metric"` | `"imperial"` | 使用的單位 |
| `$lang` | `string` | `en` | 語言之一，請參見 [官方文件底部](https://openweathermap.org/current#multi) |

## `$query` 參數

第一個參數確定要獲取天氣數據的位置。有多種函式可用：

### 根據城市名稱

指定國家是可選的。

```php
$weather = $owm->getWeather('Berlin,DE', $units, $lang);
```

### 根據城市 ID

單個城市 ID：
```php
$weather = $owm->getWeather(2172797, $units, $lang);
```

多個城市 ID：
```php
// 警告：這使用了一個不同的函式 (getWeatherGroup)
// 與其他查詢格式 (getWeather) 不同！
$weathers = $owm->getWeatherGroup([2172797, 2172798], $units, $lang);
foreach ($weathers as $weather) {
  // 處理
}
```

### 根據郵政編碼

指定國家是可選的。

```php
// 印度，海得拉巴
$weather = $owm->getWeather('zip:500001,IN', $units, $lang);
```

### 根據座標

```php
$weather = $owm->getWeather(['lat' => 77.73038, 'lon' => 41.89604],
                            $units, $lang);
```

## `$weather` 對象

返回的對象是一個 `Cmfcmf\OpenWeatherMap\CurrentWeather` 實例。它提供以下數據：

| 名稱 | 類型 | 描述 |
|------|------|-------------|
| `lastUpdate` | `\DateTimeInterface` | 數據的最後更新時間 |
| `temperature->now` | `Unit` | 注意：這應命名為 `temperature->avg`，僅為向後兼容而命名為 `temperature->now`！返回給定位置的當前平均溫度（例如，一個大城市可能有多個溫度測量站） |
| `temperature->min` | `Unit` | 給定位置的當前最低溫度 |
| `temperature->max` | `Unit` | 給定位置的當前最高溫度 |
| `pressure` | `Unit` | 氣壓 |
| `humidity` | `Unit` | 濕度 |
| `sun->rise` | `\DateTimeInterface` | 日出時間 |
| `sun->set` | `\DateTimeInterface` | 日落時間 |
| `wind->speed` | `Unit` | 風速 |
| `wind->direction` | `Unit` | 風向 |
| `clouds` | `Unit` | 雲量百分比 |
| `precipitation` | `Unit` | 最近的降水 |
| `weather->id` | `int` | 當前天氣現象 ID |
| `weather->description` | `string` | 當前天氣描述 |
| `weather->icon` | `string` | 當前天氣圖標名稱。使用 `weather->getIconUrl()` 獲取 OpenWeatherMap 圖標的 URL |
| `city->id` | `int` | 內部城市 ID |
| `city->name` | `string` | 城市名稱 |
| `city->country` | `string` | 城市國家代碼 |
| `city->timezone` | `\DateTimeZone`&#124;`null` | 城市時區 |
| `city->lon` | `float` | 城市經度 |
| `city->lat` | `float` | 城市緯度 |

## 獲取原始數據

### HTML

您還可以請求以 HTML 頁面形式的數據：

```php
$html = $owm->getRawWeatherData('Berlin', $units, $lang, null, 'html');
```

結果：

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="keywords" content="weather, world, openweathermap, weather, layer" />
  <meta name="description" content="A layer with current weather conditions in cities for world wide" />
  <meta name="domain" content="openweathermap.org" />
  <meta http-equiv="pragma" content="no-cache" />
  <meta http-equiv="Expires" content="-1" />
</head>
<body>
  <div style="font-size: medium; font-weight: bold; margin-bottom: 0px;">Berlin</div>
  <div style="float: left; width: 130px;">
    <div style="display: block; clear: left;">
      <div style="float: left;" title="Titel">
        <img height="45" width="45" style="border: medium none; width: 45px; height: 45px; background: url(&quot;http://openweathermap.org/img/w/04d.png&quot;) repeat scroll 0% 0% transparent;" alt="title" src="http://openweathermap.org/images/transparent.png"/>
      </div>
      <div style="float: left;">
        <div style="display: block; clear: left; font-size: medium; font-weight: bold; padding: 0pt 3pt;" title="Current Temperature">12.73°C</div>
        <div style="display: block; width: 85px; overflow: visible;"></div>
      </div>
    </div>
    <div style="display: block; clear: left; font-size: small;">雲量：89%</div>
    <div style="display: block; clear: left; color: gray; font-size: x-small;" >濕度：62%</div>
    <div style="display: block; clear: left; color: gray; font-size: x-small;" >風速：6.2 m/s</div>
    <div style="display: block; clear: left; color: gray; font-size: x-small;" >氣壓：1014hpa</div>
  </div>
  <div style="display: block; clear: left; color: gray; font-size: x-small;">
    <a href="http://openweathermap.org/city/2950159?utm_source=openweathermap&utm_medium=widget&utm_campaign=html_old" target="_blank">更多..</a>
  </div>
  <script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-31601618-9', 'auto');ga('send', 'pageview');</script>
</body>
</html>
```

### JSON

```php
$json = $owm->getRawWeatherData('Berlin', 'metric', 'de', null, 'json');
```
結果：

```json
{
  "coord":{"lon":13.41,"lat":52.52},
  "weather":[{"id":804,"main":"Clouds","description":"Bedeckt","icon":"04d"}],
  "base":"stations",
  "main":{"temp":12.73,"feels_like":7.4,"temp_min":11.67,
          "temp_max":13.89,"pressure":1014,"humidity":62},
  "visibility":10000,
  "wind":{"speed":6.2,"deg":200},
  "clouds":{"all":89},
  "dt":1579089181,
  "sys":{"type":1,"id":1275,"country":"DE","sunrise":1579072219,"sunset":1579101619},
  "timezone":3600,
  "id":2950159,
  "name":"Berlin",
  "cod":200
}
```

### XML

```php
$xml = $owm->getRawWeatherData('Berlin', 'metric', 'de', null, 'xml');
```

結果：

```xml
<?xml version="1.0" encoding="UTF-8"?>
<current><city id="2950159" name="Berlin"><coord lon="13.41" lat="52.52"></coord><country>DE</country><timezone>3600</timezone><sun rise="2020-01-15T07:10:19

" set="2020-01-15T15:20:19"></sun></city><temperature value="12.73" min="11.67" max="13.89" unit="celsius"></temperature><feels_like value="7.4" unit="celsius"></feels_like><humidity value="62" unit="%"></humidity><pressure value="1014" unit="hPa"></pressure><wind><speed value="6.2" unit="m/s" name="Moderate breeze"></speed><gusts></gusts><direction value="200" code="SSW" name="South-southwest"></direction></wind><clouds value="89" name="Bedeckt"></clouds><visibility value="10000"></visibility><precipitation mode="no"></precipitation><weather number="804" value="Bedeckt" icon="04d"></weather><lastupdate value="2020-01-15T11:53:01"></lastupdate></current>
```