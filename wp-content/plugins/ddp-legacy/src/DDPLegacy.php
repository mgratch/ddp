<?php

namespace IODD\DDPLegacy;

class DDPLegacy {
  protected $config;

  protected $container = [];

  public function __construct($config) {
    $this->config = $config;
  }

  public function addService(ServiceInterface $service)
  {
    $this->container['services'] = new $service($config);
  }

  public function setActivator(ActivatorInterface $activator)
  {
    $this->container['activators'] = $activator;
  }

  public function setDeactivator(DeactivatorInterface $deactivator)
  {
    $this->container['deactivators'] = $activator;
  }

  public function activate()
  {
    foreach (@$this->container['activators'] as $activator) {
      $activator::activate();
    }
  }

  public function activate()
  {
    foreach (@$this->container['deactivators'] as $deactivator) {
      $activator::activate();
    }
  }
}
