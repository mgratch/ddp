<?php

namespace IODD\DDPLegacy\Config;

class Config
{
  protected static $config = [];

  public static function set($config) {
    self::$config = $config;
  }

  public static function get($key = false)
  {
    if ($key) {
      return self::$config[$key];
    } else {
      return self::$config;
    }
  }
}
