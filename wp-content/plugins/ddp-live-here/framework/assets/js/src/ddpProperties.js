/**
 * TODO
 *
 * Debounce filter firing.
 * Recenter map on window resize and debounce.
 * Filtering function could use some refining.
 */

;( function($, window, google) {
  'use strict';

  var $scope = {
    ajaxUrl: window.ddpPropertiesObj.ajaxUrl,
    ajaxKey: window.ddpPropertiesObj.key,
    currentSlider: false
  };

  $scope.mapPins = {
    pin: 'M12.113 1C5.976 1 1 6 1 12.113c0 6.2 7.9 17 11.1 23.321c3.18-6.451 11.139-17.449 11.139-23.321 C23.227 6 18.3 1 12.1 1z M12.113 15.679c-1.834 0-3.321-1.487-3.321-3.321s1.487-3.321 3.321-3.321 s3.321 1.5 3.3 3.321S13.947 15.7 12.1 15.679z, M12.113 1c6.138 0 11.1 5 11.1 11.113c0 5.873-7.959 16.87-11.139 23.3 C8.875 29.1 1 18.3 1 12.113C1 6 6 1 12.1 1 M12.113 15.679c1.834 0 3.321-1.487 3.321-3.321 s-1.487-3.321-3.321-3.321s-3.321 1.487-3.321 3.321S10.279 15.7 12.1 15.7 M12.113 0C5.434 0 0 5.4 0 12.1 c0 4.7 4.1 11.5 7.7 17.579c1.354 2.3 2.6 4.4 3.5 6.193l0.904 1.788l0.886-1.797 c0.932-1.891 2.299-4.208 3.747-6.662c3.513-5.957 7.495-12.708 7.495-17.102C24.227 5.4 18.8 0 12.1 0L12.113 0z M12.113 14.679c-1.28 0-2.321-1.041-2.321-2.321s1.042-2.321 2.321-2.321c1.28 0 2.3 1 2.3 2.3 S13.394 14.7 12.1 14.679L12.113 14.679z',

    sale: '#d65b91',

    rent: '#369abd'
  };

  $scope.mask = $('<div style="background:white; display:block; opacity:.75 !important; width:100%; height:100%; position:absolute; top:0; left:0; z-index:99999;"></div>');

  $scope.Helpers = {
    exists: function(check) {
      if (check === null) {
        return false;
      }

      return true;
    },

    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
    debounce: function(func, wait, immediate) {
      var timeout;
      return function() {
        var context = this, args = arguments;
        var later = function() {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
      };
    },

    intBetween: function(test, min, max) {
      test = Number(test);
      if (test >= Number(min) && test <= Number(max)) {
        return true;
      }

      return false;
    },

    isFunction: function(functionToCheck) {
     var getType = {};
     return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
    }
  };

  var Model = function() {
    var $this = this;

    $this.getProperties = function(args) {
      args = $.extend({
        complete: false,
        filters: false
      }, args);

      var data = {
        action: 'ddpLiveGetProperties',
        key: $scope.ajaxKey,
        filters: args.filters
      };

      $.get($scope.ajaxUrl, data, function(response) {
        response = $.parseJSON(response);

        if ($scope.debug) {
          console.log('Properties ajax:');
          console.log(response);
        }

        if (args.complete) args.complete(response);
      });
    };

    return $this;
  };

  var View = function() {
    var $this = this;
    var _elements = {};
    var _hoodRendered = false;
    var _markers = {};
    var _propertyInfoWindows = {};
    var _regionsPolygons = [];
    $this.map = null;

    var init = function() {
      // Cache Elements
      _elements.listingContainer = $('.js-ddp-live-listing-container');
      _elements.listingContent = _elements.listingContainer.find('.js-listing-content');
      $this.$listingContent = _elements.listingContent;
    };

    $this.renderMap = function() {

      var options = {
        zoom: 14,
        center: new google.maps.LatLng(42.331427,-83.045754),
        scrollwheel: false,
        panControl: false,
        zoomControlOptions: {
          position: google.maps.ControlPosition.RIGHT_TOP
        },
      };

      $this.map = new google.maps.Map(document.getElementById('map'), options);

      $this.map.panBy(-100, -200);

      if (_hoodRendered === false) {
        $this.addRegions();
      }
     };

    $this.addProperties = function(properties) {
      if (properties) {
        $.each(_markers, function(i, val) {
          val.marker.setMap(null);
        });

        _markers = {};
        _propertyInfoWindows = {};

        // Need timeout to get the content for the info window, race condition
        // failsafe
        setTimeout(function() {
          if ($('.listing-item').length) {
            for (var i = 0; i < properties.length; i++) {
              var property = properties[i];
              if ($scope.Helpers.exists(property.latitude) && $scope.Helpers.exists(property.longitude)) {

                var marker = new google.maps.Marker({
                  map: $this.map,
                  position: new google.maps.LatLng(property.latitude, property.longitude),
                  animation: google.maps.Animation.DROP,
                  icon: {
                    path: $scope.mapPins.pin,
                    fillColor: $scope.mapPins[property.type],
                    fillOpacity: 1,
                    strokeColor: '#ffffff',
                    strokeWeight: 1,
                    scale: 1,
                    anchor: {x: 24, y: 38}
                  }
                });

                _markers[property.id] = {
                  id: property.id,
                  marker: marker
                };

                var contentStr = '<div class="ddp-live-info-window">' + $('[data-ddp-live-id="'+property.id+'"]').html() + '<div><button href="#" class="action-button js-ddp-live-here-infowindow" data-property-id="'+property.id+'">View Listing</button></div></div>';

                _markers[property.id].infowindow = new google.maps.InfoWindow({
                    content: contentStr,
                    maxWidth: 200
                });

              }
            }

            $.each(_markers, function(i, marker) {
              google.maps.event.addListener(marker.marker, 'click', function() {
                $.each(_markers, function(ii, mmarker) {
                  mmarker.infowindow.close($this.map);
                });
                marker.infowindow.open($this.map, this);
              });
            });
          }
        }, 2000);
      }
    };

    $this.listingDetail = function(atts) {
      atts = atts || {};
      atts = $.extend({
        propertyId: false,
        $container: false,
        onComplete: function() {}
      }, atts);

      if (! atts.$container) return false;
      if (! atts.propertyId) return false;

      var data = {
        action: 'ddpPropertyDetail',
        key: $scope.ajaxKey,
        propertyId: atts.propertyId
      };

      $.get($scope.ajaxUrl, data, function(response){
        response = $.parseJSON(response);
        var $html = $(window.Base64.decode(response.html));

        $html.prependTo(atts.$container);

        $scope.currentSlider = atts.$container.find('.js-listing-carousel').show().bxSlider({
          slideWidth   : '1080',
          auto         : false,
          useCSS       : false,
          pager        : false,
          prevText     : '<span class="io-icon-arrow-left"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="371px" height="317px" viewBox="0 0 371 317" enable-background="new 0 0 371 317" xml:space="preserve" version="1.1" id="Layer_1"><polygon fill="currentColor" points="156.438,317 212.272,317 75.079,178 371,178 371,138 76.065,138 212.273,0 156.438,0 0,158.5 "/></svg></span>',
          nextText     : '<span class="io-icon-arrow-right"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="371.256px" height="317px" viewBox="0 0 371.256 317" enable-background="new 0 0 371.256 317" xml:space="preserve" version="1.1" id="Layer_1"><polygon fill="currentColor" points="214.818,0 158.983,0 296.177,139 0,139 0,179 295.19,179 158.982,317 214.818,317 371.256,158.5 "/></svg></span>',
          onSliderLoad: function(){
            $('.slide').eq(1).addClass('current');
          },
          onSlideBefore: function(){
            $('.slide').removeClass('current');

          },
          onSlideAfter: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
            totalSlideQty = null;
            currentSlideNumber = null;
            $('.slide').eq(currentSlideHtmlObject+1).addClass('current');
          }
        });

        atts.onComplete($html, data.propertyId);
      });
    };

    $this.addRegions = function() {
      _regionsPolygons = [];

      var regionMeta = {
        downtown: {
          fillColor: '#fb9a00',
          label: 'Downtown',
          linkUri: 'live-here/district-profiles/downtown'
        },
        corktown:  {
          fillColor: '#36b3ce',
          label: 'Corktown',
          linkUri: 'live-here/district-profiles/corktown'
        },
        rivertown: {
          fillColor: '#b4c82c',
          label: 'Rivertown',
          linkUri: false
        },
        lafayettepark: {
          fillColor: '#2468c0',
          label: 'Lafayette Park',
          linkUri: 'live-here/district-profiles/lafayette-park'
        },
        easternmarket: {
          fillColor: '#ea60d5',
          label: 'Eastern Market',
          linkUri: 'live-here/district-profiles/eastern-market'
        },
        midtown: {
          fillColor: '#9ea7ca',
          label: 'Midtown',
          linkUri: 'live-here/district-profiles/midtown'
        },
        woodbridge: {
          fillColor: '#fa4b5b',
          label: 'Woodbridge',
          linkUri: false
        },
        techtown: {
          fillColor: '#e8e116',
          label: 'Techtown',
          linkUri: false
        },
        newcenter: {
          fillColor: '#06b39d',
          label: 'New Center',
          linkUri: 'live-here/district-profiles/new-center'
        }
      };

      // Load hoods file
      $.getJSON(window.ddpPropertiesObj.assetUri+'/data/hoods.json', function(data) {
        data = data.features;
        var i = 0;
        for (i; i < data.length; i++) {
          var item = data[i];

            var coords = [];
            $.each(item.geometry.coordinates[0], function(index, value) {
              coords.push(new google.maps.LatLng(value[1], value[0]));
            });

            var metaRef = item.properties.name.toLowerCase().replace(' ', '');

            var poly = new google.maps.Polygon({
              paths: coords,
              strokeColor: null,
              strokeOpacity: 0,
              strokeWeight: 0,
              fillColor: regionMeta[metaRef].fillColor,
              fillOpacity: 0.25
            });

            poly.setMap($this.map);

            _regionsPolygons.push({
              polygon: poly,
              center: poly.getBounds().getCenter(),
              regionMeta: regionMeta[metaRef]
            });
        }

        // Set Region Pins
        $.each(_regionsPolygons, function(i, val) {
          var offset;
          var slug = val.regionMeta.label.toLowerCase().replace(' ', '-');

          if (slug === 'downtown') {
            offset = 0.004;
            val.center.A = (val.center.A - offset);
            val.center.F = (val.center.F + offset);
          }

          var marker = new google.maps.Marker({
            map: $this.map,
            position: new google.maps.LatLng(val.center.A, val.center.F),
            animation: google.maps.Animation.DROP,
            icon: {
              url: window.ddpPropertiesObj.assetUri+'/images/regions/pins/'+slug+'.svg',
              scale: 1,
              anchor: {x: 136/2, y: 36/2}
            }
          });

          _regionsPolygons[i].marker = marker;

          if (val.regionMeta.linkUri) {
            var contentStr = '';

            contentStr += '<div class="infowindow-content"><div>';
              contentStr += '<img src="'+window.ddpPropertiesObj.assetUri+'/images/regions/images/'+slug+'.jpg" />';
            contentStr += '</div>';

            contentStr += '<div>';
              contentStr += '<a class="action-button" href="'+window.ddpPropertiesObj.siteUrl+''+val.regionMeta.linkUri+'">More Info<a>';
            contentStr += '</div></div>';

            var infowindow = new google.maps.InfoWindow({
              content: contentStr,
              maxWidth: 200
            });

            google.maps.event.addListener(_regionsPolygons[i].marker, 'click', function() {
              infowindow.open($this.map, _regionsPolygons[i].marker);
            });
          }
        });

      });

      _hoodRendered = true;
    };

    $this.removeRegions = function() {
      $.each(_regionsPolygons, function(i, val) {
        val.polygon.setMap(null);
        val.marker.setMap(null);
      });
    };

    $this.loadListings = function(atts) {
      atts = atts || {};
      atts = $.extend({
        properties: false,
        $mask: false,
        onComplete: function() {}
      }, atts);

      if (! atts.properties) return false;

      var properties = $.map(atts.properties, function(val) {
        return val.id;
      });

      var data = {
        action: 'ddpPropertyListing',
        key: $scope.ajaxKey,
        properties: properties
      };

      $.get($scope.ajaxUrl, data, function(response) {
        response = $.parseJSON(response);

        atts.$mask.animate({
          opacity: 1
        }, 600, function() {
          _elements.listingContent.html(window.Base64.decode(response.html));

          atts.$mask.animate({
            opacity: 0
          }, 400, function() {
            atts.$mask.remove();
          });
        });

        atts.onComplete();
      });
    };

    $this.showListings = function() {
      _elements.listingContainer.show();
    };

    $this.removeListings = function() {
      _elements.listingContainer.hide();
    };

    init();
    return $this;
  };

  $scope.App = function (config) {
    var $this = this;
    var _Model = new Model();
    var _View = new View();
    var _properties = false;
    var _currentProperties = {};
    var _elements = {};
    var _events = {};
    $this.filters = {};
    var _config = $.extend({
      debug: false,
      onUpdate: function() {},
      onFilter: function(){}
    }, config);

    $scope.debug = _config.debug;

    $this.init = function() {
      cacheElements();
      bindEvents();

      _Model.getProperties({
        complete: function(response) {

          _View.renderMap();

          if (response) {
            _properties = response;
            registerSliders();
            update();
          } else {
            View.noResults();
          }
        }
      });
    };

    var cacheElements = function() {
      _elements.container = $('.js-live-here');
      _elements.filters = _elements.container.find('.js-live-here-filters');
      _elements.sliders = _elements.container.find('.js-range-slider');
      _elements.triggers = _elements.container.find('.js-ddp-live-trigger-update');
      _elements.filterValues = _elements.container.find('.js-ddp-live-filter-value');
      _elements.showListingButton = _elements.container.find('.js-show-listings');
      _elements.getDetailButton = _elements.container.find('.js-ddp-live-get-detail');
      _elements.interactionContent = _elements.container.find('.js-interaction-content');
      _elements.closeDetailButton = _elements.container.find('.js-close-detail');
      _elements.districtOverlay = _elements.container.find('.js-ddp-live-district-overlay');
      _elements.controlToggle = _elements.container.find('.js-toggle-content-display');
      _elements.controlToggleLabel = _elements.controlToggle.find('.js-toggle-label');
    };

    var registerSliders = function() {
      _elements.sliders.each(function() {
        var $el = $(this),
            type = $el.attr('data-type'),
            ranges = _properties.ranges,
            min = parseInt(ranges.price[type].min),
            max = parseInt(ranges.price[type].max);

        if (!min) min = 0;
        if (!max) max = 0;

        var updateValues = function(minVal, maxVal) {

          var $group = $el.parents('.js-range-group');

          $group.find('.js-min-value').val(minVal);
          $group.find('.js-max-value').val(maxVal);
          $group.find('.js-min-value-display').text(window.numeral(minVal).format('0,0'));
          $group.find('.js-max-value-display').text(window.numeral(maxVal).format('0,0'));
        };

        // Trigger initial ui update for values
        updateValues(min, max);

        $el.slider({
          range: true,
          min: min,
          max: max,
          values: [min, max],
          step: 5,
          slide: function( event, ui ) {
            var values = ui.values;
            updateValues(values[0], values[1]);
          },
          stop: function() {
            update();
          }
        });
      });
    };

    var bindEvents = function() {

      _elements.districtOverlay.click(function() {
        var $el = $(this);

        if ($el.is(':checked')) {
          _View.addRegions();
        } else {
          _View.removeRegions();
        }
      });

      $('.js-ddp-live-here-infowindow').live('click', function() {
        var $el = $(this);
        var propertyID = $el.attr('data-property-id');

        // Make sure we are showing the control / listing area
        _events.toggleControls({
          state: 'open'
        });

        _elements.interactionContent.css({
          height: '100%'
        });

          _View.listingDetail({
            propertyId: propertyID,
            $container: _elements.interactionContent
         });
      });

      _elements.triggers.each(function() {
        var $el = $(this),
            type = $el.attr('type'),
            eType;

        switch(type) {
          case 'button':
            eType = 'click';
          break;

          case 'checkbox':
            eType = 'change';
          break;
        }

        $el.on(eType, function() {
          if (type === 'button') {
            $el.toggleClass('selected');
          }

          update();
        });
      });

      _elements.controlToggle.click(function() {
        _events.toggleControls();
      });

      _elements.closeDetailButton.live('click', function() {
        if ($scope.Helpers.isFunction($scope.currentSlider.destroySlider)) {
          $scope.currentSlider.destroySlider();
        }

        if (_elements.showListingButton.hasClass('active') === false) {
          _elements.interactionContent.css({
            height: 'auto'
          });
        }

        $('.js-listing-carousel').hide();
        $('.js-ddp-live-detail-container').remove();
      });

      _elements.showListingButton.click(function() {
        var $el = $(this);
        var text = $el.find('.js-toggle-label');

        if (! $el.hasClass('active')) {
          _View.showListings();

          $el.addClass('active');
          text.text('Hide');

          _elements.interactionContent.css({
            height: '100%'
          });
        } else {

           _elements.interactionContent.css({
            height: 'auto'
          });

          _View.removeListings();
          $el.removeClass('active');
          text.text('Show');
        }
      });

      _elements.getDetailButton.live('click', function(event) {
        event.preventDefault();
        var $el = $(this);
        var id = $el.attr('data-ddp-live-id');

       _View.listingDetail({
          propertyId: id,
          $container: _elements.interactionContent
       });
      });
    };

    _events.toggleControls = function(args) {
      args = args || {};
      args = $.extend({
        state: 'toggle'
      }, args);

      var $el = _elements.controlToggle;

      if ($el.hasClass('closed') === false && args.state !== 'open') {
        _elements.controlToggleLabel.html('Show');
        $el.addClass('closed');
        $el.parent().addClass('closed');
      } else {
        _elements.controlToggleLabel.html('Hide');
        $el.removeClass('closed');
        $el.parent().removeClass('closed');
      }
    };

    var update = function() {
      if ($scope.debug) {
        console.log('Update triggered');
      }

      var $mask = $scope.mask;
      $mask.prependTo(_View.$listingContent);

      var properties = filterProperties();
      _config.onUpdate(properties);

      _View.loadListings({
        $mask: $mask,
        properties: _currentProperties,
        onComplete: function() {
          _View.addProperties(properties);
        }
      });
    };

    var filterProperties = function() {
      var properties = [];
      var filters = {};
      var types = [];
      var rooms = [];

      _elements.filterValues.each(function() {
        var $el = $(this);
        var elType = $el.attr('type');
        var dataType = $el.attr('data-ddp-live-data-type');
        var value;

        if (elType === 'button') {
          value = $el.attr('data-ddp-live-button-value');

          if ($el.hasClass('selected')) {
            rooms.push(value);
          }
        } else {
          value = $el.val();
            if (dataType === 'type' && $el.is(':checked')) {
            types.push(value);
          } else {
            filters[dataType] = value;
          }
        }
      });

      /**
       * Harded coded this to rentals only because there is no data source for
       * the for sale homes. We removed the filter selection.
       */
      // filters.type = types;
      filters.type = 'rent';

      filters.rooms = rooms;

      if ($scope.debug) {
        console.log('Filters: ');
        console.log(filters);
      }

      var listingBedrooms = function(property, rooms) {
        var skip = true;
        rooms.sort();

        if (rooms.length !== 0) {
          $.each(property.rent.listings, function(i, listing) {
            // Must be a string for compare
            listing.bedrooms = String(listing.bedrooms);

            if ($.inArray(listing.bedrooms, rooms) >= 0 ||
                (rooms[(rooms.length - 1)] === 3 &&
                  listing.bedrooms >= rooms[(rooms.length - 1)])) {

              skip = false;
              return false;
            }
          });
        } else {
          skip = false;
        }

        return skip;
      };

      var listingPriceBetween = function(property) {
        var rentPriceBetween = false;

        $.each(property.rent.listings, function(i, listing) {
          if ($scope.Helpers.intBetween(
            listing.priceLow,
            filters['min-'+prop.type],
            filters['max-'+prop.type]) &&
            $scope.Helpers.intBetween(
            listing.priceHigh,
            filters['min-'+prop.type],
            filters['max-'+prop.type])) {
              rentPriceBetween = true;
              return false;
          }
        });

        return rentPriceBetween;
      };

      for (var i = 0; i < _properties.properties.length; i++) {
        var prop = _properties.properties[i];

        if (filters.type.indexOf(prop.type) < 0 ) {
          continue;
        }

        if (prop.type === 'sale') {

          if ($scope.Helpers.intBetween(
            prop.sale.price,
            filters['min-'+prop.type],
            filters['max-'+prop.type]) === false) {
            continue;
          }
        }

        if (prop.type === 'rent') {
          var propHasPrice = listingPriceBetween(prop);

          if (propHasPrice === false) {
            continue;
          }
        }

        if (filters.type.indexOf('available') > 0 &&
            prop.type === 'rent' &&
            prop.availability === false) {
          continue;
        }

        if (prop.type === 'rent') {
          if (listingBedrooms(prop, filters.rooms)) {
            continue;
          }
        }

        properties.push(prop);
      }

      _config.onFilter(properties, filters);
      _currentProperties = properties;


      return properties;
    };

    $this.init();

    return $this;
  };


  $scope.App({
    debug: true
  });

})(jQuery, window, window.google);