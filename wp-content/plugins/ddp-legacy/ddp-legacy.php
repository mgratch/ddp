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

$config = include_once __DIR__ . '/config.php';

class User
{

}

class Test
{
  public function __construct(User $user)
  {
    $this->user = $user;
  }
}

$ref = new \ReflectionClass(Test::class);

var_dump($ref->getConstructor()->getParameters()[0]->getClass()); exit;

register_activation_hook(__FILE__, function() {

});

register_deactivation_hook(__FILE__, function() {

});
