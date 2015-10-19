<?php get_header(); ?>
	<main>
		<?php if (have_posts()) : while (have_posts()) : the_post();
			$customMeta = clean_meta( get_post_custom($post->ID) );
		?>
			<section class="hero hero--with-content">
				<div class="hero__content">
					<h1 class="headline headline--light headline--page-main"><?php the_title(); ?></h1>
					<div class="headline headline--page-sub headline--emphasis"><?php echo get_post_meta($post->ID, 'wpcf-subhead', true); ?></div>
				</div>
				<?php echo wp_get_attachment_image( get_post_thumbnail_id($id), 'full', '', array('class'=>'hero__image')); ?>
			</section>

			<?php get_sidebar(); ?>
			<section class="site-content">
				<article id="post-<?php the_ID(); ?>">
					<?php the_content(); ?>
				</article>
			</section><!-- ./SITE-CONTENT -->
		<?php endwhile; endif; ?>
	</main>
<?php get_footer(); ?>