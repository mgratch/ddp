<?php

namespace IODD\Instagram\Cache;

class Cache
{
  public $dir;

  public function save($content, $filename)
  {
    if (!is_dir($this->dir)) {
      mkdir($this->dir);
    }

    return file_put_contents($this->dir .'/'. $filename, $content);
  }

  public function get($filename)
  {
    return file_get_contents($this->dir .'/'. $filename);
  }
}
