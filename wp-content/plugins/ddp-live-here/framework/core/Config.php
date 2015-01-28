<?php

namespace ddp\live;

class Config
{

  protected static $config = array();

  public static function get($name = false)
  {
      return $name && isset(self::$config[$name]) ? self::$config[$name] : self::$config;
  }
  public static function add($parameters = array())
  {
      self::$config = array_merge(self::$config, $parameters);
  }
}