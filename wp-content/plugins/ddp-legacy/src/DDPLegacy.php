<?php

namespace IODD\DDPLegacy;

use IODD\DDPLegacy\Plugin\Plugin as Plugin;
use IODD\DDPLegacy\Config\Config as Config;

class DDPLegacy
{
  protected $config;
  protected $plugin;

  public function __construct()
  {
    $this->config = Config::get();

    $this->plugin = new Plugin;

    $this->serviceProviders();
    $this->plugin->run();
  }

  public function serviceProviders()
  {
    foreach ($this->config['service_providers'] as $service) {
      $this->plugin->addserviceProvider($service);
    }
  }

  public function activate()
  {
    $this->plugin->activate();
  }

  public function deactivate()
  {
    $this->plugin->deactivate();
  }
}
