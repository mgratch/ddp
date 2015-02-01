<?php

namespace ddp\live;

class Instance
{

  protected static $instance = array();

  public static function get($name = false)
  {
      return $name && isset(self::$instance[$name]) ? self::$instance[$name] : self::$instance;
  }
  public static function add($parameters = array())
  {
      self::$instance = array_merge(self::$instance, $parameters);
  }
}