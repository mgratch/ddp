<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); 
	
	
	
	$bknd_img = wp_get_attachment_url( get_post_thumbnail_id('129') );

	?>

		 <div id="wrapper-interior" class="interior-page do-business">
	  
	  			<div class="row title">
	  				<div class="col-md-9 col-md-offset-3">
			  			<h1>News</h1>
			  			<div class="sub-head"><?php print get_post_meta('129', 'wpcf-subhead', true); ?></div>
			  		</div>
			  	</div>
	  			<div class="main-img img-container">
			  		
			  		<img class="bg-image" src="<?php print $bknd_img; ?>" />
			  		
			  	</div>
	  		
	  

	  	
	  
	 <div class="interior-content">
	 	<div class="row main-body"> 
	 			<div class="col-md-3">	
	 				<div class="left-sidebar">
	 				<h3 class="page-title">Explore Downtown</h3>
	 				<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'offcanvas',
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
	 			<br>
	 			<div class="date"><?php the_date() ?></div>
	 			<br>
	 			<?php the_content(); ?>
	 			
	 			
	 			
	 			<?php
	 			$key = 'wpcf-article-link'; 
	 			$link = get_post_meta($post->ID, $key, true );
				if($link) {
	 			?>
	 			<p class="readmore"><a href="<?php print get_post_meta($post->ID, 'wpcf-article-link', true); ?>">Read the full article on <?php print get_post_meta($post->ID, 'wpcf-publication-name', true); ?> ></a></p>
	 			<?php } ?>
	 			
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