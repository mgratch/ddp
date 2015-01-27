<?php
/*
Plugin Name: DDP Live Here Mapping
Plugin URI: http://evolveinsideout.com
Description: DDP Live Here Mapping
Author: InsideOut Design & Development
Version: 0.1
Author URI: http://evolveinsideout.com
*/

$config = array(
  'tables' => 'createTables'
);

require_once __DIR__ . '/framework/core/Autoloader.php';

new sixlabs\sl_framework\SL_Framework();

$db = new sixlabs\sl_framework\Database;

$db->create('sql');