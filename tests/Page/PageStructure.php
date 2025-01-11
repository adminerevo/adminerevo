<?php

namespace AdminerEvo\Tests;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PageStructure extends TestPage {

	/**
	 * get columns
	 *
	 * @access public
	 * @return array
	 */
	public function get_columns(): array {
		$columns = [];
		$table_cells = $this->webdriver->findElements(WebDriverBy::cssSelector('div#content div.scrollable table.nowrap tbody tr th'));
		foreach ($table_cells as $table_cell) {
			$columns[] = $table_cell->getText();
		}
		return $columns;
	}

	/**
	 * alter table
	 *
	 * @access public
	 * @return PageAlter
	 */
	public function alter_table(): PageAlter {
		$this->webdriver->findElement(WebDriverBy::linkText('Alter table'))->click();
		return new PageAlter($this->webdriver);
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
