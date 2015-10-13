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