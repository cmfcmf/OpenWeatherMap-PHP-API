<?php

call_user_func(function () {
    if (!is_file($autoloadFile = __DIR__ . '/../vendor/autoload.php')) {
        throw new \RuntimeException('Did not find vendor/autoload.php. Did you run "composer install --dev"?');
    }

    /** @noinspection PhpIncludeInspection */
    require_once $autoloadFile;

    ini_set('date.timezone', 'Europe/Berlin');
});


// Load the api key.
$ini = parse_ini_file('ApiKey.ini');
$myApiKey = $ini['api_key'];
