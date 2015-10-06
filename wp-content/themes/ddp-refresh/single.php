<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<section class="<?php echo 'main '.$post->post_name; ?>">
			<div class="wrapper">
				<div class="site-content">
					<article id="post-<?php the_ID(); ?>">
						<h1><?php the_title(); ?></h1>
						
						<?php the_content('Read more on "'.the_title('', '', false).'" &raquo;'); ?>
						
						<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>

						<?php comments_template(); ?>
					</article>

					<?php endwhile; else: ?>

					<section>
						<article>
							<p>Sorry, no posts matched your criteria.</p>
						</article>
					</section>

					<?php endif; ?>
				</div><!-- ./SITE-CONTENT-->
<?php get_sidebar(); ?>
		</div><!-- ./WRAPPER -->
	</section><!-- ./SECTION-MAIN -->
<?php get_footer(); ?>