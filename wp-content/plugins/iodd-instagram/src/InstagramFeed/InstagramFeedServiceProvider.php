<?php

namespace IODD\Instagram\InstagramFeed;

use IODD\Instagram\PluginFramework\ServiceProvider as ServiceProvider;
use IODD\Instagram\PluginFramework\PluginBootableInterface as PluginBootableInterface;
use IODD\Instagram\PluginFramework\PluginRunInterface as PluginRunInterface;

class InstagramFeedServiceProvider extends ServiceProvider
implements PluginBootableInterface
{
  public function boot()
  {
    if (empty($this->app()->config['iodd_instagram'])) {
      throw new \Exception("Instagram config is missing", 1);
    }

    $this->app()->share('InstagramFeed', new InstagramFeed($this->app()->config['iodd_instagram']));
  }
}
