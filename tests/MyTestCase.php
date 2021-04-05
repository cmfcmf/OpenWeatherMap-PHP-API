<?php

/*
 * OpenWeatherMap-PHP-API — A PHP API to parse weather data from https://OpenWeatherMap.org.
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of
 * OpenWeatherMap data before using this library:
 *
 * @see https://OpenWeatherMap.org/price
 * @see https://OpenWeatherMap.org/terms
 * @see https://OpenWeatherMap.org/appid
 */

namespace Cmfcmf\OpenWeatherMap\Tests;

abstract class MyTestCase extends \PHPUnit\Framework\TestCase
{
    public static function assertInternalType(string $expected, $actual, string $message = ''): void
    {
        if (version_compare(phpversion(), '7.2', '>=')) {
            switch ($expected) {
            case 'string':
                static::assertIsString($actual);
                break;
            case 'object':
                static::assertIsObject($actual);
                break;
            case 'float':
                static::assertIsFloat($actual);
                break;
            default:
                throw new Error();
            }
        } else {
            \PHPUnit\Framework\TestCase::assertInternalType($expected, $actual, $message);
        }
    }
}
