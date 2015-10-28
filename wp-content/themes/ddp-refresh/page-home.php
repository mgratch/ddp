<?php
/*
Template Name: Home Page
*/
?>
<?php get_header();
	wp_enqueue_script('bxslider');
	wp_enqueue_script('velocity');
	wp_enqueue_script('velocity-ui');

	$instagramFeed = [];

	if (class_exists(IODD\Instagram\Instagram::class)) {
		$instagramFeed = IODD\Instagram\Instagram::load()->getFeed();
	}
?>

	<main>
		<?php
			$args = array(
				'numberposts' => -1,
				'post_type' => 'home_carousel',
				'orderby' => 'menu_order',
				'order' => 'ASC'
			);

			$homeSlides = get_post_awesome( $args, true );
			$strHtml = '';

			if (!empty($homeSlides)) {
				$strHtml .= '<ul class="carousel carousel--landing">';
					foreach ($homeSlides as $key => $slide) {
						if (!empty($slide->meta['home_slide_image'])) {

							$slideImage = IOResponsiveImage::getImage($slide->meta['home_slide_image'], [
							  'class' => 'carousel__slide__image',
							  'alt' => ''
							]);

							$strHtml .= '<li class="carousel__slide">';
								$strHtml .= '<div class="carousel__slide__container">';
								$strHtml .= $slideImage;
									$strHtml .= '<div class="carousel__slide__content">';
										if (!empty($slide->meta['home_slide_title'])) {
											$strHtml .= '<h2 class="headline headline--carousel">'.$slide->meta['home_slide_title'].'</h2>';
										}
										if (!empty($slide->meta['home_slide_copy'])) {
											$strHtml .= '<p class="carousel__slide__content__copy">'.$slide->meta['home_slide_copy'].'</p>';
										}
										if (!empty($slide->meta['home_slide_cta_text']) && !empty($slide->meta['home_slide_link'])) {
											$strHtml .= '<a class="button button--cta button--color-2" href="'.$slide->meta['home_slide_link'].'">'.$slide->meta['home_slide_cta_text'].'</a>';
										}
									$strHtml .= '</div>';
								$strHtml .= '</div>';
							$strHtml .= '</li>';
						}
					}
				$strHtml .= '</ul>';
			}

			echo $strHtml;
		?>

		<?php
			//Start the Tabs with content area
			$custom_data = clean_meta(get_post_custom());
			$module_meta = '';
			$map = do_shortcode('[interactive-map width="100%" height="100%" file="/2014/04/data.xls"]');

			function home_module($module_id) {
				$module_meta = clean_meta(get_post_custom( $module_id ), array('home_module_subsets'));

				return $module_meta;
			};

			$strTabNav = '<ul class="tabs tabs--landing">';
			$strTabHtml = '';

			for ($i=1; $i <= 3; $i++) {
				if (!empty($custom_data['home_module_id_'.$i])) {
					$module_meta = home_module($custom_data['home_module_id_'.$i]);

					if(!empty($module_meta['home_module_type'])) {

						if ($module_meta['home_module_type'] == 'multi' && !empty($module_meta['home_module_subsets'][0]['home_module_main_title']) ) {
							$strTabNav .= '<li class="tabs__tab js-tab"><span class="tab__title">'.get_the_title($custom_data['home_module_id_'.$i])."</span></li>\n";
						}  else if ($module_meta['home_module_type'] == 'map') {
							$strTabNav .= '<li class="tabs__tab js-tab"><span class="tab__title">'.get_the_title($custom_data['home_module_id_'.$i])."</span></li>\n";
						 }

						if($module_meta['home_module_type'] == 'map') {
							$strTabHtml .= '<div class="tab__content js-tab-content">';

	 							// We need to turn debug off and get the domain right for the Maps API
								$strTabHtml .= $map;

							$strTabHtml .= '</div>';

						} else {
							// multiple listings
							$strTabHtml .= '<div class="tab__content js-tab-content js-tab-content">';

							if( !empty($module_meta['home_module_subsets'][0]['home_module_main_title']) ) {

								$strTabHtml .= '<ul class="grid grid--4-items grid--landing">';
								foreach ($module_meta['home_module_subsets'] as $key => $subset) {

									if( $key < 4 ) { //only show 4
										$strTabHtml .= '<li class="grid__item">';
											if ( !empty($subset['home_module_thumb_image']) ) {
												$image = IOResponsiveImage::getImage($subset['home_module_thumb_image'], [
												  'class' => 'grid__item__image centering-image',
												  'alt' => ''
												]);
											} else {
												$image = '<img class="grid__item__image centering-image" src="http://placehold.it/600x640">';
											}
											$strTabHtml .= '<div class="grid__item__image-container">';
												$strTabHtml .= $image;

												if (!empty($subset['home_module_link_text']) && !empty($subset['home_module_link_url'])) {
													$strTabHtml .= '<a class="button button--cta button--'.$subset['home_module_color'].'" href="'.check_url($subset['home_module_link_url']).'">'.$subset['home_module_link_text'].'</a>';
												}
											$strTabHtml .= '</div>';
											$strTabHtml .= '<div class="grid__item__content">';

											if (!empty($subset['home_module_main_title'])) {
												$strTabHtml .= '<h3 class="headline headline--'.$subset['home_module_color'].' headline--light grid__item__title">'.$subset['home_module_main_title'].'</h3>';
											}
											if (!empty($subset['home_module_main_text'])) {
												$strTabHtml .= '<p class="grid__item__copy">'.$subset['home_module_main_text'].'</p>';
											}
											$strTabHtml .= '</div>';
										$strTabHtml .= '</li>'."\r\n";

									}
								}
								for ($z=1; $z <= 2; $z++) {
									$strTabHtml .= '<li class="grid__item flex-grid-spacer"></li>'."\r\n";
								}
								$strTabHtml .= '</ul>';
							}

							$strTabHtml .= '</div>';
						}
					}
				}
			}

			$strTabNav .= '</ul>';

			echo $strTabNav;
			echo '<div class="js-tab-content-container">'.$strTabHtml.'</div>';
		?>
		<h2 class="headline headline--light headline--section-divide">Connect with us</h2>
		<div class="table table--3-items social-feeds">
			<div class="social-widget table__item">
				<h4 class="headline headline--color-2 headline--with-icon headline--social-widget"><?php echo renderSVG(get_template_directory().'/images/logo-instagram.svg'); ?> Instagram</h4>
					<?php
						$strHtml = '';

						$strHtml .= '<ul class="grid grid--instagram">';
							foreach ($instagramFeed->data as $key => $ipost) {
								if ($key < 9) {
									$strHtml .= '<li class="grid__item">';
										$strHtml .= '<a href="'.$ipost->link.'" target="_blank">';
											$strHtml .= '<img class="grid__item__image" src="'.$ipost->images->thumbnail->url.'">';
										$strHtml .= '</a>';
									$strHtml .= '</li>';
								}
							}
							for ($i = 1; $i <= 1; $i++) {
								$strHtml .= '<li class="grid__item flex-grid-spacer"></li>';
							}
						$strHtml .= '</ul>';

						echo $strHtml;
					?>
			</div>

			<div class="social-widget table__item">
				<h4 class="headline headline--color-2 headline--with-icon headline--social-widget"><?php echo renderSVG(get_template_directory().'/images/logo-facebook.svg'); ?> Facebook</h4>
				<div class="fb-page" data-href="https://www.facebook.com/DowntownDetroitPartnership" data-width="100%" data-height="342" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/DowntownDetroitPartnership"><a href="https://www.facebook.com/DowntownDetroitPartnership">Downtown Detroit Partnership</a></blockquote></div></div>
			</div>

			<div class="social-widget table__item">
				<h4 class="headline headline--color-2 headline--with-icon headline--social-widget"><?php echo renderSVG(get_template_directory().'/images/logo-twitter.svg'); ?> Twitter</h4>
				<a class="twitter-timeline" href="https://twitter.com/DDPDetroit" data-widget-id="656204151580323840" data-width="823" data-height="342">Tweets by @DDPDetroit</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
		</div>
	</main>

