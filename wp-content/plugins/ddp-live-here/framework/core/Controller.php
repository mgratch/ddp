<?php

namespace ddp\live;

class Controller
{

  protected $model = false;
  protected $config;

  public function __construct()
  {
    $this->loadModel();
    $this->config = Config::get();

    if (method_exists($this, 'actions')) {
      $this->actions();
    }

    if (method_exists($this, 'postType')) {
      $this->postType(new Type);
    }
  }

  protected function loadModel()
  {
    $model = preg_replace('/_Controller/', '_Model', get_class($this));

    if ($this->model) {
      $model = $this->model;
    }

    if (class_exists($model)) {
      $this->model = new $model;
    }
  }
}