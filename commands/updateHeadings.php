<?php
require_once __DIR__ . '/vendor/autoload.php';

define('WP_USE_THEMES', false);
/** Loads the WordPress Environment and Template */
require_once __DIR__ . '/../wp-load.php';

$cmd = new Commando\Command();

$cmd->option('post-type')
    ->require()
    ->describedAs('Post Type to Parse (slug)');

trait commandTrait
{
  public function log($message)
  {
    return fwrite(STDOUT, $message."\r\n");
  }
}

class ReplaceHeadings
{
  use commandTrait;

  protected $postType;
  protected $posts;

  public function __construct($postType)
  {
    $this->postType = $postType;
    $this->posts = $this->fetchPosts();
    $this->parsePosts();
    $this->log('Annnnnnd we\'re done!');
  }

  public function fetchPosts()
  {
    $this->log('Parsing "'.$this->postType.'" Post type');

    $posts = get_posts([
      'numberposts' => -1,
      'post_type' => $this->postType,
      'post_status' => 'any',
    ]);

    if (empty($posts)) {
      return $this->log('No posts found in "'.$this->postType.'"');
    }

    $this->log('Found '. count($posts) . ' posts');

    return $posts;
  }

  public function parsePosts()
  {
    $total = 0;

    foreach ($this->posts as $post) {
      $content = $post->post_content;

      // h1
      $content = preg_replace('/<h1>/', '[x-large]', $content);
      $content = preg_replace('/<\/h1>/', '[/x-large]', $content);

      // h2
      $content = preg_replace('/<h2>/', '[large]', $content);
      $content = preg_replace('/<\/h2>/', '[/large]', $content);

      // h3
      $content = preg_replace('/<h3>/', '[medium]', $content);
      $content = preg_replace('/<\/h3>/', '[/medium]', $content);

      // h4
      $content = preg_replace('/<h4>/', '[small]', $content);
      $content = preg_replace('/<\/h4>/', '[/small]', $content);

      // h5
      $content = preg_replace('/<h5>/', '[x-small]', $content);
      $content = preg_replace('/<\/h5>/', '[/x-small]', $content);

      // h6
      $content = preg_replace('/<h6>/', '[xx-small]', $content);
      $content = preg_replace('/<\/h6>/', '[/xx-small]', $content);

      $post->post_content = $content;

      $this->log('Updaging post '. $post->ID);
      $this->updatePost($post);

      $total++;
    }

    $this->log('Updated '. $total .' posts');
  }

  public function updatePost($post)
  {
    return wp_update_post($post);
  }
}

new ReplaceHeadings($cmd['post-type']);
