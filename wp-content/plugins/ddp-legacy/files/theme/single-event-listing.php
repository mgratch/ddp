<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); 

	$bknd_img = wp_get_attachment_url( get_post_thumbnail_id('272') );

	?>

		 <div id="wrapper-interior" class="interior-page explore">
	  
	  			<div class="row title">
	  				<div class="col-md-9 col-md-offset-3">
			  			<h1>Events</h1>
			  			<div class="sub-head"><?php print get_post_meta($post->ID, 'wpcf-subhead', true); ?></div>
			  		</div>
			  	</div>
	  			<div class="main-img img-container">
			  		
			  		<img class="bg-image" src="<?php print $bknd_img; ?>" />
			  		
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
	 				<!-- <ul class="sub-menu">
	 					<li>D:Hive</li>
	 					<li>Campus Martius</li>
	 					<li>Long-term Placemaking</li>
	 					<li>2-1-1 On the Go</li>
						<li>Live Downtown</li>
						<li class="active">Clean Downtown</li>
						<li>Project Lighthouse</li>
						<li>Safety &amp; Security Initiatives</li>
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
						<li>Resources</li>
	 				</ul> -->
	 				</div>
	 				</div>
	 			<div class="col-md-9 main-content">
	 			<H4><?php the_title(); ?></H4>
	 			<img class="event-image" src="<?php print get_post_meta($post->ID, 'wpcf-event-image', true); ?>" />
	 			
	 			<div class="row event-details">
	 				
		 			<div class="event-date col-xs-6">
		 			<span>When:</span><br>
		 			<?php $eventdate = get_post_meta($post->ID, 'wpcf-event-date', true);
								echo date('l, F jS, Y', $eventdate);
								?>
					</div>
		 			<div class="event-where col-xs-6">
		 			<span>Where:</span><br>
		 			<?php print get_post_meta($post->ID, 'wpcf-event-where', true); ?>
		 			</div>
	 			</div>
	 			<?php the_content(); ?>
	 			
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