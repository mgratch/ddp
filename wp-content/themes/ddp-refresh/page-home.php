<?php
/*
Template Name: Home Page
*/
?>
<?php get_header();
	wp_enqueue_script('bxslider');
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
<?php add_action( 'wp_footer', function() { ?>

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