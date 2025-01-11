<?php

namespace AdminerEvo\Tests;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PageAlter extends TestPage {

	/**
	 * drop
	 *
	 * @access public
	 * @return PageHome
	 */
	public function drop(): PageHome {
		$this->webdriver->findElement(WebDriverBy::cssSelector('input[name="drop"]'))->click();
		$this->webdriver->switchTo()->alert()->accept();
		return new PageHome($this->webdriver);
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
