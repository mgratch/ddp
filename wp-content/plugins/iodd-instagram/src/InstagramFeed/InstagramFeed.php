<?php

namespace IODD\Instagram\InstagramFeed;

/**
 * Config Required
 *
 * See Config.php for required configuration.
 */


require_once 'curl.php';

class InstagramFeed implements InstagramFeedInterface
{
  protected $config;

  public function __construct($config)
  {
    $this->config = $config;
  }

  public function getTimeline()
  {
    $client = new Curl();

    $res = $client->get(
      'https://api.instagram.com/v1/users/'.$this->config['user_id'].'/media/recent/',
      [
        'client_id' => $this->config['client_id'],
        'client_secret' => $this->config['client_secret']
      ]
    );

    return $client->rawResponse;
  }
}
