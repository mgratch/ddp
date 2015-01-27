<?php

namespace sixlabs\sl_framework;

class Controller extends SL_Framework
{

  public function __construct()
  {
    if (method_exists($this, 'actions')) {
      $this->actions();
    }
  }
}