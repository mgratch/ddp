<?php

namespace IODD\DDPLegacy\Plugin;

class Plugin
{
  protected $services = [];

  public function addServiceProvider($service)
  {
    $this->services[] = new $service;
  }

  public function run()
  {
    foreach ($this->services as $service) {
      if (@in_array(__NAMESPACE__.'\PluginBootableInterface', class_implements($service))) {
        $service->boot();
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
}
