<?php
/**
 * Plugin Name:     Beaver Themer Shrinking Header Logo
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     create logo-1, logo-2, different-logo classes for logos and containing column in your header
 * Author:          Marc Gratch
 * Author URI:      YOUR SITE HERE
 * Text Domain:     beaver-themer-shrinking-header-logo
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Beaver_Themer_Shrinking_Header_Logo
 */

add_action( 'wp_enqueue_scripts', 'probb_enqueue_scripts', 1005 );
function probb_enqueue_scripts()
{
	wp_enqueue_script( 'shrinking-logo', plugin_dir_url(__FILE__) . '/assets/js/shrinking-logo.js', array(), '1.6', true );
}

add_action('wp_enqueue_scripts', 'probb_enqueue_styles', 1005 );
function probb_enqueue_styles(){
	wp_enqueue_style( 'shrinking-logo', plugin_dir_url(__FILE__) . '/assets/css/shrinking-logo.css', array(), '1.6', 'all' );
}

function my_builder_register_settings_form( $form, $id ) {

	if ( 'menu' == $id ) {
		$form['general']['sections']['general']['fields']['menu_layout']['options']['mobile'] = 'Mobile';
		$form['general']['sections']['general']['fields']['menu_layout']['toggle']['mobile']['fields'] = ['submenu_click_toggle','collapse'];
	}

	return $form;
}

add_filter( 'fl_builder_register_settings_form', 'my_builder_register_settings_form', 10, 2 );