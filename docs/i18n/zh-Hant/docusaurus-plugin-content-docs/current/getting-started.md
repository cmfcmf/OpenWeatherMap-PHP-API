---
title: 入門指南
---

*OpenWeatherMap PHP API* 是 [OpenWeatherMap.org](http://www.OpenWeatherMap.org) 天氣 API 的 PHP 客戶端。

此項目旨在統一提供的數據並消除不一致性。它 **不是** 由 OpenWeatherMap 維護，也 **不是** 官方的 API 包裝器。

請注意，僅支持以下 API：

- [當前天氣數據](apis/current-weather.md)
- [16 天/每日和 5 天/每 3 小時預報](apis/weather-forecast.md)
- [空氣污染（CO、O3、SO2、NO2）](apis/air-pollution.md)
- [紫外線指數](apis/uv-index.md)

> 我對於添加支持 OpenWeatherMap 其他 API 的請求持開放態度，只要它們不需要付費訂閱。因為我無法自行支付測試付費 API 的費用。

## PHP 要求

- **PHP 7.1 及更高版本（包括 PHP 8）**（如果您仍在使用 PHP 5.x，您必須使用此庫的 2.x 版本）
- PHP json 擴展
- PHP libxml 擴展
- PHP simplexml 擴展

## 安裝

此項目可在 [Packagist](https://packagist.org/packages/cmfcmf/openweathermap-php-api) 上找到，最佳安裝方式是使用 [Composer](http://getcomposer.org)：

```bash
composer require "cmfcmf/openweathermap-php-api"
```

### 所需的 PSR-17/-18 依賴項

您還需要安裝兩個附加的依賴項：

1. 一個 [PSR-17](https://www.php-fig.org/psr/psr-17/) 兼容的 HTTP 工廠實現。
2. 一個 [PSR-18](https://www.php-fig.org/psr/psr-18/) 兼容的 HTTP 客戶端實現。

如果您將此項目集成到 PHP 框架中，它很可能已經包含了這些依賴項。
否則，請瀏覽 Packagist 上的實現列表，選擇適合您項目的實現：

- [PSR-17 兼容實現列表](https://packagist.org/providers/psr/http-factory-implementation)
- [PSR-18 兼容實現列表](https://packagist.org/providers/psr/http-client-implementation)

如果您不知道選擇哪個，請嘗試以下命令：

```bash
composer require "http-interop/http-factory-guzzle:^1.0" \
                "php-http/guzzle6-adapter:^2.0 || ^1.0"
```