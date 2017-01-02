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

use \Cmfcmf\OpenWeatherMap\CurrentWeatherGroup;

class CurrentWeatherGroupTest extends \PHPUnit_Framework_TestCase
{
    protected $fakeJson;
    protected $currentWeatherGroup;

    public function setUp()
    {
        $this->fakeJson = '{
            "list":[{
                "id":1851632,
                "dt":1406106000,
                "coord":{"lon":138.933334,"lat":34.966671},
                "sys":{"type":3,"id":168940,"message":0.0297,"country":"US","sunrise":1427723751,"sunset":1427768967},
                "name":"Shuzenji",
                "main":{
                    "temp":298.77,
                    "temp_min":298.77,
                    "temp_max":298.774,
                    "pressure":1005.93,
                    "sea_level":1018.18,
                    "grnd_level":1005.93,
                    "humidity":87
                },
                "weather":[{"id":804,"main":"Clouds","description":"overcast clouds","icon":"04d"}],
                "clouds":{"all":88},
                "wind":{"speed":5.71,"deg":229.501},
                "dt_txt":"2014-07-23 09:00:00"
            },{
                "id":1851632,
                "dt":1406106000,
                "coord":{"lon":138.933334,"lat":34.966671},
                "sys":{"type":3,"id":168940,"message":0.0297,"country":"US","sunrise":1427723751,"sunset":1427768967},
                "name":"Shuzenji",
                "main":{
                    "temp":298.77,
                    "temp_min":298.77,
                    "temp_max":298.774,
                    "pressure":1005.93,
                    "sea_level":1018.18,
                    "grnd_level":1005.93,
                    "humidity":87
                },
                "weather":[{"id":804,"main":"Clouds","description":"overcast clouds","icon":"04d"}],
                "clouds":{"all":88},
                "wind":{"speed":5.71,"deg":229.501},
                "dt_txt":"2014-07-23 09:00:00"
            }]
        }';
        $this->fakeJson = json_decode($this->fakeJson);
        $this->currentWeatherGroup = new CurrentWeatherGroup($this->fakeJson, 'metric');
    }

    public function testRewind()
    {
        $expectIndex = 1851632;
        $currentWeatherGroup = $this->currentWeatherGroup;
        $currentWeatherGroup->rewind();
        $position = $currentWeatherGroup->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testCurrent()
    {
        $currentWeatherGroup = $this->currentWeatherGroup;
        $currentWeatherGroup->rewind();
        $current = $currentWeatherGroup->current();

        $this->assertInternalType('object', $current);
    }
    public function testNext()
    {
        $expectIndex = 1851632;
        $currentWeatherGroup = $this->currentWeatherGroup;
        $currentWeatherGroup->next();
        $position = $currentWeatherGroup->key();

        $this->assertSame($expectIndex, $position);
    }

    public function testValid()
    {
        $currentWeatherGroup = $this->currentWeatherGroup;
        $currentWeatherGroup->rewind();
        $currentWeatherGroup->next();
        $result = $currentWeatherGroup->valid();

        $this->assertTrue($result);
    }
}
