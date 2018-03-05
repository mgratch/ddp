<?php
/**
 * Plugin Name: ioAdmin
 * Plugin URI: http://evolveinsideout.com
 * Description: Custom Admin
 * Version: 0.0.1
 * Author: InsideOut Designs & Development
 * Author URI: http://evolveinsideout.com
 * License: GPL2
 */

if ( !defined( 'IOA_PLUGIN_URL' ) )
  define( 'IOA_PLUGIN_URL', get_template_directory_uri() . '/includes/io-admin' );
if ( !defined( 'IOA_PLUGIN_DIR' ) )
  define( 'IOA_PLUGIN_DIR', dirname( __FILE__ ) );

$auto_load = array(
  'vendor/autoload.php',
  'class-html.php',
  'class-io-admin-base.php',
  'class-io-admin-helpers.php',
  'class-io-admin-pages.php'
);

if( !empty( $auto_load ) )
  foreach( $auto_load as $load )
    require_once IOA_PLUGIN_DIR . '/includes/' . $load;


class ioAdmin extends ioAdmin\ioAdminBase\ioAdminBase
{

  public function __construct()
  {
    parent::__construct();

    if( is_admin() ) {
      $this->adminHooks();
      add_action('init', [$this, 'globalAssets']);
    }
  }

  public function adminHooks()
  {
    register_activation_hook( __FILE__, array( $this, 'activationHook' ) );

    new ioAdmin\ioAdminPages\ioAdminPages;
  }

  public function adminInit()
  {
    $this->globalAssets();
  }

  public function globalAssets()
  {
    wp_enqueue_style( 'FontAwesome' );
    wp_enqueue_style( 'io-admin-global' );
  }
}

/* -- Init -- */
new ioAdmin();
do_action( 'io_admin_loaded' );