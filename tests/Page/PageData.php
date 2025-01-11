<?php

namespace AdminerEvo\Tests;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PageData extends TestPage {

	/**
	 * set search
	 *
	 * @access public
	 * @param string $column
	 * @param string $operator
	 * @param string $value
	 * @return bool
	 */
	public function set_search(string $column, string $operator, string $value): bool {
		$this->open_fieldset('search');

		$selects = $this->webdriver->findElements(WebDriverBy::cssSelector('div#fieldset-search select[name$="[col]"]'));
		$select = end($selects);
		$select->click();
		$select->findElement(WebDriverBy::cssSelector('option[value="' . $column . '"]'))->click();
		$select->click();

		$select = $select->findElement(WebDriverBy::xpath('../select[2]'));
		$select->click();
		$select->findElement(WebDriverBy::xpath('.//option[normalize-space(text()) = "' . $operator . '"]'))->click();
		$select->click();

		$input = $select->findElement(WebDriverBy::xpath('../input'));
		$input->sendKeys($value);

		return true;
	}

	/**
	 * reset search
	 *
	 * @access public
	 * @param int $index
	 * @return bool
	 */
	public function reset_search(int $index): bool {
		$buttons = $this->webdriver->findElements(WebDriverBy::cssSelector('div#fieldset-search input[type="image"]'));
		if ($index >= count($buttons)) {
			return false;
		}
		$buttons[$index]->click();
		return true;
	}

	/**
	 * do search
	 *
	 * @access public
	 * @return bool
	 */
	public function do_search(): bool {
		$this->webdriver->findElement(WebDriverBy::xpath('//fieldset[legend[normalize-space(text())="Action"]]//input[@type="submit"]'))->click();
		return true;
	}

	/**
	 * get total count
	 *
	 * @access public
	 * @return int
	 */
	public function get_total_count(): int {
		$count = $this->webdriver->findElement(WebDriverBy::xpath('//div[@class="footer"]/div/fieldset[2]/label'))->getText();
		$count = substr($count, 0, strpos($count, ' '));
		$count = str_replace([',', '.'], '', $count);
		return intval($count);
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
