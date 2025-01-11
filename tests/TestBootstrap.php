<?php

require_once 'vendor/autoload.php';

require_once 'Config.php';
require_once 'TestPage.php';
require_once 'TestScene.php';

$pages = glob('Page/*.php');
foreach ($pages as $file) {
	require_once $file;
}
