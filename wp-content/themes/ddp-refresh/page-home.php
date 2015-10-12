<?php
/*
Template Name: Home Page
*/
?>
<?php get_header();
	wp_enqueue_script('bxslider');
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

			function home_module($module_id) {
				$module_meta = clean_meta(get_post_custom( $module_id ));

				return $module_meta;
			};


			$module_color = array('blue','teal','purple','orange');

			//do the tabs need colors?

			$strTabNav = '<ul>';
			$strTabHTML = '';

			for ($i=1; $i <= 3; $i++) {
				if (!empty($custom_data['home_module_id_'.$i])) {
					$module_meta = home_module($custom_data['home_module_id_'.$i]);

					if(!empty($module_meta['home_module_type'])) {

						$strTabNav .= '<li class="home-tab-button-'.$i.'">'.get_the_title($custom_data['home_module_id_'.$i])."</li>\n";

						if($module_meta['home_module_type'] == 'map') {
							$strTabHTML .= '<div class="home-tab-content-'.$i.'">';

						//We need to turn debug off and get the domain right for the Maps API
						//	$strTabHTML .= do_shortcode('[interactive-map width="100%" height="100%" file="http://devbucket.net/sites/ddp/dev/wp-content/uploads/2014/04/data.xls"]');

							$strTabHTML .= '</div>';

						} else {
							//multiple listings

							$strTabHTML .= '<div class="home-tab-content-'.$i.'">';

							if(!empty($module_meta['home_module_subsets'])) {
								$strTabHTML .= '<ul>';
								foreach ($module_meta['home_module_subsets'] as $key=>$subset){

									if($key < 4) { //only show 4
										$strTabHTML .= '<li>';


										//Jeff not sure how you need the structure so I'm just outputing it , except for image
										if (!empty($subset['home_module_thumb_image'])) {
											$img_array = wp_get_attachment_image_src($subset['home_module_thumb_image'], 'full');
											$image = $img_array[0];
										} else {
											$image = 'http://placehold.it/268x293';
										}

										if (!empty($subset['home_module_link_text']) && !empty($subset['home_module_link_url'])) {
											$strTabHTML .= '<a class="well-button" href="'.check_url($subset['home_module_link_url']).'">'.$subset['home_module_link_text'].'</a>';
										}

										if (!empty($subset['home_module_main_title'])) {
											$strTabHTML .= '<h3 class="well-title">'.$subset['home_module_main_title'].'</h3>';
										}
										if (!empty($subset['home_module_main_text'])) {
											$strTabHTML .= '<div class="well-copy">'.$subset['home_module_main_text'].'</div>';
										}

										$strTabHTML .= "</li>\n";

									}
								}
								$strTabHTML .= '</ul>';
							}

							$strTabHTML .= '</div>';
						}
					}
				}
			}

			$strTabNav .= '</ul>';

			echo $strTabNav;

			echo $strTabHTML;
		?>

	</main>

<?php add_action( 'wp_footer', function() { ?>

	<script type="text/javascript">
		jQuery(function($) {
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
	var_dump($homeSlides);
?>