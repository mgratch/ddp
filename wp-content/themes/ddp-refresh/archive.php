<?php get_header();
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
		<?php if (have_posts()) : ?>
			<section class="hero hero--with-content">
				<div class="<?php echo 'hero__content hero__content--'.$topParentPostMeta['page_color']; ?>">
					<div class="table table--with-aside">
						<div class="table__item"></div>
						<div class="table__item">
							<div class="page-content">
								<?php $post = $posts[0]; // hack: set $post so that the_date() works ?>
								<?php if (is_category()) { ?>
									<h1 class="headline headline--light headline--page-main"><?php single_cat_title(); ?></h1>

								<?php } elseif(is_tag()) { ?>
									<h1>Posts Tagged &ldquo;<?php single_tag_title(); ?>&rdquo;</h1>

								<?php } elseif (is_day()) { ?>
									<h1 class="headline headline--light headline--page-main">Archive for <?php the_time('F jS, Y'); ?></h1>

								<?php } elseif (is_month()) { ?>
									<h1 class="headline headline--light headline--page-main">Archive for <?php the_time('F, Y'); ?></h1>

								<?php } elseif (is_year()) { ?>
									<h1 class="headline headline--light headline--page-main">Archive for <?php the_time('Y'); ?></h1>

								<?php } elseif (is_author()) { ?>
									<h1 class="headline headline--light headline--page-main">Author Archive</h1>

								<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
									<h1 class="headline headline--light headline--page-main">Blog Archives</h1>

								<?php } ?>
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
					<?php while (have_posts()) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" class="page-content">
							<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							<p>Posted on <?php the_time('F jS, Y'); ?></p>

							<?php the_excerpt(); ?>

							<p><?php the_tags('Tags: ', ', ', '<br>'); ?> Posted in <?php the_category(', '); ?> &bull; <?php edit_post_link('Edit', '', ' &bull; '); ?> <?php comments_popup_link('Respond to this post &raquo;', '1 Response &raquo;', '% Responses &raquo;'); ?></p>
						</article>
					<?php endwhile; ?>
					<?php else : ?>
									<article>
								<h1>Not Found</h1>
								<p>Sorry, but the requested resource was not found on this site.</p>
								<?php get_search_form(); ?>
							</article>
					</section><!-- ./SITE-CONTENT -->
				</div>
		<?php endif; ?>
	</main><!-- ./SECTION-MAIN -->
<?php get_footer(); ?>
