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

  'cache_dir' => wp_upload_dir()['basedir'].'/instagram-cache',

  'iodd_instagram' => [
    'user_id' => '483209569',
    'client_id' => '29dbc5f67b2b4dc0b5ff25849cdb2051',
    'client_secret' => '04d49cf6b11a49ec9d4d0ad174c65748'
  ],

];
