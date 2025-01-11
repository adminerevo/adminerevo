<?php

namespace AdminerEvo\Tests;

use PHPUnit\Framework\TestCase;

class SelectTest extends TestScene {

	public function test1() {
		$page_login = new PageLogin($this->webdriver);
		$page_login->open();
		$page_home = $page_login->login();

		if ($page_home->is_table_present('customer') === false) {
			$page_sql = $page_home->sql_command();
			$page_sql->run_query("DROP TABLE IF EXISTS `customer`;");
			$page_sql->run_query("CREATE TABLE `customer` ( `id` int NOT NULL AUTO_INCREMENT, `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL, `address` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL, `birthdate` date DEFAULT NULL, `phone` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL, `email` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL, `username` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL, `password` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL, `created` datetime NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `email` (`email`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
			$faker = \Faker\Factory::create();

			for ($i = 0; $i < 10; $i++) {
				$sql = "INSERT INTO customer ( name, address, birthdate, phone, email, username, password, created ) VALUES\n";
				for ($j = 0; $j < 10; $j++) {
					$sql .= sprintf("( '%s %s', '%s', '%s', '%s', '%s', '%s', '%s', NOW() )",
						str_replace("'", "\'", $faker->firstName),
						str_replace("'", "\'", $faker->lastName),
						str_replace("\n", "", str_replace("'", "\'", $faker->address)),
						$faker->date,
						$faker->phoneNumber,
						$faker->unique()->email(),
						$faker->userName,
						bin2hex(random_bytes(16))
					);
					if ($j === 9) {
						$sql .= ";";
					} else {
						$sql .= ",\n";
					}
				}
				if ($page_sql->run_query($sql) === false) {
					printf("%s\n\n", $sql);
				}
			}
		}

		$page_table = $page_home->select_table_structure('customer');
		$this->assertTrue($page_table !== null, 'Failed getting table structure');
		$columns = $page_table->get_columns();
		$expected_columns = [ 'id', 'name', 'address', 'birthdate', 'phone', 'email', 'username', 'password', 'created' ];
		$this->assertTrue($columns == $expected_columns, 'Table structure is not what is expected');

		$page_data = $page_home->select_table_data('customer');
		$this->assertTrue($page_data !== null, 'Failed getting table data');

		$this->assertTrue($page_data->open_fieldset('select'), 'Problem opening fieldset select');
		$this->assertTrue($page_data->open_fieldset('search'), 'Problem opening fieldset search');
		$this->assertTrue($page_data->open_fieldset('sort'), 'Problem opening fieldset sort');
		$this->assertTrue($page_data->open_fieldset('export'), 'Problem opening fieldset export');
		$this->assertTrue($page_data->close_fieldset('select'), 'Problem closing fieldset select');
		$this->assertTrue($page_data->close_fieldset('search'), 'Problem closing fieldset search');
		$this->assertTrue($page_data->close_fieldset('sort'), 'Problem closing fieldset sort');
		$this->assertTrue($page_data->close_fieldset('export'), 'Problem closing fieldset export');

		$page_data->set_search('id', '>', 10);
		$page_data->do_search();
		$this->assertTrue($page_data->get_total_count() === 90, 'Problem with id > 10');
		$page_data->reset_search(0);
		$page_data->do_search();
		$this->assertTrue($page_data->get_total_count() === 100, 'Problem with no search');

		$page_login->logout();
		//$page_login->close();
	}
}
