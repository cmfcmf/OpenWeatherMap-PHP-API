<?php
/**
 * Copyright Zikula Foundation 2014 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPv3 (or at your option any later version).
 * @package OpenWeatherMap-PHP-Api
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

namespace Cmfcmf\OpenWeatherMap\Tests\OpenWeatherMap;

use \Cmfcmf\OpenWeatherMap\WeatherHistory;

class WeatherHistoryTest extends \PHPUnit_Framework_TestCase
{
    protected $fakeJson;
    protected $history;

    protected function setUp()
    {
        $this->fakeJson = '{
            "cod":"200","calctime":"123456789","message":0.0032,"city_id":{"id":1851632,"name":"Shuzenji","coord":{"lon":138.933334,"lat":34.966671},"country":"JP"},
            "cnt":10,
            "list":[{
                "dt":1406080800,
                "temp":{
                    "day":297.77,
                    "min":293.52,
                    "max":297.77,
                    "night":293.52,
                    "eve":297.77,
                    "morn":297.77
                },
                "pressure":925.04,
                "humidity":76,
                "weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],
                "main":{"temp":306.15,"pressure":1013,"humidity":44,"temp_min":306,"temp_max":306},
                "clouds":{"all":90},
                "wind":{"speed":5.71,"deg":229.501}
            },{
                "dt":1406080800,
                "temp":{
                    "day":297.77,
                    "min":293.52,
                    "max":297.77,
                    "night":293.52,
                    "eve":297.77,
                    "morn":297.77
                },
                "pressure":925.04,
                "humidity":76,
                "weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],
                "main":{"temp":306.15,"pressure":1013,"humidity":44,"temp_min":306,"temp_max":306},
                "clouds":{"all":90},
                "wind":{"speed":5.71,"deg":229.501}
            }]
        }';
        $this->fakeJson = json_decode($this->fakeJson, true);
        $this->history = new WeatherHistory($this->fakeJson, 'Berlin');
    }

    public function testRewind()
    {
        $expectIndex = 0;
        $history = $this->history;
        $history->rewind();
        $position = $history->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testCurrent()
    {
        $history = $this->history;
        $history->rewind();
        $current = $history->current();

        $this->assertInternalType('object', $current);
    }

    public function testNext()
    {
        $expectIndex = 1;
        $history = $this->history;
        $history->next();
        $position = $history->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testValid()
    {
        $history = $this->history;
        $history->rewind();
        $history->next();
        $result = $history->valid();

        $this->assertTrue($result);
    }

    public function testJsonHasCountryAndPopulation()
    {
        $fakeJson = '{
            "cod":"200","calctime":"123456789","message":0.0032,"city_id":{"id":1851632,"name":"Shuzenji","coord":{"lon":138.933334,"lat":34.966671},"country":"JP"},
            "cnt":10,
            "list":[{
                "city":{
                    "country": "Berlin", 
                    "population": "10,000"
                }
                },{
                    "dt":1406080800,
                    "temp":{
                        "day":297.77,
                        "min":293.52,
                        "max":297.77,
                        "night":293.52,
                        "eve":297.77,
                        "morn":297.77
                    },
                    "pressure":925.04,
                    "humidity":76,
                    "weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],
                    "main":{"temp":306.15,"pressure":1013,"humidity":44,"temp_min":306,"temp_max":306},
                    "clouds":{"all":90},
                    "wind":{"speed":5.71,"deg":229.501}
            }]
        }';
        $fakeJson = json_decode($fakeJson, true);
        $history = new WeatherHistory($fakeJson, 'Berlin');

        $history->rewind();
        $result = $history->valid();

        $this->assertTrue($result);
    }

    public function testJsonWithRainKey()
    {
        $fakeJson = '{
            "cod":"200","calctime":"123456789","message":0.0032,"city_id":{"id":1851632,"name":"Shuzenji","coord":{"lon":138.933334,"lat":34.966671},"country":"JP"},
            "cnt":10,
            "list":[{
                "city":{
                    "country": "Berlin", 
                    "population": "10,000"
                }
                },{
                    "dt":1406080800,
                    "temp":{
                        "day":297.77,
                        "min":293.52,
                        "max":297.77,
                        "night":293.52,
                        "eve":297.77,
                        "morn":297.77
                    },
                    "pressure":925.04,
                    "humidity":76,
                    "weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],
                    "main":{"temp":306.15,"pressure":1013,"humidity":44,"temp_min":306,"temp_max":306},
                    "clouds":{"all":90},
                    "wind":{"speed":5.71,"deg":229.501},
                    "rain":{"3h":3}
            }]
        }';
        $fakeJson = json_decode($fakeJson, true);
        $history = new WeatherHistory($fakeJson, 'Berlin');
        
        $history->rewind();
        $result = $history->valid();

        $this->assertTrue($result);
    }
}
