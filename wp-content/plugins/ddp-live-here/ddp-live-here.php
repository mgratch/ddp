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
    'asset_uri' => plugins_url('', __FILE__ ) . '/framework/assets',
    'asset_path' => dirname( __FILE__ ) . '/framework/assets',
    'cache_path' => __DIR__.'/framework/cache'
  ),
  'database' => array(
    'prefix' => $wpdb->prefix
  )
));


// Project Config
Config::set('api_keys.gmaps', 'AIzaSyBqliL3bXMUi1hgjx5m0s4rIbfiDppOjCY');

Config::add(array(
  'scripts' => array(
    'ddpLiveInteractive.js' => array(
      'src' => Config::get('global.asset_uri').'/js/ddpProperties.js',
      'deps' => array(
        'jquery'
      ),
      'ver' => null,
      'footer' => true,
      'ajax' => true,
      'ajax_obj_name' => 'ddpPropertiesObj'
    ),
    'ddpLiveGoogleMapsAPI' => array(
      'src' => 'https://maps.googleapis.com/maps/api/js?key='.Config::get('api_keys.gmaps'),
      'footer' => true
    ),
    'ddpLiveGoogleMapsAPIAdmin' => array(
      'src' => 'https://maps.googleapis.com/maps/api/js?key='.Config::get('api_keys.gmaps'),
      'footer' => true,
      'admin' => true
    ),
    'ddpPropertyAdmin' => array(
      'src' => Config::get('global.asset_uri').'/js/ddpPropertyAdmin.js',
      'footer' => true,
      'deps' => array(
        'jquery',
        'ddpLiveGoogleMapsAPIAdmin'
      ),
      'admin' => true
    )
  ),
  'styles' => array(
    'ddpLiveInteractive.css' => array(
      'src' => Config::get('global.asset_uri').'/css/style.css',
      'deps' => null,
      'ver' => null,
      'media' => null
    )
  )
));

new SL_Framework();