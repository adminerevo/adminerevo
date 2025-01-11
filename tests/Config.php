<?php

namespace AdminerEvo\Tests;

class Config {
	private static ?Config $me = null;
	private array $data;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct(array $data = null) {
		if ($data === null) {
			$this->data = json_decode(file_get_contents('config.json'), true);
		} else {
			$this->data = $data;
		}
	}

	/**
	 * __get
	 *
	 * @access public
	 * @param $name
	 * @return mixed
	 */
	public function __get($name) {
		// Wrap the next level dynamically
		return isset($this->data[$name]) ? $this->wrap($this->data[$name]) : null;
	}

	/**
	 * wrap
	 *
	 * @access private
	 * @param array $data
	 * @return scalar
	 */
	private function wrap($data) {
		if (is_array($data)) {
			return new self($data);
		}
		return $data; // Return scalar values as-is
	}


	/**
	 * get
	 *
	 * @access public
	 * @return Config;
	 */
	public static function get(): Config {
		if (self::$me === null) {
			self::$me = new self();
		}
		return self::$me;
	}
}