<?php add_action( 'wp_footer', function() { ?>

	<script type="text/javascript">

		jQuery(function($) {
			/**
		   * Landing Carousel
		   */
    	landingCarousel = $('.carousel').show().bxSlider({
    		slideWidth   : '10000',
        auto         : ($(".carousel--landing .carousel__slide").length > 1) ? true : false,
        autoHover    : true,
        pause        : 8000,
        touchEnabled : false,
        pager				 : false,
        controls     : ($(".carousel--landing .carousel__slide").length > 1) ? true : false,
        prevText     : '<?php echo renderSVG(get_template_directory().'/images/icon-arrow-left.svg'); ?>',
        nextText     : '<?php echo renderSVG(get_template_directory().'/images/icon-arrow-right.svg'); ?>',

        onSliderLoad: function(){
          jQuery('.carousel__slide').eq(1).addClass('current');
          currentSlide = jQuery('.carousel__slide').eq(1);
        },
        onSlideBefore: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
          jQuery('.carousel__slide').removeClass('current');
          currentSlide = currentSlideNumber;

        },
        onSlideAfter: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
          jQuery('.carousel__slide').eq(currentSlideHtmlObject+1).addClass('current');
        }
    	});
  	});
	</script>

<?php }, 666 ); ?>

<?php get_footer();
	// var_dump($instagramFeed);
?>
