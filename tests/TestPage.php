<?php

namespace AdminerEvo\Tests;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy;

abstract class TestPage {

	/**
	 * Webdriver variable
	 *
	 * @access protected
	 * @var \Facebook\Webdriver\Webdriver $webdriver
	 */
	protected $webdriver = null;

	/**
	 * Construct
	 *
	 * @access public
	 * @param \Facebook\Webdriver\WebDriver
	 */
	public function __construct(\Facebook\Webdriver\Webdriver $webdriver) {
		$this->webdriver = $webdriver;
		$this->webdriver->manage()->window()->maximize();
	}

	/**
	 * Get url
	 *
	 * @access public
	 * @return string $url
	 */
	abstract public function get_url();

	/**
	 * Open the page
	 *
	 * @access public
	 */
	public function open() {
		$this->webdriver->get($this->get_url());
		$this->check_error();
	}

	/**
	 * Close the browser
	 *
	 * @access public
	 */
	public function close() {
		$this->webdriver->quit();
	}

	/**
	 * Check for error and throw exception
	 *
	 * @access public
	 */
	public function check_error() {
		if ($this->has_error($error)) {
			throw new \Exception('Error on page: ' . "\n" . $error);
		}
	}

	/**
	 * Has error
	 * Checks if the current page contains an error
	 *
	 * @access public
	 * @return bool
	 */
	public function has_error(&$error = '') {
return false;
		$script = "if (document.querySelector('.exc-message') !== null) { return document.querySelector('#plain-exception').innerText } else { return false; }";
		$return = $this->webdriver->executeScript($script, []);
		if ($return === false) {
			return false;
		} else {
			$error = $return;
			return true;
		}
	}

	/**
	 * open fieldset
	 *
	 * @access public
	 * @param string $identifier
	 * @return bool
	 */
	public function open_fieldset(string $identifier): bool {
		$identifier = 'fieldset-' . $identifier;
		try {
			$fieldset = $this->webdriver->findElement(WebDriverBy::cssSelector('fieldset div#' . $identifier));
			$class = $fieldset->getAttribute('class');
			if ($class === 'hidden') {
				$this->webdriver->findElement(WebDriverBy::cssSelector('a[href="#' . $identifier . '"]'))->click();
				$class = $fieldset->getAttribute('class');
				if ($class === 'hidden') {
					throw new \Exception('Fieldset did not open');
				}
				return true;
			}
		} catch (NoSuchElementException $nsee) {
			throw new \Exception('Fieldset not found');
		}
		return flase;
	}

	/**
	 * close fieldset
	 *
	 * @access public
	 * @param string $identifier
	 * @return bool
	 */
	public function close_fieldset(string $identifier): bool {
		$identifier = 'fieldset-' . $identifier;
		try {
			$fieldset = $this->webdriver->findElement(WebDriverBy::cssSelector('fieldset div#' . $identifier));
			$class = $fieldset->getAttribute('class');
			if ($class !== 'hidden') {
				$this->webdriver->findElement(WebDriverBy::cssSelector('a[href="#' . $identifier . '"]'))->click();
				$class = $fieldset->getAttribute('class');
				if ($class !== 'hidden') {
					throw new \Exception('Fieldset did not close');
				}
				return true;
			}
		} catch (NoSuchElementException $nsee) {
			throw new \Exception('Fieldset not found');
		}
		return false;
	}
}