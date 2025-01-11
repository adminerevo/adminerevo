<?php

namespace AdminerEvo\Tests;

use PHPUnit\Framework\TestCase;

class SqlCommandTest extends TestScene {

	public function test1() {
		$page_login = new PageLogin($this->webdriver);
		$page_login->open();
		$page_home = $page_login->login();

		$page_sql = $page_home->sql_command();
		$this->assertTrue($page_sql !== null, 'Failed getting SQL command page');

		$page_login->logout();
		//$page_login->close();
	}
}