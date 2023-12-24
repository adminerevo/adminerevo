<?php

/** Change position of the SQL textarea in SQL page
* @link https://www.adminerevo.org/plugins/#use
* @author Lionel Laffineur <lionel.laffineur@gmail.com>
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerSqlEditPosition {
	function __construct($position = 'above') {
		$GLOBALS['config']['sql_edit_position'] = $position;
	}
}
