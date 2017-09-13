<?php

// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'classes/class-fl-child-theme.php';

// Actions
add_action( 'wp_enqueue_scripts', 'FLChildTheme::enqueue_scripts', 1000 );

function get_social_network_menu_items() {
	$items      = wp_get_nav_menu_items( 'social-networks' );
	$html_items = '<li class="social-networks"><ul class="social-sub-menu">';

	foreach ( $items as $item ) {
		$html_items .= "<li id='menu-item-" . $item->ID . "' class='menu-item menu-item-type-custom menu-item-object-custom" . implode( ' ', $item->classes ) . "'><a href='" . $item->url . "' rel='" . $item->xfn . "' target='" . $item->target . "'>" . $item->title . "</a></li>";
	}
	$html_items .= '</ul></li>';

	return $html_items;
}

function insert_social_network_menu_items( $items, $args ) {
	return $items . get_social_network_menu_items();
}

//add_filter('wp_nav_menu_main_items','insert_social_network_menu_items', 10, 2);

function year_shortcode() {
	$year = date( 'Y' );

	return $year;
}

add_shortcode( 'year', 'year_shortcode' );

add_filter( 'gform_submit_button_4', 'input_to_button', 10, 2 );
function input_to_button( $button, $form ) {
	$dom = new DOMDocument();
	$dom->loadHTML( $button );
	$input = $dom->getElementsByTagName( 'input' )->item( 0 );
	$input->setAttribute( 'value', '' );

	return $dom->saveHtml( $input );
}

class IODDPSubWalker extends Walker_Nav_Menu
{

	function walk( $elements, $max_depth) {
		global $post,$topParentTitle;


		$parent_page_id = get_top_parent_id($post);

		//crappy solution for Events side menu
		$strEventParentTitle = 'Events';
		$strEventParentMenuTitle = 'Upcoming Events';


		$menu_elements = array();
		foreach ($elements as $element) {

			if( $element->menu_item_parent == 0 ){

				$children_items = array();
				foreach ($elements as $s_element) {
					if( $element->db_id == $s_element->menu_item_parent){
						$children_items[] = $s_element;
					}
				}

				if(count($children_items) > 0 ){
					$childItems[$element->db_id] = $children_items;
				}
				$menu_elements[] = $element;
			} else {
				$children_items = array();
				foreach ($elements as $s_element) {
					if( $element->db_id == $s_element->menu_item_parent){
						$children_items[] = $s_element;
					}
				}

				if(count($children_items) > 0 ){
					$childItems[$element->menu_item_parent]['sub'][$element->db_id] = $children_items;
				}
			}
		}

		$strHtml = '';

		foreach($menu_elements as  $item){
			//only show selected parent tree

			if($item->object_id == $parent_page_id || ($topParentTitle == $strEventParentTitle && $item->title == $strEventParentMenuTitle) ) {
				$classes = join(' ',io_menu_standards($item->classes,$item));

				if (isset($childItems[$item->db_id])) {

					$strSubHtml = '';
					foreach($childItems[$item->db_id] as $key=>$subitem){

						if($key !== 'sub'){
							$classes = join(' ',io_menu_standards($subitem->classes,$subitem));

							$strHtml .= '<li id="menu-'.$subitem->db_id.'" class="'.$classes.'"><a href="'.$subitem->url.'" class="menu__link">'.$subitem->title.'</a>';

							if (!empty($childItems[$item->db_id]['sub'][$subitem->db_id])) {

								$strHtml .= '<ul class="menu menu--sub-sub-menu">';
								foreach($childItems[$item->db_id]['sub'][$subitem->db_id] as $key2=>$subitem2){
									$classes = join(' ',io_menu_standards($subitem2->classes,$subitem2));

									$strHtml .= '<li id="menu-'.$subitem2->db_id.'" class="'.$classes.'"><a href="'.$subitem2->url.'" class="menu__link">'.$subitem2->title.'</a></li>';
								}
								$strHtml .= '</ul>';
							}
						}
						$strHtml .= '</li>';
					}
				}
			}
		}

		return $strHtml;
	}
}

