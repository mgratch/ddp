<?php

return [
  'plugin_path' => plugin_dir_path(__FILE__),
  'plugin_url' => plugins_url('', __FILE__),
  'asset_path' => plugin_dir_path(__FILE__) . 'files/assets/',
  'asset_uri' => plugins_url('files/assets', __FILE__),
  'legacy_theme_path' => plugin_dir_path(__FILE__) . 'files/theme/',
  'legacy_theme_uri' => plugins_url('files/theme', __FILE__),

  // Plugin Service Providers
  'service_providers' => [
    IODD\DDPLegacy\Router\LegacyRouterServiceProvider::class,
  ]
];
