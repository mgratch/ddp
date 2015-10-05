<?php
if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'sidebar_1',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => 'sidebar_twitter',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
}

add_theme_support( 'post-thumbnails', array( 'page', 'post', 'explore', 'do-business', 'live-here', 'tribe_events', 'property-listing' ) );

add_theme_support( 'menus' );

function my_action_callback() {
	 global $wpdb;

}


/**
 * This function modifies the main WordPress query to include an array of post types instead of the default 'post' post type.
 *
 * @param mixed $query The original query
 * @return $query The amended query
 */
function ddp_search( $query ) {
    if ( $query->is_search )
		$query->set( 'post_type', array( 'post', 'tribe_events', 'property-listing' ) );
    return $query;
};
add_filter( 'pre_get_posts', 'ddp_search' );

function numeric_posts_nav() {

	if( is_singular() )
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="navigation"><ul>' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li class="prev">%s</li>' . "\n", get_previous_posts_link('&laquo; Newer') );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>…</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li class="next">%s</li>' . "\n", get_next_posts_link('Older &raquo;') );

	echo '</ul></div>' . "\n";

}


/*
 * Menu spliter
 *
 */
class ddp_nav_walker extends Walker_Nav_Menu {


	function walk( $elements, $max_depth) {

		$menu_elements = array();
		foreach ($elements as $element) {

			if( $element->menu_item_parent == 0 ){

				$chidren_items = array();
				foreach ($elements as $s_element) {
					if( $element->db_id == $s_element->menu_item_parent){
						$chidren_items[] = $s_element;
					}
				}

				if(count($chidren_items) > 0 ){
					$childItems[$element->db_id] = $chidren_items;
				}
				$menu_elements[] = $element;
			} else {
				//don't add
			}

		}

		$split = ceil(count($menu_elements)/2);
		$strHTML = '';
		//$rightHtml = '</ul><ul class="right-side-menu">';
		foreach($menu_elements as $key => $item){
		//	if($key % 2 == 0) {
			if($key == $split) {
				$strHTML .= '</ul><ul class="right-side-menu">';
			}
				$classes = join(' ', $item->classes);
				$strHTML .= "<li id='menu-{$item->db_id}' class='$classes'><a href='{$item->url}'>{$item->title}</a>";

				if (isset($childItems[$item->db_id])){
					$strHTML .= '<ul class="sub-menu">';
					foreach($childItems[$item->db_id] as $subitem){
						$classes = join(' ', $subitem->classes);
						$strHTML .= "<li id='menu-{$subitem->db_id}' class='$classes'><a href='{$subitem->url}'>{$subitem->title}</a></li>";
					}
			    	$strHTML .= '</ul>';

				}

				$strHTML .= '</li>';
		/*
			} else {
				$classes = join(' ', $item->classes);
				$rightHtml .= "<li id='menu-{$item->db_id}' class='$classes'><a href='{$item->url}'>{$item->title}</a>";

				if (isset($childItems[$item->db_id])){
					$rightHtml .= '<ul class="sub-menu">';
					foreach($childItems[$item->db_id] as $subitem){
						$classes = join(' ', $subitem->classes);
						$rightHtml .= "<li id='menu-{$subitem->db_id}' class='$classes'><a href='{$subitem->url}'>{$subitem->title}</a></li>";
					}
					$rightHtml .= '</ul>';

				}

				$rightHtml .= '</li>';
			}
			*/
		}

		return $strHTML;
	}
}




?>
