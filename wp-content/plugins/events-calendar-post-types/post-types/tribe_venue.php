<?php

function tribe_venue_init() {
	register_post_type( 'tribe_venue', array(
		'labels'                => array(
			'name'               => __( 'Venues', 'Venues-calendar-post-types' ),
			'singular_name'      => __( 'Venue', 'Venues-calendar-post-types' ),
			'all_items'          => __( 'All Venues', 'Venues-calendar-post-types' ),
			'new_item'           => __( 'New Venue', 'Venues-calendar-post-types' ),
			'add_new'            => __( 'Add New', 'Venues-calendar-post-types' ),
			'add_new_item'       => __( 'Add New Venue', 'Venues-calendar-post-types' ),
			'edit_item'          => __( 'Edit Venue', 'Venues-calendar-post-types' ),
			'view_item'          => __( 'View Venue', 'Venues-calendar-post-types' ),
			'search_items'       => __( 'Search Venues', 'Venues-calendar-post-types' ),
			'not_found'          => __( 'No Venues found', 'Venues-calendar-post-types' ),
			'not_found_in_trash' => __( 'No Venues found in trash', 'Venues-calendar-post-types' ),
			'parent_item_colon'  => __( 'Parent Venue', 'Venues-calendar-post-types' ),
			'menu_name'          => __( 'Venues', 'Venues-calendar-post-types' ),
		),
		'public'                => false,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => false,
		'taxonomies'            => array( 'tribe_events_cat' ),
		'rewrite'               => false,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'tribe_venue',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}

add_action( 'init', 'tribe_venue_init' );

function tribe_venue_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['tribe_venue'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => sprintf( __( 'Venue updated. <a target="_blank" href="%s">View Venue</a>', 'Venues-calendar-post-types' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'Venues-calendar-post-types' ),
		3  => __( 'Custom field deleted.', 'Venues-calendar-post-types' ),
		4  => __( 'Venue updated.', 'Venues-calendar-post-types' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Venue restored to revision from %s', 'Venues-calendar-post-types' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __( 'Venue published. <a href="%s">View Venue</a>', 'Venues-calendar-post-types' ), esc_url( $permalink ) ),
		7  => __( 'Venue saved.', 'Venues-calendar-post-types' ),
		8  => sprintf( __( 'Venue submitted. <a target="_blank" href="%s">Preview Venue</a>', 'Venues-calendar-post-types' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9  => sprintf( __( 'Venue scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Venue</a>', 'Venues-calendar-post-types' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __( 'Venue draft updated. <a target="_blank" href="%s">Preview Venue</a>', 'Venues-calendar-post-types' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}

add_filter( 'post_updated_messages', 'tribe_venue_updated_messages' );
