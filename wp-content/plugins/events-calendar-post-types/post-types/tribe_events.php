<?php

function tribe_events_init() {
	register_post_type( 'tribe_events', array(
		'labels'                => array(
			'name'               => __( 'Events', 'events-calendar-post-types' ),
			'singular_name'      => __( 'Event', 'events-calendar-post-types' ),
			'all_items'          => __( 'All Events', 'events-calendar-post-types' ),
			'new_item'           => __( 'New Event', 'events-calendar-post-types' ),
			'add_new'            => __( 'Add New', 'events-calendar-post-types' ),
			'add_new_item'       => __( 'Add New Event', 'events-calendar-post-types' ),
			'edit_item'          => __( 'Edit Event', 'events-calendar-post-types' ),
			'view_item'          => __( 'View Event', 'events-calendar-post-types' ),
			'search_items'       => __( 'Search Events', 'events-calendar-post-types' ),
			'not_found'          => __( 'No Events found', 'events-calendar-post-types' ),
			'not_found_in_trash' => __( 'No Events found in trash', 'events-calendar-post-types' ),
			'parent_item_colon'  => __( 'Parent Event', 'events-calendar-post-types' ),
			'menu_name'          => __( 'Events', 'events-calendar-post-types' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'taxonomies'            => array( 'tribe_events_cat' ),
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'           => true,
		'rewrite'               => array(
			'slug' => 'events'
		),
		'query_var'             => true,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'tribe_events',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}

add_action( 'init', 'tribe_events_init' );

function tribe_events_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['tribe_events'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => sprintf( __( 'Event updated. <a target="_blank" href="%s">View Event</a>', 'events-calendar-post-types' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'events-calendar-post-types' ),
		3  => __( 'Custom field deleted.', 'events-calendar-post-types' ),
		4  => __( 'Event updated.', 'events-calendar-post-types' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Event restored to revision from %s', 'events-calendar-post-types' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __( 'Event published. <a href="%s">View Event</a>', 'events-calendar-post-types' ), esc_url( $permalink ) ),
		7  => __( 'Event saved.', 'events-calendar-post-types' ),
		8  => sprintf( __( 'Event submitted. <a target="_blank" href="%s">Preview Event</a>', 'events-calendar-post-types' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9  => sprintf( __( 'Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Event</a>', 'events-calendar-post-types' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __( 'Event draft updated. <a target="_blank" href="%s">Preview Event</a>', 'events-calendar-post-types' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}

add_filter( 'post_updated_messages', 'tribe_events_updated_messages' );
