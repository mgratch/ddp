<?php

namespace IODD\Instagram\Cache;

use IODD\Instagram\PluginFramework\ServiceProvider as ServiceProvider;
use IODD\Instagram\PluginFramework\PluginBootableInterface as PluginBootableInterface;

class CacheServiceProvider extends ServiceProvider
implements PluginBootableInterface
{
  public function boot()
  {
    $this->app()->add('Cache', function() {
      return new Cache;
    });
  }
}