function kick_off_walker() {
	class IODDPWalker extends Walker_Nav_Menu {

		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$args   = (object) $args;

			$class_names = '';
			$value       = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$submenu = $args->has_children ? ' fl-has-submenu' : '';

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = ' class="' . esc_attr( $class_names ) . $submenu . '"';


			if ( isset( $item->group_start ) && true === $item->group_start ) {
				$output .= "<ul class='menu--sub-menu table__item'>";
			} else {
				$output .= '';
			}

			$output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

			$atts = array();

			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';

			$atts            = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = ! empty( $atts['classes'] ) ? ' class="' . esc_attr( join( '', array_filter( $atts['classes'] ) ) ) . '"' : '';
			$attributes .= ! empty( $item->attr_title ) ? ' title="' . esc_attr( $atts['title'] ) . '"' : '';
			$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $atts['target'] ) . '"' : '';
			$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $atts['rel'] ) . '"' : '';
			$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $atts['href'] ) . '"' : '';

			$item_output = $args->has_children ? '<div class="fl-has-submenu-container">' : '';
			$item_output .= $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';

			if ( $args->has_children ) {
				$item_output .= '<span class="fl-menu-toggle"></span>';
			}

			$item_output .= $args->after;
			$item_output .= $args->has_children ? '</div>' : '';

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		}

		function end_el( &$output, $item, $depth = 0, $args = array() ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$output .= "</li>{$n}";

			if ( isset( $item->group_end ) && true === $item->group_end ) {
				$output .= "</ul>";
			} else {
				$output .= '';
			}

		}

		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			parent::start_lvl( $output, $depth, $args );
			if (0 === $depth){
				if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
					$t = '';
					$n = '';
				} else {
					$t = "\t";
					$n = "\n";
				}
				$indent = str_repeat( $t, $depth );
				$output .= "{$n}{$indent}<div class='table table--2-items'>{$n}";
			}
		}

		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			if (0 === $depth) {
				if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
					$t = '';
					$n = '';
				} else {
					$t = "\t";
					$n = "\n";
				}
				$indent = str_repeat( $t, $depth );
				$output .= "$indent</div>{$n}";
			}
			parent::end_lvl( $output, $depth, $args );
		}

		function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			}

			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}
	}
}

add_action( 'fl_before_header', 'kick_off_walker', 11 );

function change_fl_nav_walker( $args ) {
	$args['walker'] = new IODDPWalker();

	return $args;
}

add_filter( 'wp_nav_menu_args', 'change_fl_nav_walker' );

// Map menu item class names
add_filter( 'nav_menu_css_class', 'io_menu_standards', 10, 2 );

function io_menu_standards( $classes, $item ) {
	$origClasses = $classes;

	$classes = [
		'menu__item'
	];

	if ( ! empty( $origClasses[0] ) ) {
		$classes = array_merge( $classes, $origClasses );
	}

	if ( $item->current ) {
		$classes[] = 'menu__item--current';
	}

	if ( $item->current_item_ancestor ) {
		$classes[] = 'menu__item--current-item-ancestor';
	}

	if ( $item->current_item_parent ) {
		$classes[] = 'menu__item--current-item-parent';
	}

	if ( in_array( 'menu-item-has-children', $origClasses ) ) {
		$classes[] = 'menu__item--has-children';
	}

	return $classes;
}

add_filter( 'nav_menu_link_attributes', 'io_menu_link_classes', 10, 3 );

function io_menu_link_classes( $atts, $item, $args ) {
	$atts['classes'][] = 'menu__link';

	return $atts;
}

add_filter( 'nav_menu_submenu_css_class', 'change_submenu_classes', 10, 3 );

function change_submenu_classes( $classes, $args, $depth ) {
	if (0 === $depth){
		$classes[] = 'menu__flyout';
	} else {

		$classes_keys = array_flip($classes);
		if (isset($classes_keys['sub-menu'])){
			unset($classes[$classes_keys['sub-menu']]);
		}

		$classes[] = 'menu--sub-sub-menu';
	}
	return $classes;
}

function group_sub_menu_objects($elements, $args) {

	$el_keys = wp_list_pluck($elements, 'db_id');
	$el_keys = array_flip($el_keys);
	foreach ( $elements as $element ) {

		if ( $element->menu_item_parent == 0 ) {

			$children_items = array();
			foreach ( $elements as $s_element ) {
				if ( $element->db_id == $s_element->menu_item_parent ) {
					$children_items[] = $s_element;
				}
			}

			$count = count( $children_items );

			if ( $count > 0 ) {
				$col_count = (int) ceil(count( $children_items ) / 2);
				for ($i = 0; $i < $count; $i++){

					$elements[$el_keys[$children_items[$i]->db_id]]->group_start = 0 === $i || $i === $col_count ? true : false;
					$elements[$el_keys[$children_items[$i]->db_id]]->group_end = $i === $col_count - 1 || $i === $count - 1 ? true : false;

				}
			}
		} else {
			$children_items = array();
			foreach ( $elements as $s_element ) {
				if ( $element->db_id == $s_element->menu_item_parent ) {
					$children_items[] = $s_element;
				}
			}

			$count = count( $children_items );

			if ( $count > 0 ) {
				$elements[$el_keys[intval($element->menu_item_parent)]]->children = $children_items;
			}
			//$menu_elements[] = $element;

		}

	}
	return $elements;
}
add_filter( 'wp_nav_menu_objects',  'group_sub_menu_objects', 11, 2 );

