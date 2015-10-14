<?php


/* -- Includes -- */
// Slider
//require_once('functions-io-slider.php');



/**
 * Script & Style Registration
 */
function io_theme_scripts()
{
  /* -- Scripts -- */
  wp_register_script('ioddcommon', get_template_directory_uri().'/javascript/insideout_common.js', array( 'jquery', 'velocity' ), '', true );
  wp_register_script( 'bxslider', get_template_directory_uri().'/javascript/jquery.bxslider.min.js', array( 'jquery' ), '4.1.2', true );
  wp_register_script( 'velocity', get_template_directory_uri().'/javascript/velocity.min.js', '', '1.2.3', true );
  wp_register_script( 'velocity-ui', get_template_directory_uri().'/javascript/velocity.ui.min.js', array('velocity'), '5.0.4', true );

  /* -- Initial Localization -- */
  wp_localize_script( 'ioddcommon', 'io_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'init', 'io_theme_scripts' );

/**
 * Custom Image Sizes
 */
add_image_size( 'responsive-x-large', $width = 2500, $height = 9999, $crop = false );
add_image_size( 'responsive-large', $width = 1920, $height = 9999, $crop = false );
add_image_size( 'responsive-medium', $width = 960, $height = 9999, $crop = false );
add_image_size( 'responsive-small', $width = 480, $height = 9999, $crop = false );
add_image_size( 'responsive-x-small', $width = 320, $height = 9999, $crop = false );

IOResponsiveImage::setSizes([
  '320w'  => 'responsive-x-small',
  '480w'  => 'responsive-small',
  '960w'  => 'responsive-medium',
  '1920w' => 'responsive-large'
]);

// echo IOResponsiveImage::getImage(70, [
//   'class' => 'block__image',
//   'alt' => ''
// ]);

//Get contents of an SVG file for inline ouput
function renderSVG($path = false) {
  if ($path) {
    return file_get_contents($path);
  }
}

// Check url
function check_url($url){
	if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url)){
		$url = 'http://'.$url;
	}

	return $url;
}



// Set sub menu class name
class IODDPWalker extends IODefaultWalker
{
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
// 	function start_lvl( &$output, $depth = 0, $args = array() ) {
// 		$indent = str_repeat("\t", $depth);
// 		$output .= "\n$indent<ul class=\"menu menu--sub-menu menu--split-column\">\n";
// 	}



	function walk( $elements, $max_depth) {

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
				//don't add
			}

		}
		//$split = ceil(count($menu_elements)/2);
		$strHTML = '';

		foreach($menu_elements as  $item){

// 			if($key == $split) {
// 				$strHTML .= '</ul><ul class="right-side-menu">';
// 			}
// echo '<pre>';
// 			var_dump($item);
// 			echo '</pre>';
			$classes = join(' ',io_menu_standards($item->classes,$item));
			$strHTML .= '<li id="menu-'.$item->db_id.'" class="'.$classes.'"><a href="'.$item->url.'" class="menu__link">'.$item->title.'</a>';

			if (isset($childItems[$item->db_id])) {

				$strHTML .= '<div class="menu__flyout"><ul class="menu menu--sub-menu menu--split-column">'."\r\n";
				foreach($childItems[$item->db_id] as $key=>$subitem){
					$split = ceil(count($childItems[$item->db_id])/2);
					if($key == $split) {
						 $strHTML .= '</ul><ul class="menu menu--sub-menu menu--split-column">';
					}
					$classes = join(' ',io_menu_standards($subitem->classes,$subitem));
					$strHTML .= '<li id="menu-'.$subitem->db_id.'" class="'.$classes.'"><a href="'.$subitem->url.' class="menu__link">'.$subitem->title.'</a></li>';
				}
				$strHTML .= '</ul>'."\r\n";

				if($item->menu_item_parent == 0 && !empty($item->description))	{
					$strHTML .= '<p>'.$item->description.'</p>';

				}

				$strHTML .= '</div>';

			}

			$strHTML .= '</li>';

		}

		return $strHTML;
	}

}