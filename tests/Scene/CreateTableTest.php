<?php

namespace AdminerEvo\Tests;

use PHPUnit\Framework\TestCase;

class CreateTableTest extends TestScene {

	public function test_1_drop_existing() {
		$page_login = new PageLogin($this->webdriver);
		$page_login->open();
		$page_home = $page_login->login();

		try {
			$page_structure = $page_home->select_table_structure('customer');
			$page_alter = $page_structure->alter_table();
			$page_home = $page_alter->drop();
		} catch (\Exception $e) {}

		$pageStructure = $page_home->create_table('customer', [
			[ 'name' => 'id', 'type' => 'int', 'length' => '', 'options' => 'unsigned', 'null' => 0, 'ai' => 1 ],
			[ 'name' => 'name', 'type' => 'varchar', 'length' => '256', 'options' => '', 'null' => 0, 'ai' => 0 ],
			[ 'name' => 'address', 'type' => 'varchar', 'length' => '512', 'options' => '', 'null' => 0, 'ai' => 0 ],
			[ 'name' => 'latitude', 'type' => 'float', 'length' => '', 'options' => '', 'null' => 1, 'ai' => 0 ],
			[ 'name' => 'longitude', 'type' => 'float', 'length' => '', 'options' => '', 'null' => 1, 'ai' => 0 ],
			[ 'name' => 'birthdate', 'type' => 'date', 'length' => '', 'options' => '', 'null' => 1, 'ai' => 0 ],
			[ 'name' => 'phone', 'type' => 'varchar', 'length' => '64', 'options' => '', 'null' => 0, 'ai' => 0 ],
			[ 'name' => 'email', 'type' => 'varchar', 'length' => '256', 'options' => '', 'null' => 0, 'ai' => 0 ],
			[ 'name' => 'username', 'type' => 'varchar', 'length' => '64', 'options' => '', 'null' => 1, 'ai' => 0 ],
			[ 'name' => 'password', 'type' => 'varchar', 'length' => '64', 'options' => '', 'null' => 1, 'ai' => 0 ],
			[ 'name' => 'created', 'type' => 'datetime', 'length' => '', 'options' => '', 'null' => 0, 'ai' => 0 ],
		]);

		$page_login->logout();
		//$page_login->close();
		$this->assertTrue(true, 'Problem');
	}
}