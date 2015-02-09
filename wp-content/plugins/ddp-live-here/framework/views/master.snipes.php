<!-- LIVE HERE CONTENT -->
  <div class="live-here-content js-live-here">
      <div id="map"></div>
    <div class="interaction-content js-interaction-content">
<!-- FILTER FORM CONTENT -->
      <div class="filter-content columned js-live-here-filters">
        <div class="columned-row">
          <div class="housing-type">
            <span class="form-label">Housing Type</span>
            <div class="checkbox-list">
              <div class="checkbox-group">
                <input type="checkbox" name="ddp-filter-rent" value="rent" class="js-ddp-live-trigger-update js-ddp-live-filter-value" data-ddp-live-data-type="type" checked>
                <span class="checkbox-label rent-label">
                  For Rent
                  <span class="io-icon-map-marker"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="24.227px" height="37.674px" viewBox="0 0 24.227 37.674" enable-background="new 0 0 24.227 37.674" xml:space="preserve"><path fill="currentColor" d="M12.113 1C5.976 1 1 6 1 12.113c0 6.2 7.9 17 11.1 23.321c3.18-6.451 11.139-17.449 11.139-23.321 C23.227 6 18.3 1 12.1 1z M12.113 15.679c-1.834 0-3.321-1.487-3.321-3.321s1.487-3.321 3.321-3.321 s3.321 1.5 3.3 3.321S13.947 15.7 12.1 15.679z"/><path fill="white" d="M12.113 1c6.138 0 11.1 5 11.1 11.113c0 5.873-7.959 16.87-11.139 23.3 C8.875 29.1 1 18.3 1 12.113C1 6 6 1 12.1 1 M12.113 15.679c1.834 0 3.321-1.487 3.321-3.321 s-1.487-3.321-3.321-3.321s-3.321 1.487-3.321 3.321S10.279 15.7 12.1 15.7 M12.113 0C5.434 0 0 5.4 0 12.1 c0 4.7 4.1 11.5 7.7 17.579c1.354 2.3 2.6 4.4 3.5 6.193l0.904 1.788l0.886-1.797 c0.932-1.891 2.299-4.208 3.747-6.662c3.513-5.957 7.495-12.708 7.495-17.102C24.227 5.4 18.8 0 12.1 0L12.113 0z M12.113 14.679c-1.28 0-2.321-1.041-2.321-2.321s1.042-2.321 2.321-2.321c1.28 0 2.3 1 2.3 2.3 S13.394 14.7 12.1 14.679L12.113 14.679z"/></svg></span>
                </span>
              </div>
              <div class="checkbox-group">
                <input type="checkbox" name="ddp-filter-buy" value="buy" class="js-ddp-live-trigger-update js-ddp-live-filter-value" data-ddp-live-data-type="type" checked>
                <span class="checkbox-label sale-label">
                  For Sale
                  <span class="io-icon-map-marker"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="24.227px" height="37.674px" viewBox="0 0 24.227 37.674" enable-background="new 0 0 24.227 37.674" xml:space="preserve"><path fill="currentColor" d="M12.113 1C5.976 1 1 6 1 12.113c0 6.2 7.9 17 11.1 23.321c3.18-6.451 11.139-17.449 11.139-23.321 C23.227 6 18.3 1 12.1 1z M12.113 15.679c-1.834 0-3.321-1.487-3.321-3.321s1.487-3.321 3.321-3.321 s3.321 1.5 3.3 3.321S13.947 15.7 12.1 15.679z"/><path fill="white" d="M12.113 1c6.138 0 11.1 5 11.1 11.113c0 5.873-7.959 16.87-11.139 23.3 C8.875 29.1 1 18.3 1 12.113C1 6 6 1 12.1 1 M12.113 15.679c1.834 0 3.321-1.487 3.321-3.321 s-1.487-3.321-3.321-3.321s-3.321 1.487-3.321 3.321S10.279 15.7 12.1 15.7 M12.113 0C5.434 0 0 5.4 0 12.1 c0 4.7 4.1 11.5 7.7 17.579c1.354 2.3 2.6 4.4 3.5 6.193l0.904 1.788l0.886-1.797 c0.932-1.891 2.299-4.208 3.747-6.662c3.513-5.957 7.495-12.708 7.495-17.102C24.227 5.4 18.8 0 12.1 0L12.113 0z M12.113 14.679c-1.28 0-2.321-1.041-2.321-2.321s1.042-2.321 2.321-2.321c1.28 0 2.3 1 2.3 2.3 S13.394 14.7 12.1 14.679L12.113 14.679z"/></svg></span>
                </span>
              </div>
            </div>
          </div>
          <div class="rental-price-range">
            <div class="range-group js-range-group monetary">
              <span class="form-label">Price Range &mdash; Monthly Rental</span>
              <div class="js-range-slider" data-type="rent"></div>
              <input type="hidden" data-ddp-live-data-type="min-rent" class="js-ddp-live-filter-value js-min-value slider-value" value="0" />
              <input type="hidden" data-ddp-live-data-type="max-rent" class="js-ddp-live-filter-value js-max-value slider-value max-value" value="500" />
              <div class="value-display-wrap">
                <span class="min-value"><span class="denomination">$</span><span class="js-min-value-display">Min Val</span></span>
                <span class="max-value"><span class="denomination">$</span><span class="js-max-value-display">Max Val</span></span>
              </div>
            </div>
          </div>
        </div>
        <div class="columned-row">
          <div class="bedrooms">
            <div class="button-group">
              <span class="form-label">Bedrooms</span>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="studio" class="js-ddp-live-trigger-update js-ddp-live-filter-value selected">Studio</button>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="1" class="js-ddp-live-trigger-update js-ddp-live-filter-value selected">1</button>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="2" class="js-ddp-live-trigger-update js-ddp-live-filter-value selected">2</button>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="3" class="js-ddp-live-trigger-update js-ddp-live-filter-value selected">3</button>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="4" class="js-ddp-live-trigger-update js-ddp-live-filter-value selected">4</button>
              <button type="button" data-ddp-live-data-type="rooms"  data-ddp-live-button-value="5" class="js-ddp-live-trigger-update js-ddp-live-filter-value selected">5</button>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="6" class="js-ddp-live-trigger-update js-ddp-live-filter-value selected">6+</button>
            </div>
          </div>
          <div class="sale-price-range">
            <div class="range-group js-range-group monetary">
              <span class="form-label">Price Range &mdash; For Sale Price</span>
              <div class="js-range-slider" data-type="buy"></div>
              <input type="hidden" data-ddp-live-data-type="min-buy" class="js-ddp-live-filter-value js-min-value slider-value" value="0" />
              <input type="hidden" data-ddp-live-data-type="max-buy" class="js-ddp-live-filter-value js-max-value slider-value max-value" value="500" />
              <div class="value-display-wrap">
                <span class="min-value"><span class="denomination">$</span><span class="js-min-value-display">Min Val</span></span>
                <span class="max-value"><span class="denomination">$</span><span class="js-max-value-display">Max Val</span></span>
              </div>
            </div>
          </div>
        </div>
        <div class="columned-row">
          <div class="listing-toggle-button">
            <button class="action-button js-show-listings" type="button"><span class="js-toggle-label">Show</span> Listings</button>
          </div>
          <div class="size-range">
            <div class="range-group js-range-group">
              <span class="form-label">Square Footage</span>
              <div class="js-range-slider" data-type="sq_ft"></div>
              <input type="hidden" data-ddp-live-data-type="min-sq-ft" class="js-ddp-live-filter-value js-min-value slider-value" value="0" />
              <input type="hidden" data-ddp-live-data-type="max-sq-ft" class="js-ddp-live-filter-value js-max-value slider-value max-value" value="500" />
              <div class="value-display-wrap">
                <span class="min-value"><span class="denomination">$</span><span class="js-min-value-display">Min Val</span></span>
                <span class="max-value"><span class="denomination">$</span><span class="js-max-value-display">Max Val</span></span>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- END FILTER FORM -->
      <div class="js-ddp-live-listing-container" style="display:none">
        <div class="filter-results-listing-content js-listing-content"></div>
      </div>

      <button class="toggle-button toggle-content-display js-toggle-content-display material" type="button">
        <span class="js-toggle-label">Hide</span> <span class="io-icon-arrow-up"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 317 371" enable-background="new 0 0 317 371" xml:space="preserve" version="1.1"><polygon fill="currentColor" points="0,156.438 0,212.272 139,75.079 139,371 179,371 179,76.065 317,212.273 317,156.438 158.5,0 "/></svg></span>
      </button>
    </div>
  </div>
<!-- END LIVE HERE CONTENT -->

<?php add_action('wp_footer', function() { ?>
<script>
    (function($) {

    $('.js-toggle-content-display').on('click', function() {
      $(this).toggleClass('closed');
      $(this).parent().toggleClass('closed');
    });

    })(jQuery);
  </script>
<?php }, 666); ?>