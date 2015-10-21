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
  wp_register_script('ioddcommon', get_template_directory_uri().'/javascript/insideout_common.js', array( 'jquery' ), '', true );
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

$_ENV['DDP_LEGACY_ROUTING'] = false;

/*
  Plugin Name: Gravity Forms: Add Class To Submit Button
  Plugin URI: http://wordpress.org/extend/plugins/gravityforms-add-class-to-submit/
  Description: Adds a Field to Gravity Forms' Form Settings that lets you add a collection of CSS classes
  Author: poweredbycoffee
  Version: 1.0
  Author URI: http://poweredbycoffee.co.uk
 */

add_filter("gform_form_settings", "pbc_gf_add_class_to_button_ui", 10, 2);
function pbc_gf_add_class_to_button_ui($form_settings, $form){

    $form_settings["Form Button"]["button_class"] = '
    <tr id="form_button_text_setting" class="child_setting_row" style="' . $text_style_display . '">
            <th>
                ' .
      __( 'Button Class', 'gravityforms' ) . ' ' .
      gform_tooltip( 'form_button_class', '', true ) .
      '
    </th>
    <td>
      <input type="text" id="form_button_text_class" name="form_button_text_class" class="fieldwidth-3" value="' . esc_attr( rgars( $form, 'button/class' ) ) . '" />
            </td>
        </tr>';

    return $form_settings;

}



add_filter( 'gform_pre_form_settings_save', "pbc_gf_add_class_to_button_process", 10, 1);
 function pbc_gf_add_class_to_button_process($updated_form){
  $updated_form['button']['class'] = rgpost( 'form_button_text_class' );
  return $updated_form;
}


add_filter("gform_submit_button", "pbc_gf_add_class_to_button_front_end", 10, 2);
function pbc_gf_add_class_to_button_front_end($button, $form){



     preg_match("/class='[\.a-zA-Z_ -]+'/", $button, $classes);
     $classes[0] = substr($classes[0], 0, -1);
     $classes[0] .= ' ';
     $classes[0] .= esc_attr($form['button']['class']);
     $classes[0] .= "'";

    $button_pieces = preg_split(
              "/class='[\.a-zA-Z_ -]+'/",
              $button,
              -1,
              PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
    );

    return $button_pieces[0] . $classes[0] . $button_pieces[1];

}


// Check url
function check_url($url){
	if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url)){
		$url = 'http://'.$url;
	}

	return $url;
}

// Set sub menu class name
class IODDPWalker extends Walker_Nav_Menu
{

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
				$children_items = array();
				foreach ($elements as $s_element) {
					if( $element->db_id == $s_element->menu_item_parent){
						$children_items[] = $s_element;
					}
				}
				//var_dump($children_items);
				if(count($children_items) > 0 ){
					$childItems[$element->menu_item_parent]['sub'][$element->db_id] = $children_items;
				}
				//$menu_elements[] = $element;

			}

		}

		$strHtml = '';

		foreach($menu_elements as  $item){

			$classes = join(' ',io_menu_standards($item->classes,$item));
			$strHtml .= '<li id="menu-'.$item->db_id.'" class="'.$classes.'">';
				$strHtml .= '<a href="'.$item->url.'" class="menu__link">'.$item->title.'</a>';

				if (isset($childItems[$item->db_id])) {
					$strHtml .= '<div class="menu__flyout">';
						$strHtml .= '<div class="table table--2-items">';
							$strHtml .= '<ul class="menu menu--sub-menu table__item">';


							$strSubHtml = '';
							foreach($childItems[$item->db_id] as $key=>$subitem){

								if($key !== 'sub'){
									$split = ceil(count($childItems[$item->db_id])/2);
									$classes = join(' ',io_menu_standards($subitem->classes,$subitem));

									if($key == $split) {
										 $strHtml .= '</ul><ul class="menu menu--sub-menu table__item">';
									}
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

							$strHtml .= '</ul>';
						$strHtml .= '</div>';
						if($item->menu_item_parent == 0 && !empty($item->description))	{
							$strHtml .= '<p class="menu__item__description">'.$item->description.'</p>';
						}
					$strHtml .= '</div>';
				}
			$strHtml .= '</li>';
		}

		return $strHtml;
	}

}



/**
 * Function: get_top_parent_id
 */

function get_top_parent_id($current_page) {

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

// Set sub menu class name
class IODDPSubWalker extends Walker_Nav_Menu
{

	function walk( $elements, $max_depth) {
		global $post;

		$parent_page_id = get_top_parent_id($post);
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

			if($item->object_id == $parent_page_id) {
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
