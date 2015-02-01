<?php

namespace ddp\live;

class SL_Framework
{
  public function __construct()
  {
    $this->loader();
  }

  public function loader()
  {
    $directories = array(
      'models',
      'controllers',
    );

    include_once __DIR__.'/vendor/super-cpt/super-cpt.php';

    foreach ($directories as $dir) {
      foreach (glob(__DIR__.'/../'.$dir.'/*.php') as $filename) {
        include_once $filename;
        $class_name = preg_replace('/\.php/', '', basename($filename));
        $class_name = __NAMESPACE__.'\\'.$class_name;
        if ($dir == 'controllers') {
          $instance = new $class_name;

          $class_name = str_replace(__NAMESPACE__.'\\', '', $class_name);

          Instance::add(array(
            $class_name => $instance
          ));
        }
      }
    }
  }
}