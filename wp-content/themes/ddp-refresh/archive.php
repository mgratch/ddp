<?php get_header();
	$postParentData = get_content_by_slug('about-ddp',true);

	if (!empty($postParentData)) {
		$customMeta = clean_meta($postParentData->post_custom );

		$topParentPostMeta = $customMeta;
		$topParentPostID = $postParentData->ID;
		$topParentTitle = get_the_title($postParentData->ID);
	}
?>

	<main>
		<?php if (have_posts()) : ?>

			<?php function archiveTitles() {
				$post = $posts[0]; // hack: set $post so that the_date() works
				$archiveTitle = '';

					switch ($archiveTitle) {
						case is_category():
							return '<h1 class="headline headline--light headline--page-main">'.single_cat_title('', false).'</h1>';
							break;
						case is_tag():
							return '<h1 class="headline headline--light headline--page-main">'.single_tag_title('', false).'</h1>';
							break;
						case is_day():
							return '<h1 class="headline headline--light headline--page-main">'.get_the_time('F jS, Y').'</h1>';
							break;
						case is_month():
							return '<h1 class="headline headline--light headline--page-main">'.get_the_time('F, Y').'</h1>';
							break;
						case is_year():
							return '<h1 class="headline headline--light headline--page-main">'.get_the_time('Y').'</h1>';
							break;
					}
				} ?>

			<section class="hero hero--with-content">
				<div class="<?php echo 'hero__content hero__content--'.$topParentPostMeta['page_color']; ?>">
					<div class="table table--with-aside">
						<div class="table__item"></div>
						<div class="table__item">
							<div class="page-content">
								<?php echo archiveTitles(); ?>
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
					<div class="page-content list">
						<?php while (have_posts()) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" class="list__item">
								<h2 class="headline headline--slab headline--size-small"><a class="link--no-underline" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
								<p class="post-meta">Posted on <?php the_time('F jS, Y'); ?></p>
								<?php the_excerpt(); ?>
							</article>
						<?php endwhile; ?>
							<nav class="pagination">
								<?php
									global $wp_query;

									//pagination logic
									$big = 999999999; // need an unlikely integer

									$boolHideFirst = true;
									$boolHideLast = true;
									if($paged < 5){
										$mid = 4;

									} else {
										$mid = 2;
									}

									$pagination =  paginate_links( array(
											'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format' => '?paged=%#%',
											'current' => max( 1, $paged ),
											'total' => $wp_query->max_num_pages,
											'type'=>'array',
											'end_size'=>0,
											'mid_size'=>$mid,
											'prev_text' => __('Newer'),
											'next_text' => __('Older'),
									) );
								?>
								<div class="pagination-links"><?php echo displayNumberedPagination($pagination);?></div>
							</nav>
						<?php else : ?>
							<article class="list__item">
								<h1>Not Found</h1>
								<p>Sorry, but the requested resource was not found on this site.</p>
								<?php get_search_form(); ?>
							</article>
					</div>
				</section><!-- ./SITE-CONTENT -->
			</div>
		<?php endif; ?>
	</main><!-- ./SECTION-MAIN -->
<?php get_footer();
	// var_dump($postParentData);
?>
