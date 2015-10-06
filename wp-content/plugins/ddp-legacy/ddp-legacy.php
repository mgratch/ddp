<?php

namespace IODD\DDPLegacy;

/*
Plugin Name: DDP Legacy
Plugin URI:  http://evolveinsideout.com
Description: DDP Legacy Theme Functionality
Version:     0.0.1
Author:      InsideOut Design & Development
Author URI:  http://evolveinsideout.com
*/

require_once __DIR__ . '/vendor/autoload.php';

use IODD\DDPLegacy\Config\Config as Config;

$config = include_once __DIR__ . '/config.php';

Config::set($config);

$app = new DDPLegacy;

register_activation_hook(__FILE__, function() use ($app) {
  $app->activate();
});

register_deactivation_hook(__FILE__, function() use ($app) {
  $app->deactivate();
});
