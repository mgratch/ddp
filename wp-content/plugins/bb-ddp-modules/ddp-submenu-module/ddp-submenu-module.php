<?php

class DDP_Submenu_Module extends FLBuilderModule {

	public function __construct()
	{
		parent::__construct(array(
			'name'            => __( 'Submenu Module', 'fl-builder' ),
			'description'     => __( 'Generate a list of current pages children.', 'fl-builder' ),
			'category'        => __( 'Advanced Modules', 'fl-builder' ),
			'dir'             => BB_DDP_MODULES_DIR . 'ddp-submenu-module/',
			'url'             => BB_DDP_MODULES_URL . 'ddp-submenu-module/',
			'editor_export'   => true, // Defaults to true and can be omitted.
			'enabled'         => true, // Defaults to true and can be omitted.
			'partial_refresh' => false, // Defaults to false and can be omitted.
		));
	}
}

FLBuilder::register_module( 'DDP_Submenu_Module', array() );

/**
 * Function: get_submenu
 */

function ddp_get_submenu( $parent_page_id ) {
	//calling walker function to show menu
	return wp_nav_menu( array(
		'echo'            => false,
		'theme_location'  => 'main',
		'container'       => false,
		'menu_class'      => 'menu menu--side',
		'container_class' => false,
		'menu_id'         => false,
		'walker'          => new IODDPSubWalker
	) );
}
