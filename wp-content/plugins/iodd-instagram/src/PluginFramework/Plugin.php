<?php

namespace IODD\Instagram\PluginFramework;

class Plugin
{
  protected $services = [];
  protected $container = [];
  public $config = [];

  public function addServiceProvider($service)
  {
    $service = new $service;
    $service->app = $this;
    $service->boot();
    $this->services[] = $service;
  }

  public function run()
  {
    foreach ($this->services as $service) {
      if (@in_array(__NAMESPACE__.'\PluginRunInterface', class_implements($service))) {
        $service->run();
      }
    }
  }

  public function activate()
  {
    foreach ($this->services as $service) {
      if (@in_array(__NAMESPACE__.'\PluginActivationInterface', class_implements($service))) {
        $service->activate();
      }
    }
  }

  public function deactivate()
  {
    foreach ($this->services as $service) {
      if (@in_array(__NAMESPACE__.'\PluginDeactivationInterface', class_implements($service))) {
        $service->deactivate();
      }
    }
  }

  public function get($alias)
  {
    if (empty($this->container['share'][$alias])) {
      throw new \Exception("Instance does not exist.", 1);
    }

    return $this->container['share'][$alias];
  }

  public function add($alias, $function)
  {
    $this->container['service'][$alias] = $function;

    return $this->container;
  }

  public function share($alias, $function)
  {
    $this->container['share'][$alias] = $function;
  }

  public function make($alias)
  {
    return $this->container['service'][$alias]();
  }
}
