OpenWeatherMap PHP API
======================

A PHP 7.1+ (including PHP 8) API to retrieve and parse global weather data from
[OpenWeatherMap.org](http://www.OpenWeatherMap.org).
This project aims to normalise the provided data and remove inconsistencies.
It is not maintained by OpenWeatherMap and not an official API wrapper.

[![Gitpod Ready-to-Code](https://img.shields.io/badge/Gitpod-Ready--to--Code-blue?logo=gitpod)](https://gitpod.io/#https://github.com/cmfcmf/OpenWeatherMap-PHP-API)
[![Build Status](https://github.com/cmfcmf/OpenWeatherMap-PHP-API/actions/workflows/main.yml/badge.svg)](https://github.com/cmfcmf/OpenWeatherMap-PHP-API/actions/workflows/main.yml)
[![license](https://img.shields.io/github/license/cmfcmf/OpenWeatherMap-PHP-Api.svg)](https://github.com/cmfcmf/OpenWeatherMap-PHP-Api/blob/master/LICENSE)
[![release](https://img.shields.io/github/release/cmfcmf/OpenWeatherMap-PHP-Api.svg)](https://github.com/cmfcmf/OpenWeatherMap-PHP-Api/releases)
[![codecov](https://codecov.io/gh/cmfcmf/OpenWeatherMap-PHP-Api/branch/main/graph/badge.svg)](https://codecov.io/gh/cmfcmf/OpenWeatherMap-PHP-Api)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/badges/quality-score.png?s=f31ca08aa8896416cf162403d34362f0a5da0966)](https://scrutinizer-ci.com/g/cmfcmf/OpenWeatherMap-PHP-Api/)

Documentation
=============

You can find the latest documentation, including installation and usage instructions at https://cmfcmf.github.io/OpenWeatherMap-PHP-API.

Contributing
============
I'm happy about every **pull request** you open and **issue** you find to help make this API **more awesome**. Please note that it might sometimes take me a while to get back to you. Feel free to ping me if I don't respond.

## Gitpod

You can use Gitpod to launch a fully functional development environment right in your browser. Simply click on the following badge:

[![Gitpod Ready-to-Code](https://img.shields.io/badge/Gitpod-Ready--to--Code-blue?logo=gitpod)](https://gitpod.io/#https://github.com/cmfcmf/OpenWeatherMap-PHP-API)

## Vagrant

You can use [Vagrant](https://vagrantup.com) to kick-start your development.
Simply run `vagrant up` and `vagrant ssh` to start a PHP VM with all
dependencies included.

## Docker

You can also use Docker to start developing this library. First install dependencies:

    docker run --rm --interactive --tty \
        --volume $PWD:/app \
        --user $(id -u):$(id -g) \
        composer update

And then execute the tests:

    docker run --rm --interactive --tty \
        --volume $PWD:/app -w /app \
        php bash

    > php vendor/bin/phpunit

## Documentation

The documentation is built using [Docusuaurs v2](https://v2.docusaurus.io/).
To run a local developnment server for the docs, execute

```bash
cd docs
yarn install
yarn start
```

License
=======

This project is licensed under the MIT license.
Please see the [LICENSE file](https://github.com/Cmfcmf/OpenWeatherMap-PHP-Api/blob/master/LICENSE)
distributed with this source code for further information regarding copyright and licensing.

Be aware that the OpenWeatherMap data is **not licensed under the MIT**.
**Check out the following official links to read about the terms, pricing and license of OpenWeatherMap before using their service:**

- [OpenWeatherMap.org/terms](http://OpenWeatherMap.org/terms)
- [OpenWeatherMap.org/appid](http://OpenWeatherMap.org/appid)
