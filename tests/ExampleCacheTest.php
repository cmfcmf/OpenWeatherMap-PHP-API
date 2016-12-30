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

use Cmfcmf\OpenWeatherMap\AbstractCache;

require_once __DIR__ . '/bootstrap.php';

/**
 * Example cache implementation for doing unit testing.
 *
 * @ignore
 */
class ExampleCacheTest extends AbstractCache
{
    protected $seconds;
    protected $tmp;

    private function urlToPath($url)
    {
        $tmp = $this->tmp;
        $dir = $tmp . DIRECTORY_SEPARATOR . "OpenWeatherMapPHPAPI";
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $path = $dir . DIRECTORY_SEPARATOR . md5($url);

        return $path;
    }

    /**
     * @inheritdoc
     */
    public function isCached($url)
    {
        $path = $this->urlToPath($url);
        if (!file_exists($path) || filectime($path) + $this->seconds < time()) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getCached($url)
    {
        return file_get_contents($this->urlToPath($url));
    }

    /**
     * @inheritdoc
     */
    public function setCached($url, $content)
    {
        file_put_contents($this->urlToPath($url), $content);
    }

    /**
     * @inheritdoc
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;
    }

    /**
     * @inheritdoc
     */
     public function setTempPath($path)
     {
         if (!is_dir($path)) {
             mkdir($path);
         }
        
         $this->tmp = $path;
     }
}
