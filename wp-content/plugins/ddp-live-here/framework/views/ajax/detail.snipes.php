<div class="single-listing-detail-content js-ddp-live-detail-container">
  <button type="button" class="js-close-detail close-detail"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px" viewBox="0 0 15 15" enable-background="new 0 0 15 15" xml:space="preserve" version="1.1" id="Layer_1"><polygon fill="currentColor" points="15,12.603 9.897,7.5 15,2.397 12.603,0 7.5,5.103 2.397,0 0,2.397 5.103,7.5 0,12.603 2.397,15 7.5,9.897 12.603,15"/></svg></button>

  <div class="scroll-content">
    <ul class="listing-carousel js-listing-carousel">
      <li class="slide">
        <!-- ASPECT RATIO 3:2 - 1080x720px -->
        <img src="http://fillmurray.com/1080/720">
      </li>
      <li class="slide">
        <!-- ASPECT RATIO 3:2 - 1080x720px -->
        <img src="http://fillmurray.com/1080/720">
      </li>
      <li class="slide">
        <!-- ASPECT RATIO 3:2 - 1080x720px -->
        <img src="http://fillmurray.com/1080/720">
      </li>
      <li class="slide">
        <!-- ASPECT RATIO 3:2 - 1080x720px -->
        <img src="http://fillmurray.com/1080/720">
      </li>
    </ul>
    <div class="listing-details">
      <span class="listing-detail-price">$0,000/month</span>
      <span class="listing-detail-features">{{ $property->sq_footage }} sq. ft., {{ $property->rooms }} Bedrooms</span>
    </div>
    <div class="detail-content">
      <h3 class="section-title">Description</h3>
      <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>
      <h3 class="section-title">Features</h3>
      <p>Covered parking, 2 parking spaces, shared gym, hardwood throughout</p>
    </div>
  </div>
  <div class="fixed-footer">
    <button class="cta-button" type="button">Contact Agent</button>
  </div>
</div>



<?php add_action('wp_footer', function() { ?>
  <script>
    (function($) {
      $('.js-range-slider').slider({
        range: true,
        min: 0,
        max: 500,
        values: [ 0, 500 ],
        slide: function( event, ui ) {
          var el = $(this);
          var values = ui.values;
          var group = el.parents('.js-range-group');
          group.find('.js-min-value').val(values[0]);
          group.find('.js-max-value').val(values[1]);
        }
      });

      carousel = $('.js-listing-carousel').show().bxSlider({
        slideWidth   : "1080",
        pager        : false,
        prevText     : '<span class="io-icon-arrow-left"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="371px" height="317px" viewBox="0 0 371 317" enable-background="new 0 0 371 317" xml:space="preserve" version="1.1" id="Layer_1"><polygon fill="currentColor" points="156.438,317 212.272,317 75.079,178 371,178 371,138 76.065,138 212.273,0 156.438,0 0,158.5 "/></svg></span>',
        nextText     : '<span class="io-icon-arrow-right"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="371.256px" height="317px" viewBox="0 0 371.256 317" enable-background="new 0 0 371.256 317" xml:space="preserve" version="1.1" id="Layer_1"><polygon fill="currentColor" points="214.818,0 158.983,0 296.177,139 0,139 0,179 295.19,179 158.982,317 214.818,317 371.256,158.5 "/></svg></span>',
        onSliderLoad: function(){
          jQuery('.slide').eq(1).addClass('current');
        },
        onSlideBefore: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
          jQuery('.slide').removeClass('current');

        },
        onSlideAfter: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
          jQuery('.slide').eq(currentSlideHtmlObject+1).addClass('current');
        }
      });

    })(jQuery);
  </script>
<?php }, 666); ?>