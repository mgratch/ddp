<?php
/*
Template Name: BIZ Board of Directors
 */
?>
<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post();
		$customMeta = clean_meta( get_post_custom($post->ID) );

		$topParentPostMeta = $customMeta;
		$topParentPostID = $post->ID;
		$topParentTitle = get_the_title();

		if($post->post_parent != 0){
			$topParentPostID = get_top_parent_id($post);
			$topParentPostMeta =  clean_meta(get_post_custom($topParentPostID));
			$topParentTitle = get_the_title($topParentPostID);
		}
	?>
	<main>
		<section class="hero hero--with-content">
			<div class="<?php echo 'hero__content hero__content--'.$topParentPostMeta['page_color']; ?>">
				<div class="table table--with-aside">
					<div class="table__item"></div>
					<div class="table__item">
						<div class="page-content">
							<h1 class="headline headline--light headline--page-main"><?php the_title(); ?></h1>
							<?php if (!empty($customMeta['wpcf-subhead'])) {
								echo '<div class="headline headline--page-sub headline--emphasis">'.$customMeta['wpcf-subhead'].'</div>';
							} ?>
						</div>
					</div>
				</div>
			</div>
			<?php echo wp_get_attachment_image( get_post_thumbnail_id($id), 'full', '', array('class'=>'hero__image')); ?>
		</section>
		<div class="table table--with-aside table--top-offset">
			<?php get_sidebar(); ?>
			<section class="table__item">
				<article class="page-content">
					<?php
					$board_directors = get_posts(array(
						'post_type'=>'biz-board',
						'posts_per_page' => -1,
						'orderby' => 'menu',
						'order' => 'ASC'
						)
					);

					if(!empty($board_directors)) {

						foreach($board_directors as $director) {

							echo '<div class="landing-page-listing">';
								$director_title = types_render_field("biz-board-title", array("raw"=>true,"post_id"=>$director->ID));

								$director_headshot_src = types_render_field("biz-board-headshot", array("raw"=>true,"post_id"=>$director->ID));

								if (!empty($director_headshot_src)) {
									$director_headshot = $director_headshot_src;
								} else {
									$director_headshot = 'http://placehold.it/330';
								}

								echo '<div class="biz-board-headshot">';
									echo '<img src="'.$director_headshot.'">';
								echo '</div>';

								echo '<div class="flex-container">';
									if(!empty($director_title)){
										echo '<h3 class="headline headline--slab headline--size-small headline--color-4">'.$director_title.'</h3>';
									}
									echo '<h2 class="headline headline--slab headline--size-medium headline--color-4">';
										echo get_the_title($director->ID);

										$director_company = types_render_field("biz-board-company", array("raw"=>true,"post_id"=>$director->ID));
										if(!empty($director_company)){
											echo ', '.$director_company;
										}
									echo '</h2>'; //end biz-board-name
									echo '<div class="biz-board-bio">';
										echo apply_filters('the_content', $director->post_content);
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
					}
				?>
				</article>
			</section><!-- ./SITE-CONTENT -->
		</div>
	</main>
	<?php endwhile; endif; ?>
<?php get_footer();
	// var_dump($topParentPostMeta);
?>