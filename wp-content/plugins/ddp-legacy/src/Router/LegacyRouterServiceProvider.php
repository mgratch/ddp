<?php

namespace IODD\DDPLegacy\Router;

class LegacyRouterServiceProvider implements
\IODD\DDPLegacy\Plugin\PluginBootableInterface
{
  public function boot()
  {
    new LegacyRouter;
  }
}
