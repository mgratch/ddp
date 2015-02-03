<?php

namespace ddp\live;

/*
Plugin Name: DDP Live Here Mapping
Plugin URI: http://evolveinsideout.com
Description: DDP Live Here Mapping
Author: InsideOut Design & Development
Version: 0.1
Author URI: http://evolveinsideout.com
*/

$config = array(
  'tables' => 'createTables'
);

require_once __DIR__ . '/framework/core/autoload.php';

global $wpdb;
$upload_dir = wp_upload_dir();

// Globals stand alone for global access
Config::add(array(
  'global' => array(
    'asset_uri' => plugins_url('', __FILE__ ) . '/framework/assets/',
    'asset_path' => dirname( __FILE__ ) . '/framework/assets/',
    'cache_path' => $upload_dir['basedir'] . '/' . basename(dirname( __FILE__ ))
  ),
  'database' => array(
    'prefix' => $wpdb->prefix
  )
));

Config::add(array(
  'api_keys' => array(
    'google_maps' => 'AIzaSyBqliL3bXMUi1hgjx5m0s4rIbfiDppOjCY'
  ),
  'scripts' => array(
    'ddpProperties.js' => array(
      'src' => Config::get('global.asset_uri').'/js/ddpProperties.js',
      'deps' => array(
        'jquery'
      ),
      'ver' => null,
      'footer' => true,
      'ajax' => true
    )
  ),
  'styles' => array(
    'ddpProperties.css' => array(
      'src' => Config::get('global.asset_uri').'/css/style.css',
      'deps' => null,
      'ver' => null,
      'media' => null
    )
  )
));

new SL_Framework();