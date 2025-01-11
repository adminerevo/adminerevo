<?php

namespace AdminerEvo\Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;

class TestScene extends TestCase {

	/**
	 * The webdriver variable
	 *
	 * @access public
	 * @var Facebook\WebDriver\Remote\RemoteWebDriver $webdriver
	 */
	private static $webdriver = null;

	/**
	 * Catch calls to the "webdriver" property and proxy them to our
	 * get_webdriver() method.
	 *
	 * @access public
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key): mixed {
		if ($key === 'webdriver') {
			return self::get_webdriver();
		}
	}

	/**
	 * Setup and return ready to use Webdriver
	 *
	 * @access private
	 * @return \Facebook\WebDriver\Remote\RemoteWebDriver
	 */
	private static function get_webdriver(): \Facebook\WebDriver\Remote\RemoteWebDriver {
		if (self::$webdriver !== null) {
			return self::$webdriver;
		}

		$config = Config::get();
		$host = $config->selenium->host;
		$browser = $config->selenium->browser;

		$options = new ChromeOptions();
		$options->addArguments(['--disable-gpu']);
		if (method_exists(DesiredCapabilities::class, $browser)) {
			$capabilities = call_user_func([DesiredCapabilities::class, $browser]);
		} else {
			throw new Exception("The method $browser does not exist in DesiredCapabilities.");
		}
		$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
		self::$webdriver = RemoteWebDriver::create($host, $capabilities);
		return self::$webdriver;
	}
}