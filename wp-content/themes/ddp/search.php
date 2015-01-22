<?php get_header(); ?>

	<?php 

	$bknd_img = wp_get_attachment_url( get_post_thumbnail_id($id) );

	?>

		 <div id="wrapper-interior" class="interior-page do-business single-generic">
	  
	  			<div class="row title">
	  				<div class="col-md-9 col-md-offset-3">
	  					<h1>Search: <?php the_search_query(); ?></h1>
			  		</div>
			  	</div>
	  			<div class="main-img img-container">
			  		
			  		
			  	</div>
	  		
	  

	  	
	  
	 <div class="interior-content">
	 	<div class="row main-body"> 
	 			<div class="col-md-3">	
	 				<div class="left-sidebar">
	 				<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'OffCanvas',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'sub-menu',
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
		 			<h3>Search Results</h3>
		 			<?php if (have_posts()) :while (have_posts()) : the_post(); ?>
		 				<div class="ddp-search-result">
			 				<a title="<?php echo esc_attr( get_the_title() );?>" href="<?php echo get_permalink();?>"><?php the_title(); ?></a>
		 				</div>
		 			<?php endwhile; else:?>
		 			<p>No results found for <?php the_search_query(); ?></p>
		 			<?php endif;?>
		 			<nav class="pagination">
						<p><?php posts_nav_link('&nbsp;&nbsp;&nbsp;'); ?></p>
					</nav>
	 			</div>
	 	</div>
	 	
	 </div>

<?php get_footer(); ?>