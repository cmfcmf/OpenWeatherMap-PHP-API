---
title: 使用說明
---

所有 API 都可以通過 `Cmfcmf\OpenWeatherMap` 對象訪問。
要構建此對象，您需要提供您的 API 密鑰、兼容 PSR-18 的 HTTP 客戶端和兼容 PSR-17 的 HTTP 請求工廠：

```php
use Cmfcmf\OpenWeatherMap;

$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory);
```

> **注意：** 從現在起，我們將把 `Cmfcmf\OpenWeatherMap` 的實例稱為 `$owm`。

## 示例

```php
<?php
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

// 如果您沒有使用已包含 Composer 自動加載器的 PHP 框架，
// 您需要在使用此 API 之前 `require` 自動加載器腳本：
require 'vendor/autoload.php';

// 如果您安裝了推薦的 PSR-17/18 實現，這是創建必要的 `$httpClient` 和 `$httpRequestFactory` 的方法：
$httpRequestFactory = new RequestFactory();
$httpClient = GuzzleAdapter::createWithConfig([]);

$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory);

try {
    $weather = $owm->getWeather('Berlin', 'metric', 'de');
} catch(OWMException $e) {
    echo 'OpenWeatherMap 異常：' . $e->getMessage() . '（代碼 ' . $e->getCode() . '）。';
} catch(\Exception $e) {
    echo '一般異常：' . $e->getMessage() . '（代碼 ' . $e->getCode() . '）。';
}

echo $weather->temperature;
```

## `Unit` 對象

大多數值如溫度、降水量等，均以 `Cmfcmf\OpenWeatherMap\Util\Unit` 類的實例返回。這些對象提供了以下信息：
數值（例如，`26.9`），單位（例如，`°C`），以及有時候的描述（例如，`大雨`）。
為了使這一點更清楚，我們來看一個具體的例子：

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

## 請求緩存

您可以通過提供 [PSR-6 兼容](https://www.php-fig.org/psr/psr-6/) 的緩存作為第四個構造參數以及生存時間作為第五個參數來自動緩存請求：

```php
use Cmfcmf\OpenWeatherMap;

// 緩存時間以秒為單位，默認為 600 秒（10 分鐘）。
$ttl = 600;

$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory,
                          $cache, $ttl);
```

您可以通過調用 `->wasCached()` 檢查上次請求是否已緩存：

```php
$owm->getRawWeatherData('Berlin');

if ($owm->wasCached()) {
  echo "上次請求已緩存";
} else {
  echo "上次請求未緩存";
}
```

## 異常處理

確保適當處理異常。
每當 OpenWeatherMap API 返回異常時，它將被轉換為 `Cmfcmf\OpenWeatherMap\Exception` 的實例。
作為特殊情況，如果找不到您查詢的城市/位置/坐標，API 會拋出 `Cmfcmf\OpenWeatherMap\NotFoundException`。該異常繼承自 `Cmfcmf\OpenWeatherMap\Exception`。

如果發生其他錯誤，將拋出繼承自 `\Exception` 的異常。

```php
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Cmfcmf\OpenWeatherMap\NotFoundException as OWMNotFoundException;

try {
    $weather = $owm->getWeather('Berlin');
} catch (OWMNotFoundException $e) {
    // TODO: 處理“未找到城市”異常
    // 您可以選擇跳過 `OWM的處理程序，因為它繼承自 `OWMException`。
} catch (OWMException $e) {
    // TODO: 處理 API 異常
} catch (\Exception $e) {
    // TODO: 處理一般異常
}
```

這樣可以確保您的代碼能夠正確的處理不同類型的異常，並且可以根據不同的情況採取適當的行動。例如，您可以選擇記錄異常、重試請求或向用戶顯示錯誤消息。

通過這些基本的使用說明，您應該能夠開始使用 OpenWeatherMap PHP API 來獲取天氣數據並將其集成到您的應用程式中。確保遵循 OpenWeatherMap 的使用條款並正確處理所有潛在的異常情況，以確保您的應用程序穩定運行。