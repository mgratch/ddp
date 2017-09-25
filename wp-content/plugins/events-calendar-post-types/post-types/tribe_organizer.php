<?php

function tribe_organizer_init() {
	register_post_type( 'tribe_organizer', array(
		'labels'                => array(
			'name'               => __( 'Organizers', 'Organizers-calendar-post-types' ),
			'singular_name'      => __( 'Organizer', 'Organizers-calendar-post-types' ),
			'all_items'          => __( 'All Organizers', 'Organizers-calendar-post-types' ),
			'new_item'           => __( 'New Organizer', 'Organizers-calendar-post-types' ),
			'add_new'            => __( 'Add New', 'Organizers-calendar-post-types' ),
			'add_new_item'       => __( 'Add New Organizer', 'Organizers-calendar-post-types' ),
			'edit_item'          => __( 'Edit Organizer', 'Organizers-calendar-post-types' ),
			'view_item'          => __( 'View Organizer', 'Organizers-calendar-post-types' ),
			'search_items'       => __( 'Search Organizers', 'Organizers-calendar-post-types' ),
			'not_found'          => __( 'No Organizers found', 'Organizers-calendar-post-types' ),
			'not_found_in_trash' => __( 'No Organizers found in trash', 'Organizers-calendar-post-types' ),
			'parent_item_colon'  => __( 'Parent Organizer', 'Organizers-calendar-post-types' ),
			'menu_name'          => __( 'Organizers', 'Organizers-calendar-post-types' ),
		),
		'public'                => false,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => false,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'tribe_events_cat' ),
		'has_archive'           => false,
		'rewrite'               => false,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'tribe_organizer',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}

add_action( 'init', 'tribe_organizer_init' );

function tribe_organizer_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['tribe_organizer'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => sprintf( __( 'Organizer updated. <a target="_blank" href="%s">View Organizer</a>', 'Organizers-calendar-post-types' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'Organizers-calendar-post-types' ),
		3  => __( 'Custom field deleted.', 'Organizers-calendar-post-types' ),
		4  => __( 'Organizer updated.', 'Organizers-calendar-post-types' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Organizer restored to revision from %s', 'Organizers-calendar-post-types' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __( 'Organizer published. <a href="%s">View Organizer</a>', 'Organizers-calendar-post-types' ), esc_url( $permalink ) ),
		7  => __( 'Organizer saved.', 'Organizers-calendar-post-types' ),
		8  => sprintf( __( 'Organizer submitted. <a target="_blank" href="%s">Preview Organizer</a>', 'Organizers-calendar-post-types' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9  => sprintf( __( 'Organizer scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Organizer</a>', 'Organizers-calendar-post-types' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __( 'Organizer draft updated. <a target="_blank" href="%s">Preview Organizer</a>', 'Organizers-calendar-post-types' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}

add_filter( 'post_updated_messages', 'tribe_organizer_updated_messages' );
