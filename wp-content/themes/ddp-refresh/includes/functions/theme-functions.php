<?php

/**
 * Script & Style Registration
 */
function io_theme_scripts()
{
  /* -- Scripts -- */
  wp_register_script('ioddcommon', get_template_directory_uri().'/javascript/insideout_common.js', array( 'jquery' ), '', true );

  /* -- Initial Localization -- */
  wp_localize_script( 'ioddcommon', 'io_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'init', 'io_theme_scripts' );

/**
 * Custom Image Sizes
 */

/**
 * Get contents of an SVG file for inline ouput
 */
function renderSVG($path = false) {
  if ($path) {
    return file_get_contents($path);
  }
}
