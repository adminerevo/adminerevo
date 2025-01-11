<?php

namespace AdminerEvo\Tests;

use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PageLogin extends TestPage {

	/**
	 * login
	 *
	 * @access public
	 */
	public function login() {
		$config = Config::get();

		$this->webdriver->findElement(WebDriverBy::cssSelector('select[name="auth[driver]"]'))->click();
		$this->webdriver->findElement(WebDriverBy::cssSelector('select[name="auth[driver]"] option[value="' . $config->adminerevo->system .'"]'))->click();

		$this->webdriver->findElement(WebDriverBy::cssSelector('input[name="auth[server]"]'))->sendKeys($config->adminerevo->server);
		$this->webdriver->findElement(WebDriverBy::cssSelector('input[name="auth[username]"]'))->sendKeys($config->adminerevo->username);
		$this->webdriver->findElement(WebDriverBy::cssSelector('input[name="auth[password]"]'))->sendKeys($config->adminerevo->password);
		$this->webdriver->findElement(WebDriverBy::cssSelector('input[name="auth[db]"]'))->sendKeys($config->adminerevo->database);

		$this->webdriver->findElement(WebDriverBy::cssSelector('input[type="submit"]'))->click();
		return new PageHome($this->webdriver);
	}

	/**
	 * logout
	 *
	 * @access public
	 */
	public function logout() {
		$this->webdriver->findElement(WebDriverBy::cssSelector('p.logout input[type="submit"]#logout'))->click();
	}

	/**
	 * get_url
	 *
	 * @access public
	 */
	public function get_url() {
		return Config::get()->adminerevo->host;
	}
}