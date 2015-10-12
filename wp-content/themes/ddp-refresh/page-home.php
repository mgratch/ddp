<?php
/*
Template Name: Home Page
*/
?>
<?php get_header();
	wp_enqueue_script('bxslider');	
	
	// Jeff i started this for you, but something isn't translating the same as your hard coded structure
	// I am 99% certain, there should be only 1 H1 per page unless you can show me otherwise, for seo
/*	
	$sOut = '';
	
	// Get Home Slides
	$args = array(
			'numberposts' => -1,
			'post_type' => 'home-slider',
			'orderby' => 'menu_order',
			'order' => 'ASC'
	);
	
	$slides = get_posts( $args );
	
	$sOut .= '<main>';
	$sOut .= '<ul class="carousel carousel--landing">';
	
	foreach( $slides as $slide ) {
		$ioMeta = get_post_custom( $slide->ID );
		$sOut .= '<li class="carousel__slide__content">';
	
		if(!empty($ioMeta['home-slider-image'][0])) {
			$sOut .= wp_get_attachment_image( $ioMeta['home-slider-image'][0], $size = 'io-home-slider', false, array( 'class' => 'flex-image' ) );
		} else {
			$sOut .= '<img src="http://placehold.it/2500x1238" alt="">';
		}
	
		$sOut .= '<div class="carousel__slide__content">';
		$sOut .= '<h1 class="headline headline--carousel">'.get_the_title($slide->ID ).'</h1>';
			
			
		if( !empty( $ioMeta['home-slider-text'][0] ) )
			$sOut .= '<p class="carousel__slide__content__copy">'.$ioMeta['home-slider-text'][0].'</p>';
			
		if( !empty( $ioMeta['home-slider-cta-text'][0] ) && !empty( $ioMeta['home-slider-cta-url'][0] )) {
			$sOut .= '<a class="button button--cta button--color-2" href="'.$ioMeta['home-slider-cta-url'][0].'">'.$ioMeta['home-slider-cta-text'][0].'</a>';
	
		}
	
		$sOut .= '</div>';
		$sOut .= "</li>\n";
	}
	
	$sOut .= '</ul>'; // io-home-slider
	$sOut .= '</main>'; // io-home-slider-container
	
	echo $sOut;
	
	*/
?>
 
	<main>
	<ul class="carousel carousel--landing">
		<li class="carousel__slide">
			<img src="http://placehold.it/2500x1238" alt="">
			<div class="carousel__slide__content">
				<h1 class="headline headline--carousel">Explore Downtown Parks</h1>
				<p class="carousel__slide__content__copy">Check out Jeanette Pierce of DDP's Detroit Experience Factory, as she talks with WDET on Detroit's parks.</p>
				<a class="button button--cta button--color-2" href="#">Call To Action</a>
			</div>
		</li>
		<li class="carousel__slide">
			<img src="http://placehold.it/2500x1238" alt="">
			<div class="carousel__slide__content">
				<h1 class="headline headline--carousel">News Headline That is Really long making it wrap into two lines</h1>
				<p class="carousel__slide__content__copy">Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
				<a class="button button--cta button--color-2" href="#">Call To Action</a>
			</div>
		</li>
		<li class="carousel__slide">
			<img src="http://placehold.it/2500x1238" alt="">
			<div class="carousel__slide__content">
				<h1 class="headline headline--carousel">Promotion Headline</h1>
				<p class="carousel__slide__content__copy">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Sed posuere consectetur est at lobortis. Donec ullamcorper nulla non metus auctor fringilla.</p>
				<a class="button button--cta button--color-2" href="#">Call To Action</a>
			</div>
		</li>
	</ul>
	</main>
	
	
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

add_action( 'wp_footer', function() { ?>

	<script type="text/javascript">
		jQuery(function($) {
    	landingCarousel = $('.carousel').show().bxSlider({
    		slideWidth   : '10000',
        // auto         : true,
        autoHover    : true,
        pause        : 8000,
        touchEnabled : false,
        pager				 : false,
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

<?php get_footer(); ?>