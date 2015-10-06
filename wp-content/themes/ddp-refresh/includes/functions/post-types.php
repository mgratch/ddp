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