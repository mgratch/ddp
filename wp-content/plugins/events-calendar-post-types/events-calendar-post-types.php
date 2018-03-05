<?php
/**
 * Plugin Name:     Events Calendar Post Types
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     events-calendar-post-types
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Events_Calendar_Post_Types
 */

function events_calendar_post_types_tax(){
	include(plugin_dir_path(__FILE__) . '/post-types/tribe_events.php');
	include(plugin_dir_path(__FILE__) . '/post-types/tribe_organizer.php');
	include(plugin_dir_path(__FILE__) . '/post-types/tribe_venue.php');
	include(plugin_dir_path(__FILE__) . '/taxonomies/tribe_events_cat.php');
}
add_action('plugins_loaded', 'events_calendar_post_types_tax',1000);