<?php
/**
 * Copyright Alex Seriy 2016
 *
 * This work is contributed to ********* under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPv3 (or at your option any later version).
 * @package OpenWeatherMap-PHP-Api
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

namespace Cmfcmf\OpenWeatherMap\IntegTests;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \OpenWeatherMap
     */
    protected $owm;

    protected function setUp()
    {

        // Load the app configuration
        $ini = parse_ini_file( __DIR__ . '/../Examples.ini');
        $apiKey = $ini['api_key'];

        $this->owm = new OpenWeatherMap();
    }

 	public function testUnauthorizedAccess()
    {
		try {
 			$weather = $this->owm->getWeather('Paris');
		} catch (OWMException $e) {
			$this->assertEquals(401, $e->getCode());
			$this->assertRegExp('/^Invalid API key/', $e->getMessage());
		}


	}

}

