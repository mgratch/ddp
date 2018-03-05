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

require_once __DIR__ . '/vendor/autoload.php';
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
      'src' => 'https://maps.googleapis.com/maps/api/js?key='.$_ENV['GOOGLE_MAPS_API_KEY'],
      'footer' => true
    ),
    'ddpLiveGoogleMapsAPIAdmin' => array(
      'src' => 'https://maps.googleapis.com/maps/api/js?key='.$_ENV['GOOGLE_MAPS_API_KEY'],
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

$ddpLive = new SL_Framework();

$ddpLive->event('init', function() {
  add_image_size(
    'ddp-live-here-listing',
    '520',
    '340',
    true
  );
});

$ddpLive->run();
