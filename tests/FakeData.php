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
                "timezone": 32400,
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
                "id":1851633,
                "dt":1406106000,
                "timezone": 32400,
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
                "wind":{"speed":5.71,"deg":null},
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
        <timezone>3600</timezone>
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

    const AIR_POLLUTION_CO = <<<JSON
{"time":"2019-10-26T18:15:01Z","location":{"latitude":40.0013,"longitude":-74.5899},"data":[{"precision":-4.999999987376214e-07,"pressure":1000,"value":1.3621800576402165e-07},{"precision":-4.999999987376214e-07,"pressure":681.2920532226562,"value":1.1375255581924648e-07},{"precision":-4.999999987376214e-07,"pressure":464.15887451171875,"value":1.038646146866995e-07},{"precision":4.547785792397008e-08,"pressure":316.2277526855469,"value":1.7132454388502083e-07},{"precision":2.0379493648192692e-08,"pressure":215.44346618652344,"value":1.1696990753762293e-07},{"precision":1.3544046773006357e-08,"pressure":146.77992248535156,"value":6.227620730214767e-08},{"precision":1.1640130637147195e-08,"pressure":100,"value":4.9975231064536274e-08},{"precision":1.0211765655299132e-08,"pressure":68.12920379638672,"value":5.12039584066315e-08},{"precision":8.732828682411764e-09,"pressure":46.415889739990234,"value":3.545491722434235e-08},{"precision":9.014621049630023e-09,"pressure":31.62277603149414,"value":1.8382916522341475e-08},{"precision":9.907536124842409e-09,"pressure":21.544347763061523,"value":1.8576894467159377e-09},{"precision":1.2424509421293806e-08,"pressure":14.677992820739746,"value":-9.168636516676543e-09},{"precision":1.5284239651691678e-08,"pressure":10,"value":2.2812981725905956e-08},{"precision":2.1570169650431126e-08,"pressure":6.812920570373535,"value":5.2754966617385435e-08},{"precision":2.913583330155234e-08,"pressure":4.6415886878967285,"value":6.849927558505442e-08},{"precision":3.875063470104578e-08,"pressure":3.1622776985168457,"value":-1.6690947290953773e-08},{"precision":5.409619419083356e-08,"pressure":2.1544346809387207,"value":-2.6772934091923162e-08},{"precision":7.21046475860021e-08,"pressure":1.4677993059158325,"value":1.0366177605192206e-07},{"precision":9.633781417051068e-08,"pressure":1,"value":4.523308305692808e-08},{"precision":1.4515163115902396e-07,"pressure":0.6812920570373535,"value":7.092549481058086e-08},{"precision":2.062685240389328e-07,"pressure":0.46415889263153076,"value":6.615503878037998e-08},{"precision":2.907468115154188e-07,"pressure":0.3162277638912201,"value":-3.38239033226273e-07},{"precision":4.297635598504712e-07,"pressure":0.2154434621334076,"value":1.6955895034698187e-06},{"precision":6.078225851524621e-07,"pressure":0.14677992463111877,"value":2.2467602889264526e-07},{"precision":6.833994916632946e-07,"pressure":0.10000000149011612,"value":7.392927159344254e-07},{"precision":1.017242993839318e-06,"pressure":0.04641588777303696,"value":2.740956688285223e-06},{"precision":1.8878859009419102e-06,"pressure":0.02154434658586979,"value":2.360790404054569e-06},{"precision":3.784052296396112e-06,"pressure":0.009999999776482582,"value":8.210285159293562e-06},{"precision":6.664358807029203e-06,"pressure":0.004641588777303696,"value":1.6543688616366126e-05},{"precision":-1.0293148989148904e-05,"pressure":0.002154434798285365,"value":4.2166899220319465e-05},{"precision":-1.5317784345825203e-05,"pressure":0.0010000000474974513,"value":4.3754778744187206e-05},{"precision":-1.9999999494757503e-05,"pressure":0.00046415888937190175,"value":1.658740802668035e-05},{"precision":-1.9999999494757503e-05,"pressure":0.00021544346236623824,"value":1.658740802668035e-05},{"precision":-1.9999999494757503e-05,"pressure":9.999999747378752e-05,"value":1.658740802668035e-05},{"precision":-1.9999999494757503e-05,"pressure":4.641588748199865e-05,"value":1.658740802668035e-05},{"precision":-1.9999999494757503e-05,"pressure":2.1544346964219585e-05,"value":1.658740802668035e-05},{"precision":-1.9999999494757503e-05,"pressure":9.999999747378752e-06,"value":1.658740802668035e-05}]}
JSON;

    const CURRENT_WEATHER_XML_NO_WIND_DIRECTION = <<<XML
<current>
<city id="2950159" name="Berlin">
    <coord lon="13.41" lat="52.52"></coord>
    <country>DE</country>
    <timezone>3600</timezone>
    <sun rise="2017-01-02T07:16:51" set="2017-01-02T15:04:50"></sun>
</city>
<temperature value="36.48" min="35.6" max="37.4" unit="fahrenheit"></temperature>
<humidity value="86" unit="%"></humidity>
<pressure value="1014" unit="hPa"></pressure>
<wind>
    <speed value="9.17" name="Fresh Breeze"></speed>
    <gusts></gusts>
</wind>
<clouds value="75" name="broken clouds"></clouds>
<visibility value="8000"></visibility>
<precipitation mode="no"></precipitation>
<weather number="500" value="light rain" icon="10d"></weather>
<lastupdate value="2017-01-02T12:20:00"></lastupdate>
</current>
XML;
}
