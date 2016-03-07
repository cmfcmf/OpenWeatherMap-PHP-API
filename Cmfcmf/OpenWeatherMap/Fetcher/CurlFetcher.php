<?php
/**
 * OpenWeatherMap-PHP-API — A php api to parse weather data from http://www.OpenWeatherMap.org .
 *
 * @license MIT
 *
 * Please see the LICENSE file distributed with this source code for further
 * information regarding copyright and licensing.
 *
 * Please visit the following links to read about the usage policies and the license of
 * OpenWeatherMap before using this class:
 *
 * @see http://www.OpenWeatherMap.org
 * @see http://www.OpenWeatherMap.org/terms
 * @see http://openweathermap.org/appid
 */

namespace Cmfcmf\OpenWeatherMap\Fetcher;

/**
 * Class CurlFetcher.
 *
 * @internal
 */
class CurlFetcher implements FetcherInterface
{
    /**
     * @var array The Curl options to use.
     */
    private $curlOptions;

    /**
     * Create a new CurlFetcher instance.
     *
     * @param array $curlOptions The Curl options to use. See http://php.net/manual/de/function.curl-setopt.php
     * for a list of available options.
     */
    public function __construct($curlOptions = array())
    {
        $this->curlOptions = $curlOptions;
    }
    
    /**
     * {@inheritdoc}
     */
    public function fetch($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt_array($ch, $this->curlOptions);
        
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }
}
