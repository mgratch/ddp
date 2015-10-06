<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<section class="<?php echo 'main '.$post->post_type.'-'.$post->post_name; ?>">
		<div class="wrapper">
			<section class="site-content">
				<article id="post-<?php the_ID(); ?>">
					<h1><?php the_title(); ?></h1>
				
					<?php the_content('Read more on "'.the_title('', '', false).'" &raquo;'); ?>
				</article>
			</section><!-- ./SITE-CONTENT -->
	<?php endwhile; endif; ?>
<?php get_sidebar(); ?>
		</div><!-- ./WRAPPER -->
	</section><!-- ./SECTION-MAIN -->
<?php get_footer(); ?>