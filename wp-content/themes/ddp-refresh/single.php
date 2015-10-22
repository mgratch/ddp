<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post();
		$postParentData = get_content_by_slug('about-ddp',true);
		$postCategory = get_the_category();

		if (!empty($postParentData)) {
			$customMeta = clean_meta($postParentData->post_custom );

			$topParentPostMeta = $customMeta;
			$topParentPostID = $postParentData->ID;
			$topParentTitle = get_the_title($postParentData->ID);
		}
	?>
		<main>
			<section class="hero hero--with-content">
				<div class="<?php echo 'hero__content hero__content--'.$topParentPostMeta['page_color']; ?>">
					<div class="table table--with-aside">
						<div class="table__item"></div>
						<div class="table__item">
							<div class="page-content">
								<h1 class="headline headline--light headline--page-main"><?php echo $postCategory[0]->name; ?></h1>
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
						<h2 class="<?php echo 'headline headline--slab headline--size-large headline--'.$topParentPostMeta['page_color']; ?>"><?php the_title(); ?></h2>
						<p class="post-meta">Posted on <?php the_time('F jS, Y'); ?></p>
						<?php the_content(); ?>
					</article>
				</section><!-- ./SITE-CONTENT -->
			</div>
		</main>
		<?php endwhile; endif; ?>
<?php get_footer(); ?>