<?php

namespace AdminerEvo\Tests;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PageHome extends TestPage {

	/**
	 * is table present
	 *
	 * @access public
	 * @param string $table_name
	 * @return bool
	 */
	public function is_table_present(string $table_name): bool {
		try {
			$this->webdriver->findElement(WebDriverBy::cssSelector('ul#tables li a[href*="table=' . $table_name . '"]'));
			return true;
		} catch (NoSuchElementException $nsee) {
			return false;
		}
	}
	/**
	 * select table structure
	 *
	 * @access public
	 * @param string $table_name
	 * @return PageTable
	 */
	public function select_table_structure(string $table_name): ?PageStructure {
		$this->webdriver->findElement(WebDriverBy::cssSelector('ul#tables li a[href*="table=' . $table_name . '"]'))->click();
		try {
			$this->webdriver->findElement(WebDriverBy::cssSelector('h3#indexes'));
			return new PageStructure($this->webdriver);
		} catch (NoSuchElementException $nsee) {
			return null;
		}
	}

	/**
	 * select table data
	 *
	 * @access public
	 * @param string $table_name
	 * @return bool
	 */
	public function select_table_data(string $table_name): ?PageData {
		$this->webdriver->findElement(WebDriverBy::cssSelector('ul#tables li a[href*="select=' . $table_name . '"]'))->click();
		try {
			$this->webdriver->findElement(WebDriverBy::cssSelector('span.time'));
			return new PageData($this->webdriver);
		} catch (NoSuchElementException $nsee) {
			return null;
		}
	}

	public function create_table(string $table_name, array $columns): PageStructure {
		$this->webdriver->findElement(WebDriverBy::linkText('Create table'))->click();
		$this->webdriver->findElement(WebDriverBy::cssSelector('input[name="name"]'))->sendKeys($table_name);
		foreach ($columns as $column) {
			// Find the last row in the table
			$trs = $this->webdriver->findElements(WebDriverBy::cssSelector('table#edit-fields tbody tr'));
			$tr = end($trs);

			// Set column name
			$tr->findElement(WebDriverBy::cssSelector('input[name$="[field]"]'))->sendKeys($column['name']);

			// Set column type
			$typeSelect = $tr->findElement(WebDriverBy::cssSelector('select[name$="[type]"]'));
			$typeSelect->findElement(WebDriverBy::xpath('//option[text()="' . $column['type'] . '"]'))->click();

			// Set column length
			$tr->findElement(WebDriverBy::cssSelector('input[name$="[length]"]'))->sendKeys($column['length']);

			// Set unsigned options if available
			if (!empty($column['options'])) {
				$unsignedSelect = $tr->findElement(WebDriverBy::cssSelector('select[name$="[unsigned]"]'));
				$unsignedSelect->findElement(WebDriverBy::xpath('//option[text()="' . $column['options'] . '"]'))->click();
			}

			// Check if the column is nullable
			if ($column['null']) {
				$tr->findElement(WebDriverBy::cssSelector('input[name$="[null]"]'))->click();
			}

			// Check if the column has auto-increment
			if ($column['ai']) {
				$tr->findElement(WebDriverBy::cssSelector('input[name$="auto_increment_col"]'))->click();
			}
		}

		$this->webdriver->findElement(WebDriverBy::cssSelector('input[type="submit"]'))->click();
		return new PageStructure($this->webdriver);
	}

	/**
	 * SQL command
	 *
	 * @access public
	 * @return PageSqlCommand
	 */
	public function sql_command(): PageSqlCommand {
		$this->webdriver->findElement(WebDriverBy::linkText('SQL command'))->click();
		return new PageSqlCommand($this->webdriver);
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
