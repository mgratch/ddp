<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

get_header();
?>


		 <div id="wrapper-interior" class="interior-page explore archive ">
	  
	  			<div class="row title">
	  				<div class="col-md-9 col-md-offset-3">
			  			<h1>Events</h1>
			  			<div class="sub-head"><?php print get_post_meta('121', 'wpcf-subhead', true); ?></div>
			  		</div>
			  	</div>
	  			<div class="main-img img-container">
			  		
			  		<img class="bg-image" src="<?php print wp_get_attachment_url( get_post_thumbnail_id('121') ); ?>" />
			  		
			  	</div>
	  		
	  

	  	
	  
	 <div class="interior-content">
	 	<div class="row main-body"> 
	 			<div class="col-md-3">	
	 				<div class="left-sidebar">
	 				<h3 class="page-title"><a href="<?php bloginfo('url'); ?>/explore-downtown/">Explore Downtown</a></h3>
	 				<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'Explore',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'sub-menu explore',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 0,
								'walker'          => ''
							);

							wp_nav_menu( $defaults );
							?>
	 			
	 				</div>
	 				</div>
	 			<div class="col-md-9 main-content">
	 			
	 			<div id="tribe-events-pg-template">

					<?php tribe_events_before_html(); ?>
					<?php tribe_get_view(); ?>
					<?php tribe_events_after_html(); ?>
				</div> <!-- #tribe-events-pg-template -->
	
	 			</div>
	 	</div>
	 	
	 </div>


<?php get_footer();