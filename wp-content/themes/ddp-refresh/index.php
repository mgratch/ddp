<?php get_header(); ?>

	<section class="main">
		<div class="wrapper">
			<div class="site-content">
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>">

						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

						<p>Posted on <?php the_time('F jS, Y'); ?> by <?php the_author(); ?></p>

						<?php the_excerpt(); ?>

						<p><?php the_tags('Tags: ', ', ', '<br>'); ?> Posted in <?php the_category(', '); ?> &bull; <?php edit_post_link('Edit', '', ' &bull; '); ?> <?php comments_popup_link('Respond to this post &raquo;', '1 Response &raquo;', '% Responses &raquo;'); ?></p>
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
								'prev_text' => __('Prev'),
								'next_text' => __('Next'),
						) );
					?>
					<div class="pagination-links"><?php echo displayNumberedPagination($pagination);?></div>
				</nav>

				<?php else : ?>

					<article>
						<h1>Not Found</h1>
						<p>Sorry, but the requested resource was not found on this site.</p>
						<?php get_search_form(); ?>
					</article>

				<?php endif; ?>
			</div><!-- ./SITE-CONTENT -->
<?php get_sidebar(); ?>
		</div><!-- ./WRAPPER -->
	</section><!-- ./SECTION-MAIN -->

<?php get_footer(); ?>