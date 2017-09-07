<?php
/*
Template Name: Live Here Interactive
 */
?>
<style>
#map {
	width:100% !important;
	height: calc(100vh - 329px) !important;
}
</style>

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
			<?php// get_sidebar(); ?>
			<section class="table__item table__item--no-padding">
				<?php echo ddp\live\View::getView('Property.interactiveMap'); ?>
			</section><!-- ./SITE-CONTENT -->
		</div>
	</main>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>