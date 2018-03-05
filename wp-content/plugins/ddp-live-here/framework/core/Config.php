<?php

namespace ddp\live;

class Config
{

  protected static $config = array();

  public static function add($parameters = array())
  {
    self::$config = array_merge(self::$config, $parameters);
  }

  public static function get($path = false, $default = null)
  {
    $current = self::$config;

    $p = strtok($path, '.');

    while ($p !== false) {
      if (!isset($current[$p])) {
        return $default;
      }

      $current = $current[$p];
      $p = strtok('.');
    }

    return $current;
  }

  public static function set($path, $value)
  {
    if (!empty($path)) {
        $at = & self::$config;
        $keys = preg_split('/[:\.]/', $path);

        while (count($keys) > 0) {
            if (count($keys) === 1) {
                if (is_array($at)) {
                    $at[array_shift($keys)] = $value;
                } else {
                    throw new \RuntimeException("Can not set value at this path ($path) because is not array.");
                }
            } else {
                $key = array_shift($keys);

                if (!isset($at[$key])) {
                    $at[$key] = array();
                }

                $at = & $at[$key];
            }
        }
    } else {
        self::$config = $value;
    }
  }

}