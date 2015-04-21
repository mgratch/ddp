<?php

namespace ddp\live;

/*
	Plugin Name: SuperCPT
	Plugin URI: http://wordpress.org/extend/plugins/super-cpt/
	Description: Insanely easy and attractive custom post types, custom post meta, and custom taxonomies
	Version: 0.2.1
	Author: Matthew Boynes, Union Street Media
	Copyright 2011-2013 Shared and distributed between Matthew Boynes and Union Street Media

	GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


class Super_CPT {

	protected $config;

	/**
	 * Initialize the plugin and call the appropriate hook method
	 *
	 * @uses admin_hooks
	 * @author Matthew Boynes
	 */
	function __construct() {
		$this->config = array(
			'plugin_url' => plugins_url( '', __FILE__ ) . '/',
			'plugin_dir' => dirname( __FILE__ )
		);

		require_once $this->config['plugin_dir'] . '/includes/scpt-helpers.php';
		require_once $this->config['plugin_dir'] . '/includes/class-scpt-markup.php';
		require_once $this->config['plugin_dir'] . '/includes/class-super-custom-post-meta.php';
		require_once $this->config['plugin_dir'] . '/includes/class-super-custom-post-type.php';
		require_once $this->config['plugin_dir'] . '/includes/class-super-custom-taxonomy.php';

		$this->load_js_and_css();
	}

	/**
	 * Add supercpt.css to the doc head
	 *
	 * @return void
	 * @author Matthew Boynes
	 */
	function load_js_and_css() {
		add_action('admin_enqueue_scripts', function() {
			wp_register_style( 'supercpt.css', $this->config['plugin_url'] . 'css/supercpt.css', array(), '0.2.0' );
			wp_register_script( 'supercpt-ddp-live.js', $this->config['plugin_url'] . 'js/supercpt.js', array( 'jquery', 'jquery-ui-core' ), '0.2.1' );
			wp_enqueue_style( 'supercpt.css' );
		});
	}

	function Super_Custom_Post_Type($type, $singular = false, $plural = false, $register = array())
	{
		return new Super_Custom_Post_Type($type, $singular, $plural, $register);
	}
}
?>