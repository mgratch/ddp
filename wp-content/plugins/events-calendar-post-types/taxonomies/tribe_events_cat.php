<?php

function tribe_events_cat_init() {
	register_taxonomy( 'tribe_events_cat', array( 'tribe_events' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'            => array(
			'name'                       => __( 'Event Categories', 'events-calendar-post-types' ),
			'singular_name'              => _x( 'Event Category', 'taxonomy general name', 'events-calendar-post-types' ),
			'search_items'               => __( 'Search Event Categories', 'events-calendar-post-types' ),
			'popular_items'              => __( 'Popular Event Categories', 'events-calendar-post-types' ),
			'all_items'                  => __( 'All Event Categories', 'events-calendar-post-types' ),
			'parent_item'                => __( 'Parent Event Category', 'events-calendar-post-types' ),
			'parent_item_colon'          => __( 'Parent Event Category:', 'events-calendar-post-types' ),
			'edit_item'                  => __( 'Edit Event Category', 'events-calendar-post-types' ),
			'update_item'                => __( 'Update Event Category', 'events-calendar-post-types' ),
			'add_new_item'               => __( 'New Event Category', 'events-calendar-post-types' ),
			'new_item_name'              => __( 'New Event Category', 'events-calendar-post-types' ),
			'separate_items_with_commas' => __( 'Separate Event Categories with commas', 'events-calendar-post-types' ),
			'add_or_remove_items'        => __( 'Add or remove Event Categories', 'events-calendar-post-types' ),
			'choose_from_most_used'      => __( 'Choose from the most used Event Categories', 'events-calendar-post-types' ),
			'not_found'                  => __( 'No Event Categories found.', 'events-calendar-post-types' ),
			'menu_name'                  => __( 'Event Categories', 'events-calendar-post-types' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'tribe_events_cat',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', 'tribe_events_cat_init' );