function mod_settings_field($field, $name, $settings){
	return $field;
}

add_filter('fl_builder_render_settings_field','mod_settings_field', 10, 3);

function mod_settings_form($form){
	if ('Heading Settings' == $form['title']){
		$form['tabs']['advanced']['sections']['css_selectors']['fields']['class']['connections'] = array('string');
	}
	return $form;
}

add_filter('fl_builder_settings_form_config','mod_settings_form');

function ddp_get_page_color(){
	global $post;
	$topParentPostID = $post->ID;
	if (get_queried_object_id() === $post->ID || is_archive()){
		if($post->post_parent != 0){
			$topParentPostID = get_top_parent_id($post);
		}
		$color = get_post_meta($topParentPostID, 'page_color', true);
		$color = !empty($color) ? esc_attr($color) : 'color-2';
	} else {
		global $wp;
		$current_url = $wp->request;
		$topParentPost = get_page_by_path( $current_url );
		$topParentPostID = get_top_parent_id($topParentPost);
		$color = $topParentPostID ? get_post_meta($topParentPostID, 'page_color', true) : '';
		$color = !empty($color) ? esc_attr($color) : 'color-2';
	}
	return $color;
}
add_shortcode('ddp_page_color', 'ddp_get_page_color');


/**
 * Function: get_top_parent_id
 */

function get_top_parent_id($current_page) {

	if (!$current_page){
		return false;
	}

	$ancestors = get_ancestors( $current_page->ID, 'page' );
	$top_parent_id = $current_page->ID;

	if(!empty($ancestors)){
		//last entry in the array is the top parent
		$top_parent_id = $ancestors[(count($ancestors)-1)];
	}

	return $top_parent_id;
}


/**
 * Function: get_submenu
 */

function get_submenu($parent_page_id) {
	//calling walker function to show menu
	return wp_nav_menu(array('echo'=>false,'theme_location'=>'main', 'container'=>false, 'menu_class'=>'menu menu--side', 'container_class'=>false, 'menu_id'=>false, 'walker' => new IODDPSubWalker));
}

function manually_enqueue_jp_twitter_js($node){
	if ('widget' === $node->slug && isset($node->settings->widget) && 'Jetpack_Twitter_Timeline_Widget' === $node->settings->widget ){
		wp_enqueue_script( 'jetpack-twitter-timeline' );
	}
}

add_action( 'fl_builder_after_render_module', 'manually_enqueue_jp_twitter_js', 10 );

function add_layout_to_body_class($classes){

	$layout_ids = array();

	if (is_archive()){
		$layout_ids = array_merge(FLThemeBuilderLayoutData::get_current_page_layout_ids('archive'), $layout_ids);
	}

	if (is_singular()){
		$layout_ids = array_merge(FLThemeBuilderLayoutData::get_current_page_layout_ids('singular'), $layout_ids);
	}
	foreach ($layout_ids as $id){
		$classes[] = "fl-theme-builder-" . sanitize_title(get_the_title($id));
	}
	return $classes;
}
add_filter('body_class','add_layout_to_body_class');

function add_color_to_body_class($classes){

	global $post;
	$topParentPostID = $post->ID;
	if (get_queried_object_id() === $post->ID || is_archive()){
		if($post->post_parent != 0){
			$topParentPostID = get_top_parent_id($post);
		}
		$color = get_post_meta($topParentPostID, 'page_color', true);
		$color = !empty($color) ? esc_attr($color) : 'color-2';
	} else {
		global $wp;
		$current_url = $wp->request;
		$topParentPost = get_page_by_path( $current_url );
		$topParentPostID = get_top_parent_id($topParentPost);
		$color = $topParentPostID ? get_post_meta($topParentPostID, 'page_color', true) : '';
		$color = !empty($color) ? esc_attr($color) : 'color-2';
	}

	$classes[] = 'ddp--page-'.$color;

	return $classes;
}
add_filter('body_class','add_color_to_body_class');