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
		<section class="hero hero--with-content">
			<div class="<?php echo 'hero__content hero__content--'.$topParentPostMeta['page_color']; ?>">
				<h1 class="headline headline--light headline--page-main"><?php the_title(); ?></h1>
				<?php if (!empty($customMeta['wpcf-subhead'])) {
						echo '<div class="headline headline--page-sub headline--emphasis">'.$customMeta['wpcf-subhead'].'</div>';
					} ?>
			</div>
			<?php echo wp_get_attachment_image( get_post_thumbnail_id($id), 'full', '', array('class'=>'hero__image')); ?>
		</section>
		<div class="content-columned content-columned--with-aside">
			<?php get_sidebar(); ?>
			<section class="content-columned__item site-content">
				<article id="post-<?php the_ID(); ?>">
					<?php the_content(); ?>
				</article>
			</section><!-- ./SITE-CONTENT -->
		</div>
	<?php endwhile; endif; ?>
<?php get_footer();
	// var_dump($topParentPostMeta);
?>