<?php

namespace ioAdmin\ioAdminBase;

use Philo\Blade\Blade as Blade;

class ioAdminBase
{
  public $asset_uri;
  public $asset_path;
  public $wpdb;
  public $config = [];

  public function __construct()
  {
    global $wpdb;
    $this->wpdb = $wpdb;

    $upload_dir = wp_upload_dir();
    $make_cache_dir = true;

    $this->config['asset_uri'] = IOA_PLUGIN_URL . '/assets';
    $this->config['asset_url'] = IOA_PLUGIN_DIR . '/assets';
    $this->view_path = IOA_PLUGIN_DIR . '/views';
    $this->cache_path = $upload_dir['basedir'] . '/io-admin-cache';

    /* -- Options Keys -- */
    $this->config['options_keys']['io-options'] = 'io-options';

    if( !file_exists( $this->cache_path ) )
      $make_cache_dir = mkdir( $this->cache_path );

    if( ! $make_cache_dir )
      ioAdminBase::adminMessage( 'error', 'Failed to create cache path in the uploads directory, please check permissions and make sure uploads is writable.' );

    add_action( 'init', [$this, 'baseInit']);
  }

  public static function adminMessage( $type = '', $message = '' )
  {
    echo '<div id="message" class="'.esc_attr( $type ).'">'.wpautop( $message ).'</div>';
  }

  public function baseInit()
  {
    $this->baseAssets();
  }

  public function baseAssets() {
    wp_register_style( 'FontAwesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );
    wp_register_style( 'io-admin-global', $this->config['asset_uri'] . '/css/io-admin-global.css' );
  }

  function sanitize_str( $string )
  {
    $string = trim( $string );
    $string = preg_replace('/\s/', '-', $string);
    $string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);

    return strtolower( $string );
  }

  public function blade() {
    return new Blade( $this->view_path, $this->cache_path  );
  }

  public function create_unique_slug( $string, $id = null, $table = null, $slug_col = null, $id_col = 'id' )
  {
    $sanatize = function( $string ) {
      $slug = trim( $string );
      $slug = preg_replace( '/\s+/', '-', $slug );
      $slug = preg_replace( '/[^A-Za-z0-9\-]/', '-', $slug );
      $slug = preg_replace( '/-+/', '-', $slug );
      $slug = strtolower( $slug );

      return $slug;
    };

    $slug = $sanatize( $string );

    if( !empty( $id ) ) {
      $old_slug = $this->wpdb->get_var( "SELECT {$slug_col} FROM {$table} WHERE {$id_col} = '{$id}'" );

      if( $slug == $old_slug )
        return $old_slug;

    }

    $query = function( $slug_col, $table, $slug ) {
      return $this->wpdb->get_results( "SELECT {$slug_col} FROM {$table} WHERE {$slug_col} = '{$slug}'" );
    };

    $check = $query( $slug_col, $table, $slug );

    if( !empty( $check ) ) {
      $orig_slug = $slug;
      $count = 2;
      while( $query( $slug_col, $table, $slug ) ) {
        $slug = $orig_slug . '-' . $count;
        $count++;
      }
    }

    return $slug;
  }

  public function updateOption( $key, $value, $page_slug, $succes_number = 1, $error_number = 2 )
  {
    $save = update_option( $key, $value );

    $screen = get_current_screen();
    $parent = $screen->parent_file != $page_slug ? $screen->parent_file : 'admin.php';

    $url = admin_url() . $parent . '?page=' . $page_slug;

    if( $save )
      wp_redirect( $url . '&io-message='.$succes_number );

    if( ! $save )
      wp_redirect( $url . '&io-message='.$error_number );
  }
}