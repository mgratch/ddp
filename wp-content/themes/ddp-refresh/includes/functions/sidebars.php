<?php
if (function_exists('register_sidebar')) {
	register_sidebar(array(
    'name'          => __('Standard Page Sidebar'),
	'id'            => 'standard-sidebar',
    'description'   => 'Additional sidebar widgets for standard pages.',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
}