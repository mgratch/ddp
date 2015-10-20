<?php

namespace IODD\Instagram;

use IODD\Instagram\PluginFramework\Plugin as PluginFramework;

class Plugin
{
  protected $plugin;

  public function __construct()
  {
    $this->plugin = new PluginFramework;
    $this->plugin->config = include_once __DIR__ . '/../Config.php';
    $this->addServiceProviders();
  }

  public function addServiceProviders()
  {
    if (empty($this->plugin->config['service_providers'])) return;

    foreach ($this->plugin->config['service_providers'] as $service) {
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

  public function getApp()
  {
    return $this->plugin;
  }
}
