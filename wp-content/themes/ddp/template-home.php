<?php
/*
Template Name: Home
*/
?>
<?php get_header(); 
	wp_enqueue_script( 'gmap', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCp9myMYaPmpqRMXpsuwIezCx5sAFE80IY&sensor=false');
	wp_enqueue_script('gmap-infobox', 'http://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.9/src/infobox.js');
	wp_enqueue_script( 'gmap-custom', plugins_url().'/ddp-interactive-map/js/ddp-map.js');
?>

		<div id="main-carousel" class="slideshow carousel slide" data-ride="carousel">
	  	<?php
	  	$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'menu_order',
			'order'            => 'ASC',
			'post_type'        => 'hp-slide',
			'suppress_filters' => true );

	  	$slides = get_posts($args);
	  	?>
	  	<div class="carousel-inner">
	  		<?php foreach($slides as $k => $slide){
	  			$class = 'item';
	  			if($k == 0){
	  				$class .= ' active';
	  			}

	  			$img = get_post_meta($slide->ID, 'wpcf-slide-image', true);
	  			$banner_text = get_post_meta($slide->ID, 'wpcf-banner-text', true);
	  			$banner_color = get_post_meta($slide->ID, 'wpcf-banner-color-select', true);
	  		?>
	  		<div class="<?=$class?>">
	  			<div class="main-img img-container">
	  				<div class="cta">
	  					<div class="banner <?=$banner_color?>">
	  						<span class="left-cap"></span><span class="txt"><?=$banner_text?></span><span class="right-cap"></span>
	  					</div>
	  					<div class="title"><?=$slide->post_title?></div>
	  				</div>
			  		<img class="bg-image" src="<?=$img?>" />
			  	</div>
	  		</div>

	  		<?php

	  		} // end foreach

	  		?>
	  		<!-- <div class="item">
	  			<div class="main-img img-container">
	  				<div class="cta">
	  					<div class="banner">test</div>
	  					<div class="title">Delivering Something</div>
	  				</div>
			  		<img class="bg-image" src="<?php bloginfo('template_url'); ?>/images/main-tigers.jpg" />
			  	</div>
	  		</div> -->
	  	</div>
	  	

	  	<!--controls-->
	  	  <a class="left carousel-control" href="#main-carousel" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left"> </span>
		  </a>
		  <a class="right carousel-control" href="#main-carousel" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right"> </span>
		  </a>
		  <div class="title-toggle"><span></span>Hide Title</div>
	  </div>
	  
	  <div class="articles-main-header header">What's happening Downtown?</div>
      <div class="row articles-main">
    	<img src="<?php bloginfo('template_url'); ?>/images/loading.gif" class="loading" />
      	<div class="col-sm-2 article-nav">
			<ul>
				<li id="articles-latest-news">Latest News</li>
				<li class="events" id="articles-events">Events</li>
				<li id="articles-interactive-map">Interactive Map</li>
			</ul>
		
		</div>
		
		<div class="articles-content ajax-container col-sm-10">
		</div>
		
		
      </div>
      
      <div class="programs-main-header header">Our Programs + Progress</div>
      <div class="row programs-progress-main">
      	<div class="col-md-4">
      		<a href="<?php print get_post_meta(get_option('page_on_front'), 'wpcf-feature-1-link', true); ?>">
      		<div class="text-box">
      			<img src="<?php print get_post_meta(get_option('page_on_front'), 'wpcf-feature-1-image', true); ?>" />
      			<div><?php print get_post_meta(get_option('page_on_front'), 'wpcf-feature-1-text', true); ?><br><span>Read More</span></div>
      		</div>
      		</a>
      	</div>
      	<div class="col-md-4">
      		<a href="<?php print get_post_meta(get_option('page_on_front'), 'wpcf-feature-2-link', true); ?>">
      		<div class="text-box">
      			<img src="<?php print get_post_meta(get_option('page_on_front'), 'wpcf-feature-2-image', true); ?>" />
      			<div><?php print get_post_meta(get_option('page_on_front'), 'wpcf-feature-2-text', true); ?><br><span>Read More</span></div>
      		</div>
      		</a>
      	</div>
      	<div class="col-md-4">
      		<a href="<?php print get_post_meta(get_option('page_on_front'), 'wpcf-feature-3-link', true); ?>">
      		<div class="text-box">
      			<img src="<?php print get_post_meta(get_option('page_on_front'), 'wpcf-feature-3-image', true); ?>" />
      			<div><?php print get_post_meta(get_option('page_on_front'), 'wpcf-feature-3-text', true); ?><br><span>Read More</span></div>
      		</div>
      		</a>
      	</div>
      </div>

<?php get_footer(); ?>