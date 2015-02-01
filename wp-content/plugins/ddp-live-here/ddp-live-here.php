<?php
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

ddp\live\Config::add(array(
  'global' => array(
    'asset_uri' => plugins_url('', __FILE__ ),
    'asset_path' => dirname( __FILE__ ),
    'cache_path' => $upload_dir['basedir'] . '/' . basename(dirname( __FILE__ ))
  ),
  'api_keys' => array(
    'google_maps' => null,
    'trulia' => 'e65hmxpkumwctjw5s6n6sb5c'
  ),
  'database' => array(
    'prefix' => $wpdb->prefix
  ),
  'scripts' => array(
    'ddpMap.js' => array(
      'src' => null,
      'deps' => array(
        'jquery'
      ),
      'ver' => null,
      'footer' => true
    )
  ),
  'styles' => array(
    'ddpMap.css' => array(
      'src' => null,
      'deps' => null,
      'ver' => null,
      'media' => null
    )
  )
));

new ddp\live\SL_Framework();