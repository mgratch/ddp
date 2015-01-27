<?php

namespace sixlabs\sl_framework;

class Controller
{

  public function __construct()
  {
    if (method_exists($this, 'actions')) {
      $this->actions();
    }
  }
}