<?php
/**
 * Returns null if no post type is available.
 */
$current_post_type = get_current_admin_post_type();

/**
 * Returns current post object and post template. Returns as empty object with
 *   $post_obj->template = null if not available.
 *
 * Post template: $post_obj->template.
 */
$post_obj = get_current_admin_post_object();
$pages = new Super_Custom_Post_Meta( 'page' );


if ($post_obj->template == 'page-home.php') {
	
	
	
	for ($i=1; $i <= 3; $i++) {
		$pages->add_meta_box( array(
				'id' => 'home-well-'.$i,
				'title' => 'Home Wells #'.$i,
				'context' => 'normal',
				'fields' => array(
					'home_module_id_'.$i => array('type'=>'select','options'=>get_module_content(), 'label'=>'Featured Area Content','field_description'=>'Choose the module for this area.' ),
				)
		) );
	}

	
}

/*
 * Home Module Content
*/

$widget_colors = array('blue','teal','purple','orange');
$arrHomeWellTypes = array('map'=>'Interactive Map','multi'=>'Multiple Content Leads');


$home_module_content = new Super_Custom_Post_Type( 'home-module-content', 'Home Featured Content', 'Home Featured Content', array( 'supports' => array( 'title', 'page-attributes' ), 'has_archive' => false, 'exclude_from_search' => true, 'publicly_queryable' => true, 'show_in_menu' => true ) );

$home_module_content->set_icon( 'f1b2' );

$home_module_content->add_meta_box( array(
		'id' => 'module-title',
		'title'=>'Module Main Title',
		'context' => 'normal',
		'fields' => array(
			'home_module_type' => array( 'type' => 'select','options'=>$arrHomeWellTypes ,'style' => 'width: 40%', 'label' => 'Home Module Type' ),
			'home_module_subsets' => array('type' => 'repeat','fields' => array(
				'home_module_color' => array('type'=>'select', 'label'=>'Home Area Color', 'options'=>$widget_colors ),
				'home_module_thumb_image' => array('type'=>'media', 'label'=>'Featured Supporting Area Image', 'field_description' => 'Image Size: 536px x 586px' ),
				'home_module_main_title' => array('type'=>'text', 'label'=>'Main Title', 'style'=>'width:100%' ),
				'home_module_main_text' => array('type'=>'textarea', 'label'=>'Content', ),
				'home_module_link_text' => array('type'=>'text', 'label'=>'Link Text', 'style'=>'width:100%' ),
				'home_module_link_url' => array('type'=>'text', 'label'=>'Link URL', 'style'=>'width:100%' ),
				)
			)
		)
));
		
// for ($i=1; $i <= 4; $i++) {
// 	$pages->add_meta_box( array(
// 			'id' => 'home-well-'.$i,
// 			'title' => 'Home Featured Supporting Area #'.$i,
// 			'context' => 'normal',
// 			'fields' => array(
// 				'home_module_color' => array('type'=>'select', 'label'=>'Home Area Color', 'options'=>$widget_colors ),
// 				'home_module_thumb_image' => array('type'=>'media', 'label'=>'Featured Supporting Area Image', 'field_description' => 'Image Size: 536px x 586px' ),
// 				'home_module_main_title' => array('type'=>'text', 'label'=>'Main Title', 'style'=>'width:100%' ),
// 				'home_module_main_text' => array('type'=>'textarea', 'label'=>'Content', ),
// 				'home_module_link_text' => array('type'=>'text', 'label'=>'Link Text', 'style'=>'width:100%' ),
// 				'home_module_link_url' => array('type'=>'text', 'label'=>'Link URL', 'style'=>'width:100%' ),
// 			)
// 	) );
// }
		
		


function get_module_content(){
	$modules = get_posts(array(
			'post_type'=>'home-module-content',
			'posts_per_page'=> -1,
			'orderby'=>'title',
			'order' => 'ASC'
	));

	$module_array = array();

	if(!empty($modules)) {
		foreach ($modules as $module) {
			$module_array[$module->ID] = $module->post_title;
		}
	}

	return $module_array;
};




/* -- Slider -- */
$home_slider = new Super_Custom_Post_Type( 'home-slider', 'Slide', 'Home Slider', array( 'supports' => array( 'title', 'page-attributes' ), 'menu_position' => 5, 'has_archive' => false ) );

$home_slider->set_icon( 'F03E' );

$home_slider->add_meta_box( array(
		'id' => 'home-slider-options',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
				'home-slider-text' => array( 'type' => 'text', 'label' => 'Slide Text Under Main Title', 'style' => 'width: 100%' ),
				'home-slider-image' => array( 'type' => 'media', 'label' => 'Slider Image', 'field_description' => 'Optimal image size goes here.', 'preview_size' => 'io-home-slider' ),
				'home-slider-cta-text' => array( 'type' => 'text', 'label' => 'Slide Text for Call to Action button', 'style' => 'width: 100%' ),
				'home-slider-cta-url' => array( 'type' => 'url', 'label' => 'Slide Call to Action Link Destination ', 'field_description'=>'Please include http://','style' => 'width: 100%' ),	
		)
) );