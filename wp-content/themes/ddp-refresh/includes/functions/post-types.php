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

$theme_colors = array(
	'color-1' => 'dark blue',
	'color-2' => 'light blue',
	'color-3' => 'teal',
	'color-4' => 'lemon',
	'color-5' => 'orange'
);



if ($pages->type == 'page') {

	$pages->add_meta_box( array(
		'id' => 'page-colors',
		'title' => 'Page Theme Color',
		'context' => 'side',
		'fields' => array(
			'page_color' => array('type'=>'select', 'label'=>'', 'options'=>$theme_colors, 'field_description'=>'If left empty, page will get its top parent\'s page color.' ),
		)
	) );
}

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
$arrHomeWellTypes = array('map'=>'Interactive Map','multi'=>'Multi-Well Area');


$home_module_content = new Super_Custom_Post_Type( 'home-module-content', 'Home Featured Content', 'Home Featured Content', array( 'supports' => array( 'title', 'page-attributes' ), 'has_archive' => false, 'exclude_from_search' => true, 'publicly_queryable' => true, 'show_in_menu' => true ) );

$home_module_content->set_icon( 'f1b2' );

$home_module_content->add_meta_box( array(
		'id' => 'module-title',
		'title'=>'Module Main Title',
		'box_description'=>'NOTE: Only the top 4 subsets will display on the site.',
		'context' => 'normal',
		'fields' => array(
			'home_module_type' => array( 'type' => 'select','options'=>$arrHomeWellTypes ,'style' => 'width: 40%', 'label' => 'Home Module Type' ),
			'home_module_subsets' => array('type' => 'repeat', 'fields' => array(
				'home_module_color' => array('type'=>'select', 'label'=>'Home Area Color', 'options'=>$theme_colors ),
				'home_module_thumb_image' => array('type'=>'media', 'label'=>'Featured Supporting Area Image', 'field_description' => 'Image Size: 600px x 640px. Image must be at an aspect ratio of 15 : 16 if you do not have an image at the specified dimensions.' ),
				'home_module_main_title' => array('type'=>'text', 'label'=>'Main Title', 'style'=>'width:100%' ),
				'home_module_main_text' => array('type'=>'textarea', 'label'=>'Content', ),
				'home_module_link_text' => array('type'=>'text', 'label'=>'Link Text', 'style'=>'width:100%' ),
				'home_module_link_url' => array('type'=>'text', 'label'=>'Link URL', 'style'=>'width:100%' ),
				)
			)
		)
));

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




/* -- Home Carousel -- */
$home_carousel = new Super_Custom_Post_Type( 'home_carousel', 'Home Slide', 'Home Carousel', array('supports' => array('title', 'page-attributes'), 'acts_like' => 'post', 'has_archive' => false, 'exclude_from_search' => true, 'menu_position' => '81.1') );

$home_carousel->set_icon('F144');

$home_carousel->add_meta_box( array(
  'id' => 'home-slide-content',
  'context' => 'normal',
  'fields' => array(
    'home_slide_image' => array('type' => 'media', 'label' => 'Slide Image', 'field_description' => 'Image size: 2500px x 1238px. Image must be at an aspect ratio of 628 : 311 if you do not have an image at the specified dimensions.'),
    'home_slide_title' => array('type'=>'text', 'label'=>'Slide Title', 'style'=>'width:100%;'),
    'home_slide_copy' => array('type'=>'textarea', 'label'=>''),
    'home_slide_cta_text' => array('type'=>'text', 'label'=>'Slide Button Text', 'style'=>'width:100%; max-width:350px;'),
    'home_slide_link' => array('type'=>'text', 'label'=>'Slide Link URL','field_description'=>'Full url including http://', 'style'=>'width:100%;' ),
  )
) );