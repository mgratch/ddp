<?php

return [
  'plugin_path' => plugin_dir_path(dirname(__FILE__)),
  'plugin_url' => plugins_url('', __FILE__),
  'asset_path' => plugin_dir_path(dirname(__FILE__)) . 'assets/',
  'asset_uri' => plugins_url('assets', __FILE__),
];
