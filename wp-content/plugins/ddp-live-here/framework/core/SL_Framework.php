<?php

namespace sixlabs\sl_framework;

class SL_Framework
{

  protected $config;

  public function __construct($config = array())
  {
    $this->loader();
    $this->config = array('config');
  }

  public function loader()
  {
    $directories = array(
      'controllers',
      'models'
    );

    foreach ($directories as $dir) {
      foreach (glob(__DIR__.'/../'.$dir.'/*.php') as $filename) {
        include_once $filename;
        $class_name = preg_replace('/\.php/', '', basename($filename));
        new $class_name;
      }
    }
  }
}