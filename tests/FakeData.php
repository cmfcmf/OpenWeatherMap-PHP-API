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

class FakeData
{
    const WEATHER_GROUP_JSON = '{
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

    public static function forecastXML()
    {
        return '<weatherdata>
        <location>
            <name>Berlin</name>
            <type></type>
            <country>DE</country>
            <timezone></timezone>
            <location altitude="0" latitude="52.524368" longitude="13.41053" geobase="geonames" geobaseid="2950159"></location>
        </location>
        <credit></credit>
        <meta>
            <lastupdate></lastupdate>
            <calctime>0.0215</calctime>
            <nextupdate>
            </nextupdate>
        </meta>
        <sun rise="2016-12-28T07:17:18" set="2016-12-28T14:59:55"></sun>
        <forecast>
            <time day="' . date('Y-m-d', time() + 0) . '">
                <symbol number="500" name="light rain" var="10d"></symbol>
                <precipitation value="0.25" type="rain"></precipitation>
                <windDirection deg="315" code="NW" name="Northwest"></windDirection>
                <windSpeed mps=" 4.38" name="Gentle Breeze"></windSpeed>
                <temperature day="41" min="40.59" max="41" night="40.59" eve="41" morn="41"></temperature>
                <pressure unit="hPa" value="1048.25"></pressure>
                <humidity value="97" unit="%"></humidity>
                <clouds value="overcast clouds" all="92" unit="%"></clouds>
            </time>
            <time day="' . date('Y-m-d', time() + 3600) . '">
                <symbol number="500" name="light rain" var="10d"></symbol>
                <precipitation value="0.24" type="rain"></precipitation>
                <windDirection deg="253" code="WSW" name="West-southwest"></windDirection>
                <windSpeed mps="6.2" name="Moderate breeze"></windSpeed>
                <temperature day="40.14" min="28.96" max="40.14" night="28.96" eve="32.11" morn="39.06"></temperature>
                    <pressure unit="hPa" value="1048.09"></pressure>
                    <humidity value="97" unit="%"></humidity>
                    <clouds value="clear sky" all="0" unit="%"></clouds>
            </time>
        </forecast>
        </weatherdata>';
    }

    const CURRENT_WEATHER_XML = <<<XML
<current>
    <city id="2950159" name="Berlin">
        <coord lon="13.41" lat="52.52"></coord>
        <country>DE</country>
        <sun rise="2017-01-02T07:16:51" set="2017-01-02T15:04:50"></sun>
    </city>
    <temperature value="36.48" min="35.6" max="37.4" unit="fahrenheit"></temperature>
    <humidity value="86" unit="%"></humidity>
    <pressure value="1014" unit="hPa"></pressure>
    <wind>
        <speed value="9.17" name="Fresh Breeze"></speed>
        <gusts></gusts>
        <direction value="300" code="WNW" name="West-northwest"></direction>
    </wind>
    <clouds value="75" name="broken clouds"></clouds>
    <visibility value="8000"></visibility>
    <precipitation mode="no"></precipitation>
    <weather number="500" value="light rain" icon="10d"></weather>
    <lastupdate value="2017-01-02T12:20:00"></lastupdate>
</current>
XML;
}
