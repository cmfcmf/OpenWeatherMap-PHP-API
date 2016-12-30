<?php

call_user_func(function () {
    if (!is_file($autoloadFile = __DIR__ . '/../vendor/autoload.php')) {
        throw new \RuntimeException('Did not find vendor/autoload.php. Did you run "composer install --dev"?');
    }

    if (!is_file($autoloadCacheFile = __DIR__ . '/ExampleCacheTest.php')) {
        throw new \RuntimeException('Did not find CacheTest.php. Did you delete the "ExampleCacheTest.php"?');
    }

    /** @noinspection PhpIncludeInspection */
    require_once $autoloadFile;
    require_once $autoloadCacheFile;

    ini_set('date.timezone', 'Europe/Berlin');
});
