<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); 

	$bknd_img = wp_get_attachment_url( get_post_thumbnail_id('204') );
	$address = get_post_meta($post->ID, 'wpcf-address', true);
	$webaddress = get_post_meta($post->ID, 'wpcf-web-address', true);
	$postId = $post->post_parent;
	
	?>

		 <div id="wrapper-interior" class="interior-page live-here">
	  
	  			<div class="row title">
	  				<div class="col-md-9 col-md-offset-3">
			  			<h1>Property Listings</h1>
			  			<div class="sub-head"><?php print get_post_meta('204', 'wpcf-subhead', true); ?></div>
			  		</div>
			  	</div>
	  			<div class="main-img img-container">
			  		
			  		<img class="bg-image" src="<?php print $bknd_img; ?>" />
			  		
			  	</div>
	  		
	  

	  	
	  
	 <div class="interior-content">
	 	<div class="row main-body"> 
	 			<div class="col-md-3">	
	 				<div class="left-sidebar">
	 				<h3 class="page-title"><a href="<?php bloginfo('url'); ?>/live-here/">Live Here</a></h3>
	 				<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'live-here',
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
	 				<!-- <ul class="sub-menu">
	 					<li>D:Hive</li>
	 					<li>Campus Martius</li>
	 					<li>Long-term Placemaking</li>
	 					<li>2-1-1 On the Go</li>
						<li>Live Downtown</li>
						<li class="active">Clean Downtown</li>
						<li>Project Lighthouse</li>
						<li>Safety &amp; Security Initiatives</li>
						<li>Food &amp; Fun Guide</li>
	 				</ul> -->
	 				
	 				<!-- <h4 class="categories">Categories</h4>
	 				<ul class="categories">
	 					<li>Environent</li>
	 					<li>Leisure</li>
	 					<li>Living</li>
	 					<li>Events</li>
						<li>Business</li>
						<li>Networking</li>
						<li>Resources</li>
	 				</ul> -->
	 				</div>
	 				</div>
	 			<div class="col-md-9 main-content">
	 			<H4><?php the_title(); ?></H4>
	 			<?php if(has_post_thumbnail( $post_id )){ ?> 
	 			<img src="<?php print  wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" />
	 			<?php } ?>
	 			<p></p>
	 			<?php the_content(); ?>
	 			
	 			<div class="row property-location">
	 			<div class="col-sm-4" style="padding-bottom: 20px; padding-left: 0; text-align: left;">
	 			<div class="google-map"><?php echo do_shortcode('[google-map-v3 shortcodeid="219d2e889e" width="100%" height="200" zoom="16" maptype="roadmap" mapalign="center" directionhint="false" language="default" poweredby="false" maptypecontrol="false" pancontrol="true" zoomcontrol="true" scalecontrol="true" streetviewcontrol="true" scrollwheelcontrol="false" draggable="true" tiltfourtyfive="false" enablegeolocationmarker="false" enablemarkerclustering="false" addmarkermashup="false" addmarkermashupbubble="false" addmarkerlist="'.$address.'{}1-default.png" bubbleautopan="true" distanceunits="miles" showbike="false" showtraffic="false" showpanoramio="false"]') ?></div>
	 			</div>
	 			<div class="property-meta col-sm-6">
	 			<div class="property-address"><?php print $address; ?></div>
	 			<div> <?php print get_post_meta($post->ID, 'wpcf-phone-number', true); ?></div>
	 			<div>Floors: <?php print get_post_meta($post->ID, 'wpcf-floors', true); ?></div>
	 			<div>Units: <?php print get_post_meta($post->ID, 'wpcf-units', true); ?></div>
	 			<div>Unit Price: <?php print get_post_meta($post->ID, 'wpcf-price', true); ?></div>
	 			<div><a href="<?php print get_post_meta($post->ID, 'wpcf-property-website', true); ?>"><?php print get_post_meta($post->ID, 'wpcf-property-website', true); ?></a></div>
	 			
	 			</div>
	 			</div>
	 			<a href="<?php bloginfo('url'); ?>/live-here/property-listings/">&#171; Back to Listings</a>
	 			</div>
	 	</div>
	 	
	 </div>

	<?php endwhile; else: ?>

		<section>
			<article>
				<p>Sorry, no posts matched your criteria.</p>
			</article>
		</section>

	<?php endif; ?>

<?php get_footer(); ?>