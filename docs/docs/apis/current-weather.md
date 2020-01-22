---
title: Current Weather API
sidebar_label: 'API: Current Weather'
---

This API allows you to retrieve the current weather data.

> [Corresponding OpenWeatherMap Documentation](https://openweathermap.org/current)

The `$owm->getWeather()` method takes the following parameters:

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$query` | `mixed` | -- | See below
| `$units` | `"imperial"`&#124;`"metric"` | `"imperial"` | Units to use |
| `$lang` | `string` | `en` | One of the languages listed at the very bottom of [the official documentation](https://openweathermap.org/current#multi) |

## `$query` parameter

The first parameter determines the location to get weather data from.
Several possible approaches are possible:

### by city name

Specifying the country is optional.

```php
$weather = $owm->getWeather('Berlin,DE', $units, $lang);
```

### by city id

One city id:
```php
$weather = $owm->getWeather(2172797, $units, $lang);
```

Multiple city ids
```php
// WARNING: This uses a different method (getWeatherGroup) compared
// to the other query formats (getWeather)!
$weathers = $owm->getWeatherGroup([2172797, 2172798], $units, $lang);
foreach ($weathers as $weather) {
  // Do something
}
```

### by zip code

Specifying the country is optional.

```php
// Hyderabad, India
$weather = $owm->getWeather('zip:500001,IN', $units, $lang);
```

### by coordinates

```php
$weather = $owm->getWeather(['lat' => 77.73038, 'lon' => 41.89604],
                            $units, $lang);
```

## `$weather` object

The returned object is an instance of `Cmfcmf\OpenWeatherMap\CurrentWeather`.
It provides the following data:


| Name | Type | Description |
|------|------|-------------|
| `lastUpdate` | `\ḐateTimeInterface` | When the data was last updated |
| `temperature->now` | `Unit` | Note: This should be named `temperature->avg` and is only named `temperature->now` for backwards compatibility! Returns the average current temperature for the given location (i.e, a big city might have multiple temperature measurement stations) |
| `temperature->min` | `Unit` | Minimum current temperature for the given locaiton |
| `temperature->max` | `Unit` | Maximum current temperature for the given locaiton |
| `pressure` | `Unit` | Air pressure |
| `humidity` | `Unit` | Humidity |
| `sun->rise` | `\DateTimeInterface` | Time of sunrise |
| `sun->set` | `\DateTimeInterface` | Time of sunset |
| `wind->speed` | `Unit` | Wind speed |
| `wind->direction` | `Unit` | Wind direction |
| `clouds` | `Unit` | Cloudiness in percent |
| `precipitation` | `Unit` | Recent precipitation |
| `weather->id` | `int` | Current weather phenomenon id |
| `weather->description` | `string` | Current weather description |
| `weather->icon` | `string` | Current weather icon name. Use `weather->getIconUrl()` to get the url to an icon from OpenWeatherMap |
| `city->id` | `int` | Internal city id |
| `city->name` | `string` | Name of the city |
| `city->country` | `string` | City country code |
| `city->timezone` | `\DateTimeZone`&#124;`null` | City timezone |
| `city->lon` | `float` | City longitude |
| `city->lat` | `float` | City latitude |

## Retrieving raw data

### HTML

You can also request the data as an HTML page:

```php
$html = $owm->getRawWeatherData('Berlin', $units, $lang, null, 'html');
```

Result:

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
    <div style="display: block; clear: left; font-size: small;">Clouds: 89%</div>
    <div style="display: block; clear: left; color: gray; font-size: x-small;" >Humidity: 62%</div>
    <div style="display: block; clear: left; color: gray; font-size: x-small;" >Wind: 6.2 m/s</div>
    <div style="display: block; clear: left; color: gray; font-size: x-small;" >Pressure: 1014hpa</div>
  </div>
  <div style="display: block; clear: left; color: gray; font-size: x-small;">
    <a href="http://openweathermap.org/city/2950159?utm_source=openweathermap&utm_medium=widget&utm_campaign=html_old" target="_blank">More..</a>
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
Result:

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

Result:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<current><city id="2950159" name="Berlin"><coord lon="13.41" lat="52.52"></coord><country>DE</country><timezone>3600</timezone><sun rise="2020-01-15T07:10:19" set="2020-01-15T15:20:19"></sun></city><temperature value="12.73" min="11.67" max="13.89" unit="celsius"></temperature><feels_like value="7.4" unit="celsius"></feels_like><humidity value="62" unit="%"></humidity><pressure value="1014" unit="hPa"></pressure><wind><speed value="6.2" unit="m/s" name="Moderate breeze"></speed><gusts></gusts><direction value="200" code="SSW" name="South-southwest"></direction></wind><clouds value="89" name="Bedeckt"></clouds><visibility value="10000"></visibility><precipitation mode="no"></precipitation><weather number="804" value="Bedeckt" icon="04d"></weather><lastupdate value="2020-01-15T11:53:01"></lastupdate></current>
```