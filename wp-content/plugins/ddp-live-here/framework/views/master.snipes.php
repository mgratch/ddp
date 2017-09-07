<!-- LIVE HERE CONTENT -->
  <div class="live-here-content js-live-here">
      <div id="map"></div>
    <div class="interaction-content js-interaction-content">
<!-- FILTER FORM CONTENT -->
      <div class="filter-content columned js-live-here-filters">
        <div class="column">
          <div class="bedrooms">
            <div class="button-group">
              <span class="form-label">Bedrooms</span>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="0" class="js-ddp-live-trigger-update js-ddp-live-filter-value">Studio</button>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="1" class="js-ddp-live-trigger-update js-ddp-live-filter-value">1</button>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="2" class="js-ddp-live-trigger-update js-ddp-live-filter-value">2</button>
              <button type="button" data-ddp-live-data-type="rooms" data-ddp-live-button-value="3" class="js-ddp-live-trigger-update js-ddp-live-filter-value">3+</button>
            </div>
          </div>


          <span class="checkbox">
            <input type="checkbox" name="ddp-filter-rent-show-available-only" value="available" class="js-ddp-live-trigger-update js-ddp-live-filter-value" data-ddp-live-data-type="type">
            <span class="checkbox-label rent-available-only-label">
              Only Show Available Units
            </span>
          </span>

        </div>

        <!-- End Column -->

        <div class="column">
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

           <div class="listing-toggle-button">
            <button class="action-button js-show-listings" type="button"><span class="js-toggle-label">Show</span> Listings</button>
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