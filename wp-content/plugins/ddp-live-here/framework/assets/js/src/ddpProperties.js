/**
 * TODO
 *
 * Debounce filter firing.
 * Recenter map on window resize and debounce.
 * Filtering function could use some refining.
 */

;( function($, window) {
  'use strict';

  var GMaps = window.GMaps;

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
      if (test >= min && test <= max) {
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
    $this.map = null;

    var init = function() {
      // Cache Elements
      _elements.listingContainer = $('.js-ddp-live-listing-container');
      _elements.listingContent = _elements.listingContainer.find('.js-listing-content');
      $this.$listingContent = _elements.listingContent;
    };

    $this.renderMap = function() {

      $this.map = new GMaps({
        div: '#map',
        lat: 42.331427,
        lng: -83.045754,
        scrollwheel: false,
        zoom: 14
      });

      $this.map.panBy(($(window).width() / 3) * (-1), 0);

      if (_hoodRendered === false) {
        $this.addHoods();
      }
     };

    $this.addProperties = function(properties) {
      if (properties) {
        $this.map.removeMarkers();

        var domCheck = setTimeout(function() {
          if ($('.listing-item').length) {
            for (var i = 0; i < properties.length; i++) {
              if ($scope.Helpers.exists(properties[i].latitude) && $scope.Helpers.exists(properties[i].longitude)) {

                $this.map.addMarker({
                  lat: properties[i].latitude,
                  lng: properties[i].longitude,
                  title: properties[i].title,
                  //animation: window.google.maps.Animation.DROP,
                  icon: {
                    path: $scope.mapPins.pin,
                    fillColor: $scope.mapPins[properties[i].type],
                    fillOpacity: 1,
                    strokeColor: '#ffffff',
                    strokeWeight: 1,
                    scale: 1,
                    anchor: {x: 24, y: 38}
                  },
                  infoWindow: {
                    content: '<div class="ddp-live-info-window">' + $('[data-ddp-live-id="'+properties[i].id+'"]').html() + '</div>'
                  }
                });
              }
            }

            clearInterval(domCheck);
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
          auto         : true,
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

    $this.addHoods = function() {
      console.log('called');

      // Load hoods file
      $.getJSON(window.ddpPropertiesObj.assetUri+'/data/hoods.json', function(data) {
        data = data.features;
        var i = 0;
        for (i; i < data.length; i++) {
          var item = data[i];

            var coords = [];
            $.each(item.geometry.coordinates[0], function(index, value) {
              coords.push(new window.google.maps.LatLng(value[1], value[0]));
            });

            var zz = $this.map.drawPolygon({
              paths: coords, // pre-defined polygon shape
              strokeColor: '#FF0000',
              strokeOpacity: 1,
              strokeWeight: 3,
              fillColor: '#FF0000',
              fillOpacity: 0.6
            });

            console.log(zz);
          }
      });

      _hoodRendered = true;
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

      _elements.closeDetailButton.live('click', function() {
        if ($scope.Helpers.isFunction($scope.currentSlider.destroySlider)) {
          $scope.currentSlider.destroySlider();
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
        } else {
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

      filters.type = types;
      filters.rooms = rooms;

      if ($scope.debug) {
        console.log('Filters: ');
        console.log(filters);
      }

      var listingPriceBetween = function(property) {
        var rentPriceBetween = false;

        $.each(property.rent.listings, function(i, listing) {
          if ($scope.Helpers.intBetween(
            listing.priceLow,
            filters['min-'+prop.type],
            filters['max-'+prop.type]) ||
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
            filters['max-'+prop.type])) {
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
    debug: false
  });

})(jQuery, window);