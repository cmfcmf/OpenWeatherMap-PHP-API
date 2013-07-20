<?php

use cmfcmf\OpenWeatherMap\AbstractCache;

class examplecache extends AbstractCache
{
    public function isCached($query, $units, $lang, $mode)
    {
        echo "Checking cache for $query $units $lang $mode …<br />";
        return false;
    }

    public function getCached($query, $units, $lang, $mode)
    {
        echo "Get cache for $query $units $lang $mode …<br />";
        return false;
    }

    public function setCached($content, $query, $units, $lang, $mode)
    {
        echo "Set cache for $query $units $lang $mode … ({$this->seconds} seconds)<br />";
        return false;
    }
}
