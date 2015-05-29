<?php
/*
Template Name: Page BIZ Zone-Board of Directors
*/
?>
<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post();

	$bknd_img = wp_get_attachment_url( get_post_thumbnail_id($id) );

	?>

		 <div id="wrapper-interior" class="interior-page biz-zone">

	  			<div class="row title">
	  				<div class="col-md-9 col-md-offset-3">
			  			<h1><?php the_title(); ?></h1>
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
	 				<h3 class="page-title"><a href="<?php bloginfo('url'); ?>/business-improvement-zone/">Business Improvement Zone</a></h3>
	 				<?php
			  				$defaults = array(
								'theme_location'  => '',
								'menu'            => 'BIZ Zone',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'sub-menu livehere',
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
	 			<?php //the_content(); 
							
							
						$board_directors = get_posts(array(
							'post_type'=>'biz-board',
							'posts_per_page' => -1,
 							'orderby' => 'menu',
							'order' => 'ASC'
						
							)
						);	
							
							
					 if(!empty($board_directors)) {

						foreach($board_directors as $director) {
							
							echo '<div>';
							
							$director_title = types_render_field("biz-board-title", array("raw"=>true,"post_id"=>$director->ID));
							if(!empty($director_title)){
								echo '<div>'.$director_title.'</div>';
							}

								echo '<div>';
								$post_thumbnail_id = get_post_thumbnail_id( $post_id );
								if ( !empty($post_thumbnail_id) ) {
									echo wp_get_attachment_image($post_thumbnail_id);
								} 
								
									echo '<div>';
									
										echo '<div class="biz-board-name">';
											echo get_the_title($director->ID);
										
										$director_company = types_render_field("biz-board-company", array("raw"=>true,"post_id"=>$director->ID));
										if(!empty($director_company)){
											echo ', '.$director_company;
										}
									
										echo '</div>'; //end biz-board-name
										
										echo apply_filters('the_content', $director->post_content);
									echo '</div>';
								
								echo '</div>';
							echo '</div>';


						}
		

					}
							
							
							
							
				?>
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