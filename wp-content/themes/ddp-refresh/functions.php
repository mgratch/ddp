<?php
/**
 * Theme auto loading
 */
$theme_auto_load = array(
  'includes/functions/functions-base.php',
  'includes/super-cpt/super-cpt.php',
  'includes/io-admin/io-admin.php',
  'includes/functions/theme-functions.php',
  'includes/functions/sidebars.php',
  'includes/functions/post-types.php'
);

foreach ( $theme_auto_load as $auto_load ) {
  require_once get_template_directory() . '/' . $auto_load;
}