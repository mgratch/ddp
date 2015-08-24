	<?php
/*
Template Name: Events AJAX
*/
$type = $_GET['t'];

if($type == "articles-events"){
?>
	<div class="latest-news events item active">
		<div class="row">
	      	<div class="col-md-7">
	      			  
	      		<div class="feature-article-1">
		      		<div class="swiper-container">
		      			<div class="swiper-wrapper">
		      				<?php
				
								$args=array(
								  'post_type' => 'tribe_events',
								  'posts_per_page'=> 3,
								  'offset' => 0,
								  'meta_query' => array(
								  array(
								  	'key' => 'wpcf-featured',
								  	'value' => 1
									)
								  )
								  
								);

								//EventStartDate
								//EventEndDate
								
								
								query_posts($args);
									
								while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

								  <?php
								  	//print_r($post);

								  $sd = tribe_get_start_date($post->ID, false, 'M j, Y');
								  $ed = tribe_get_end_date($post->ID, false, 'M j, Y');

								  ?>

								  <?php $feat_excerpt = get_post_meta($post->ID, 'wpcf-featured-excerpt', true); ?>
								<div class="swiper-slide">
									<div class="img-container">
						      			<img class="bg-image" src="<?php print wp_get_attachment_url( get_post_thumbnail_id($id) ); ?>" />
						      		</div>
						      		<div class="text-box">
						      			<?php if ($sd == $ed){ ?>
						      			<div class="date"><?php echo $sd; ?></div>
						      			<?php } else { ?>
						      			<div class="date"><?php echo $sd." - ".$ed; ?></div>
						      			<?php } ?>
						      			<?php the_title(); ?>
						      			<p><?php print $feat_excerpt; ?></p>
						      			<br><a class="readmore" href="<?php the_permalink(); ?>">Read ></a>
						      		</div>
					      		</div>
							
								 <?php
								  endwhile;

								?>
		      			</div>
	      			</div>
	      		</div>
	      		
	      		
	      	</div>
	      	
	      	
	      	<div class="col-md-5">
				<div class="feature-article-2">
	      			<div class="swiper-container">
		      			<div class="swiper-wrapper">
		      		<?php
						
						$args=array(
							    'post_type' => 'tribe_events',
								  'posts_per_page'=> 3,
								  'offset' => 0,
								  'meta_query' => array(
								  array(
								  	'key' => 'wpcf-featured',
								  	'value' => 2
									)
								  )
							);
						
						query_posts($args);
									
						while ($wp_query->have_posts()) : $wp_query->the_post();
						
						
						?>
						<?php
								  	//print_r($post);

								  $sd = tribe_get_start_date($post->ID, false, 'M j, Y');
								  $ed = tribe_get_end_date($post->ID, false, 'M j, Y');

						?>
						<div class="swiper-slide">
								<div class="text-box">
				      				<?php if ($sd == $ed){ ?>
						      			<div class="date"><?php echo $sd; ?></div>
						      			<?php } else { ?>
						      			<div class="date"><?php echo $sd." - ".$ed; ?></div>
						      			<?php } ?>
				      				<?php the_title(); ?>
				      				<br><a class="readmore" href="<?php the_permalink(); ?>">Read ></a>
				      			</div>
			      			</div>
						
								<?php
								  endwhile;

								?>	
						</div>
					</div>
	      		</div>
	      		<div class="feature-article-3">
	      			<div class="swiper-container">
		      			<div class="swiper-wrapper">
		      		<?php

							$args=array(
							    'post_type' => 'tribe_events',
								  'posts_per_page'=> 3,
								  'offset' => 3,
								  'meta_query' => array(
								  array(
								  	'key' => 'wpcf-featured',
								  	'value' => 2
									)
								  )
							);
							
							
							query_posts($args);
								
							while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
							<?php
								  	//print_r($post);

								  $sd = tribe_get_start_date($post->ID, false, 'M j, Y');
								  $ed = tribe_get_end_date($post->ID, false, 'M j, Y');

							?>
						
							<div class="swiper-slide">
								<div class="text-box">
				      				<?php if ($sd == $ed){ ?>
						      			<div class="date"><?php echo $sd; ?></div>
						      			<?php } else { ?>
						      			<div class="date"><?php echo $sd." - ".$ed; ?></div>
						      			<?php } ?>
				      				<?php the_title(); ?>
				      				<br><a class="readmore" href="<?php the_permalink(); ?>">Read ></a>
				      			</div>
			      			</div>
						
							 <?php
							  endwhile;

							?>
						</div>
					</div>
	      		</div>
				
			</div>
		</div>
	</div>

	
<?php }else if($type == "articles-latest-news"){ ?>

<div class="latest-news item active">
			<div class="row">
		      	<div class="col-md-7">
		      			  
		      		<div class="feature-article-1">
			      		<div class="swiper-container">
			      			<div class="swiper-wrapper">
			      			<?php
		
									$args=array(
									  'post_type' => 'post',
									  'meta_key' => 'wpcf-featured',
									  'meta_value' => '1',
									  'posts_per_page' => 3,
									 
									);
									
									
									query_posts($args);
										
									  while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
									<div class="swiper-slide">
										<div class="img-container">
							      			<img class="bg-image" src="<?php print wp_get_attachment_url( get_post_thumbnail_id($id) ); ?>" />
							      		</div>
							      		<div class="text-box">
							      			<div class="date"><?php echo get_the_date(); ?></div>
							      			<?php the_title(); ?><br>
							      			<?php
								 			$key = 'wpcf-article-link'; 
								 			$link = get_post_meta($post->ID, $key, true );
											if($link) {
								 			?>
								 			<div style="color: #fff; display: inline; font-size: 14px;" class="article-source">( <?php print get_post_meta($post->ID, 'wpcf-publication-name', true); ?> )</div>
								 			<?php } ?>
							      			<a class="readmore" href="<?php the_permalink(); ?>">Read ></a>
							      		</div>
						      		</div>
								
									 <?php
									  endwhile;

								?>
			      			</div>
		      			</div>
		      		</div>
		      		
		      		<div class="feature-article-2">
		      			<div class="swiper-container">
			      			<div class="swiper-wrapper">
			      			<?php
	
								$args=array(
								  'post_type' => 'post',
								  'meta_key' => 'wpcf-featured',
								  'meta_value' => '2',
								  'posts_per_page' => 3,
								  'offset' => 0
								);
								
								
								query_posts($args);
									
								  while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
								<div class="swiper-slide">
									<div class="text-box">
					      				<div class="date"><?php echo get_the_date(); ?></div>
					      				<?php the_title(); ?><br>
							      			<?php
								 			$key = 'wpcf-article-link'; 
								 			$link = get_post_meta($post->ID, $key, true );
											if($link) {
								 			?>
								 			<div style="color: #fff; display: inline; font-size: 14px;" class="article-source">( <?php print get_post_meta($post->ID, 'wpcf-publication-name', true); ?> )</div>
								 			<?php } ?>
							      			<a class="readmore" href="<?php the_permalink(); ?>">Read ></a>
					      			</div>
				      			</div>
							
								 <?php
								  endwhile;

							?>
			      			</div>
		      			</div>
		      		</div>
		      	</div>
		      	
		      	
		      	<div class="col-md-5">
					<div class="feature-twitter-feed">
			      		<div class="text-box">
			      			<?php dynamic_sidebar('sidebar_twitter'); ?>
			      		</div>
		      		</div>
		      		<div class="feature-article-3">
		      			<div class="swiper-container">
			      			<div class="swiper-wrapper">
			      		<?php
	
								$args=array(
								  'post_type' => 'post',
								  'meta_key' => 'wpcf-featured',
								  'meta_value' => '2',
								  'posts_per_page' => 3,
								  'offset' => 3
								);
								
								
								query_posts($args);
									
								  while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
								<div class="swiper-slide">
									<div class="text-box">
					      				<div class="date"><?php echo get_the_date(); ?></div>
					      				<?php the_title(); ?><br>
					      				<?php
								 			$key = 'wpcf-article-link'; 
								 			$link = get_post_meta($post->ID, $key, true );
											if($link) {
								 			?>
								 			<div style="color: #fff; display: inline; font-size: 14px;" class="article-source">( <?php print get_post_meta($post->ID, 'wpcf-publication-name', true); ?> )</div>
								 			<?php } ?>
					      				<a class="readmore" href="<?php the_permalink(); ?>">Read ></a>
					      			</div>
				      			</div>
							
								 <?php
								  endwhile;

								?>
							</div>
						</div>
		      		</div>
					
				</div>
			</div>
		</div>

<?php } else if ($type == "articles-interactive-map"){ 
	?>
	<div class="hp-interactive-map">
	<?php
	
	//$map = get_page(269);
	//print do_shortcode($map->post_content);
	echo do_shortcode('[interactive-map width="100%" height="100%" file="'.get_home_url().'/wp-content/uploads/2014/04/data.xls"]');
	?>
	</div>
	<?php
 } ?>