<?php
/**
 * Plugin Name:     DDP Beaver Builder Modules
 * Plugin URI:      https://github.com/mgratch/bb-ddp-modules
 * Description:     Modules for DownTownDetroit.com
 * Author:          Marc Gratch
 * Author URI:      https://marcgratch.com
 * Text Domain:     bb-ddp-modules
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         BB_DDP_Modules
 */

define( 'BB_DDP_MODULES_DIR', plugin_dir_path( __FILE__ ) );
define( 'BB_DDP_MODULES_URL', plugins_url( '/', __FILE__ ) );

function load_bb_ddp_modules() {
	if ( class_exists( 'FLBuilder' ) ) {
		require_once 'ddp-submenu-module/ddp-submenu-module.php';
	}
}
add_action( 'init', 'load_bb_ddp_modules' );