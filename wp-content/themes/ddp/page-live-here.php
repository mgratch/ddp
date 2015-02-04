<?php
/*
Template Name: Live Here Interactive
 */
?>
<style>
#map {
	width:100%;
	height: 60vh;
}

</style>

<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		 <div id="wrapper-interior" class="interior-page do-business single-generic">

	  			<div class="row title">
	  				<div class="col-md-9 col-md-offset-3">
			  			<h1><?php the_title(); ?></h1>
			  			<div class="sub-head"><?php print get_post_meta($post->ID, 'wpcf-subhead', true); ?></div>
			  		</div>
			  	</div>
			  	<div class="main-img img-container" style="height:210px;"></div>


	 <div class="interior-content">
			<div class="row main-body">
		 		<?php echo ddp\live\View::getView('Property.InteractiveMap'); ?>
		 	</div>
	 </div>
	</div>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>