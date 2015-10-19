<?php

namespace IODD\Instagram\InstagramFeed;

/**
 * Config Required
 *
 * [
 *   'screen_name' => '',
 *   'consumer_key' => '',
 *   'consumer_secret' => '',
 *   'token' => '75092414-',
 *   'secret' => '',
 * ]
 */

class InstagramFeed implements InstagramFeedInterface
{
  protected $config;

  public function __construct()
  {

  }

  public function getTimeline()
  {
    
  }
}
