<?php
/**
 * Registering and rendering sliders
 */
/* -- Slider Init -- */
new io_slider();

class io_slider {

  public function __construct() {
    $this->global_hooks_init();

    if( !is_admin() )
      $this->public_hooks_init();
  }

  /**
   * Global Hooks Init
   * @return null
   */
  public function global_hooks_init() {
    add_action( 'init', array( $this, 'global_hooks' ) );
  }

  /**
   * Public Hooks for Slider(s)
   * @return null
   */
  public function global_hooks() {
    add_shortcode( 'io_home_slider', array( $this, 'home_slider_view_shortcode' ) );
  }

  /**
   * Renders home slider
   * @return string html for slider display
   */
  public function home_slider_view_shortcode() {
    $this->slider_css_js_public();
    $sOut = '';

    // Get Home Slides
    $args = array(
      'numberposts' => -1,
      'post_type' => 'home-slider',
      'orderby' => 'menu_order',
      'order' => 'ASC'
    );

    $slides = get_posts( $args );

    // jQuery call for bxslider in footer
    add_action( 'wp_footer', function() {
      echo '
        <script type="text/javascript">
          jQuery(function($) {
           landingCarousel = $(".carousel").show().bxSlider({
    		slideWidth   : "10000",
	        // auto         : true,
	        autoHover    : true,
	        pause        : 8000,
	        touchEnabled : false,
	        pager				 : false,
	        prevText     : "'.renderSVG(get_template_directory('/images/icon-arrow-left.svg')).'",
	        nextText     : "'.renderSVG(get_template_directory('/images/icon-arrow-right.svg')).'",
	
	        onSliderLoad: function(){
	          jQuery(".carousel__slide").eq(1).addClass("current");
	          currentSlide = jQuery(".carousel__slide").eq(1);
	        },
	        onSlideBefore: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
	          jQuery(".carousel__slide").removeClass("current");
	          currentSlide = currentSlideNumber;
	
	        },
	        onSlideAfter: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
	          jQuery(".carousel__slide").eq(currentSlideHtmlObject+1).addClass("current");
	        }
	    	});
	  	});
	</script>
      ';
      }, 666 );

    // Slide output
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
      $sOut .= '</li>';
    }

    $sOut .= '</ul>'; // io-home-slider
    $sOut .= '</main>'; // io-home-slider-container

    return $sOut;
  }

  /**
   * Public Hooks Init
   * @return null
   */
  public function public_hooks_init() {
    add_action( 'init', array( $this, 'public_hooks' ) );
  }

  /**
   * Global Hooks for Slider(s)
   * @return null
   */
  public function public_hooks() {
    wp_register_script( 'bxslider', get_template_directory_uri() . '/javascript/jquery.bxslider.min.js', $deps = array( 'jquery' ), '', true );
  }

  /**
   * Enqueues scripts and styles for slider. To be called in view shortcode(s)
   * @return null
   */
  public function slider_css_js_public() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bxslider' );
  }

}
?>