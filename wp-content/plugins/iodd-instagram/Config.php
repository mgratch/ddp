<?php

return [
  'plugin_path' => plugin_dir_path(__FILE__),
  'plugin_url' => plugins_url('', __FILE__),
  'asset_path' => plugin_dir_path(__FILE__) . 'files/assets/',
  'asset_uri' => plugins_url('files/assets', __FILE__),
  'config_path' => __DIR__,

  'service_providers' => [
    IODD\Instagram\Cache\CacheServiceProvider::class,
    IODD\Instagram\InstagramFeed\InstagramFeedServiceProvider::class
  ],

  'cache_dir' => wp_upload_dir()['basedir'].'/instagram-cache'

];
