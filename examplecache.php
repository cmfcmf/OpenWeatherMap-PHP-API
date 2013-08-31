<?php

use cmfcmf\OpenWeatherMap\AbstractCache;

class examplecache extends AbstractCache
{
    public function isCached($type, $query, $units, $lang, $mode)
    {
        echo "Checking cache for $type $query $units $lang $mode …<br />";
        return false;
    }

    public function getCached($type, $query, $units, $lang, $mode)
    {
        echo "Get cache for $type $query $units $lang $mode …<br />";
        return false;
    }

    public function setCached($type, $content, $query, $units, $lang, $mode)
    {
        echo "Set cache for $type $query $units $lang $mode … ({$this->seconds} seconds)<br />";
        return false;
    }
}
