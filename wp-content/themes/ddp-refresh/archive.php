<?php get_header(); ?>

	<section class="main">
		<div class="wrapper">
				<section class="site-content">
				<?php if (have_posts()) : ?>

				<?php $post = $posts[0]; // hack: set $post so that the_date() works ?>
				<?php if (is_category()) { ?>
				<h1>Archive for the &ldquo;<?php single_cat_title(); ?>&rdquo; Category</h1>

				<?php } elseif(is_tag()) { ?>
				<h1>Posts Tagged &ldquo;<?php single_tag_title(); ?>&rdquo;</h1>

				<?php } elseif (is_day()) { ?>
				<h1>Archive for <?php the_time('F jS, Y'); ?></h1>

				<?php } elseif (is_month()) { ?>
				<h1>Archive for <?php the_time('F, Y'); ?></h1>

				<?php } elseif (is_year()) { ?>
				<h1>Archive for <?php the_time('Y'); ?></h1>

				<?php } elseif (is_author()) { ?>
				<h1>Author Archive</h1>

				<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h1>Blog Archives</h1>

			<?php } ?>
			<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<p>Posted on <?php the_time('F jS, Y'); ?> by <?php the_author(); ?></p>
					
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
				<?php endif; ?>
			</section><!-- ./SITE-CONTENT -->
<?php get_sidebar(); ?>
		</div><!-- ./WRAPPER -->
	</section><!-- ./SECTION-MAIN -->
<?php get_footer(); ?>
