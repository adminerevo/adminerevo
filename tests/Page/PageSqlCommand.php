<?php

namespace AdminerEvo\Tests;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PageSqlCommand extends TestPage {

	/**
	 * run query
	 *
	 * @access public
	 * @param string $query
	 * @return bool
	 */
	public function run_query(string $query): bool {
		try {
			$this->webdriver->findElement(WebDriverBy::cssSelector('pre.jush-sql'))->clear();
			$this->webdriver->findElement(WebDriverBy::cssSelector('pre.jush-sql'))->sendKeys($query);
		} catch (NoSuchElementException $nsee) {
			$this->webdriver->findElement(WebDriverBy::cssSelector('textarea[name="query"]'))->clear();
			$this->webdriver->findElement(WebDriverBy::cssSelector('textarea[name="query"]'))->sendKeys($query);
		}
		$this->webdriver->findElement(WebDriverBy::cssSelector('input[type="submit"]'))->click();
		try {
			$this->webdriver->findElement(WebDriverBy::cssSelector('p.error'));
			return false;
		} catch (NoSuchElementException $nsee) {
			return true;
		}
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