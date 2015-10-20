<?php

namespace IODD\Instagram;

/*
Plugin Name: InsideOut Instagram
Plugin URI:  http://evolveinsideout.com
Description: InsideOut Instagram Feed
Version:     0.1-alpha
Author:      InsideOut Design & Development
Author URI:  http://evolveinsideout.com
*/

require_once __DIR__ . '/vendor/autoload.php';

class Instagram
{
  protected $app;
  protected static $instance;

  public static function load()
  {
    if (static::$instance === null) {
      static::$instance = new Self;
    }

    return static::$instance;
  }

  public function __construct()
  {
    $app = new Plugin;
    $this->app = $app->getApp();
    $this->app->run();

    $this->cache = $this->app->make('Cache');
    $this->cache->dir = $this->app->config['cache_dir'];

    register_activation_hook(__FILE__, function() use ($app) {
      do_action('iodd_instagram_update_feed');
      wp_schedule_event(
        time(),
        'hourly',
        'iodd_instagram_update_feed'
      );

      $app->activate();
    });

    register_deactivation_hook(__FILE__, function() use ($app) {
      wp_clear_scheduled_hook('iodd_instagram_update_feed');

      $app->deactivate();
    });

    $this->actions();
  }

  public function actions()
  {
    add_action('iodd_instagram_update_feed', [$this, 'updateFeed']);
  }

  public function updateFeed()
  {
    $content = $this->app->get('InstagramFeed')->getTimeline();
    $this->cache->save($content, 'instagram-feed.json');
  }

  public function getFeed()
  {
    return json_decode($this->cache->get('instagram-feed.json'));
  }

}

Instagram::load();
