/**
 * TODO
 *
 * Debounce filter firing.
 * Recenter map on window resize and debounce.
 */

;( function($, window) {
  'use strict';

  var GMaps = window.GMaps;

  var $scope = {
    ajaxUrl: window.ddpPropertiesObj.ajaxUrl,
    ajaxKey: window.ddpPropertiesObj.key
  };

  $scope.mapPins = {
    pin: 'M12.113 1C5.976 1 1 6 1 12.113c0 6.2 7.9 17 11.1 23.321c3.18-6.451 11.139-17.449 11.139-23.321 C23.227 6 18.3 1 12.1 1z M12.113 15.679c-1.834 0-3.321-1.487-3.321-3.321s1.487-3.321 3.321-3.321 s3.321 1.5 3.3 3.321S13.947 15.7 12.1 15.679z, M12.113 1c6.138 0 11.1 5 11.1 11.113c0 5.873-7.959 16.87-11.139 23.3 C8.875 29.1 1 18.3 1 12.113C1 6 6 1 12.1 1 M12.113 15.679c1.834 0 3.321-1.487 3.321-3.321 s-1.487-3.321-3.321-3.321s-3.321 1.487-3.321 3.321S10.279 15.7 12.1 15.7 M12.113 0C5.434 0 0 5.4 0 12.1 c0 4.7 4.1 11.5 7.7 17.579c1.354 2.3 2.6 4.4 3.5 6.193l0.904 1.788l0.886-1.797 c0.932-1.891 2.299-4.208 3.747-6.662c3.513-5.957 7.495-12.708 7.495-17.102C24.227 5.4 18.8 0 12.1 0L12.113 0z M12.113 14.679c-1.28 0-2.321-1.041-2.321-2.321s1.042-2.321 2.321-2.321c1.28 0 2.3 1 2.3 2.3 S13.394 14.7 12.1 14.679L12.113 14.679z',

    buy: '#d65b91',

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
    var _el = {};
    var _hoodRendered = false;
    $this.map = null;

    var init = function() {
      // Cache Elements
      _el.listingContainer = $('.js-ddp-live-listing-container');
      _el.listingContent = _el.listingContainer.find('.js-listing-content');
      $this.$listingContent = _el.listingContent;
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
        // $this.addHoods();
      }
     };

    $this.addProperties = function(properties) {
      if (properties) {
        $this.map.removeMarkers();

        for (var i = 0; i < properties.length; i++) {
          if ($scope.Helpers.exists(properties[i].latitude) && $scope.Helpers.exists(properties[i].longitude)) {

            $this.map.addMarker({
              lat: properties[i].latitude,
              lng: properties[i].longitude,
              title: properties[i].title,
              animation: window.google.maps.Animation.DROP,
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
                content: 'this.content'
              }
            });
          }
        }
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

        atts.onComplete($html, data.propertyId);
      });
    };

    // $this.addHoods = function() {
    //   console.log('called');

    //   // Load hoods file
    //   $.getJSON(window.ddpPropertiesObj.assetUri+'/data/hoods.json', function(data) {
    //     data = data.features;
    //     var i = 0;
    //     for (i; i < data.length; i++) {
    //       var item = data[i];

    //       if (item.properties.COUNTY.toLowerCase() === 'wayne') {
    //         var coords = [];
    //         $.each(item.geometry.coordinates[0], function(index, value) {
    //           coords.push(new window.gogle.maps.LatLng(value[1], value[0]));
    //         });

    //         $this.map.drawPolygon({
    //           paths: coords, // pre-defined polygon shape
    //           strokeColor: '#FF0000',
    //           strokeOpacity: 1,
    //           strokeWeight: 3,
    //           fillColor: '#FF0000',
    //           fillOpacity: 0.6
    //         });
    //       }
    //     }
    //   });

    //   _hoodRendered = true;
    // };

    $this.loadListings = function(atts) {
      atts = atts || {};
      atts = $.extend({
        properties: false,
        $mask: false,
        onComplete: function() {}
      }, atts);

      if (! atts.properties) return false;

      var data = {
        action: 'ddpPropertyListing',
        key: $scope.ajaxKey,
        properties: atts.properties
      };

      $.get($scope.ajaxUrl, data, function(response) {
        response = $.parseJSON(response);

        atts.$mask.animate({
          opacity: 1
        }, 600, function() {
          _el.listingContent.html(window.Base64.decode(response.html));

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
      _el.listingContainer.show();
    };

    $this.removeListings = function() {
      _el.listingContainer.hide();
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
    var _el = {};
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
      _el.container = $('.js-live-here');
      _el.filters = _el.container.find('.js-live-here-filters');
      _el.sliders = _el.container.find('.js-range-slider');
      _el.triggers = _el.container.find('.js-ddp-live-trigger-update');
      _el.filterValues = _el.container.find('.js-ddp-live-filter-value');
      _el.showListingButton = _el.container.find('.js-show-listings');
      _el.getDetailButton = _el.container.find('.js-ddp-live-get-detail');
      _el.interactionContent = _el.container.find('.js-interaction-content');
      _el.closeDetailButton = _el.container.find('.js-close-detail');
    };

    var registerSliders = function() {
      _el.sliders.each(function() {
        var $el = $(this),
            type = $el.attr('data-type'),
            ranges = _properties.ranges,
            min = parseInt(ranges[type].min),
            max = parseInt(ranges[type].max);

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
      _el.triggers.each(function() {
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

      _el.closeDetailButton.live('click', function() {
        $('.js-ddp-live-detail-container').remove();
      });

      _el.showListingButton.click(function() {
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

      _el.getDetailButton.live('click', function(event) {
        event.preventDefault();
        var $el = $(this);
        var id = $el.attr('data-ddp-live-id');

       _View.listingDetail({
          propertyId: id,
          $container: _el.interactionContent
       });
      });
    };

    var update = function() {
      if ($scope.debug) {
        console.log('Update triggered');
      }

      var $mask = $scope.mask;
      $mask.prependTo(_View.$listingContent);

      // var properties = filterProperties();
      // _config.onUpdate(properties);

      var properties = _properties.properties;
      _currentProperties = properties;

      _View.addProperties(properties);
      _View.loadListings({
        $mask: $mask,
        properties: _currentProperties
      });
    };

    // var filterProperties = function() {
    //   var properties = [];
    //   var filters = {};
    //   var types = [];
    //   var rooms = [];

    //   _el.filterValues.each(function() {
    //     var $el = $(this);
    //     var elType = $el.attr('type');
    //     var dataType = $el.attr('data-ddp-live-data-type');
    //     var value;

    //     if (elType === 'button') {
    //       value = $el.attr('data-ddp-live-button-value');

    //       if ($el.hasClass('selected')) {
    //         rooms.push(value);
    //       }
    //     } else {
    //       value = $el.val();
    //         if (dataType === 'type' && $el.is(':checked')) {
    //         types.push(value);
    //       } else {
    //         filters[dataType] = value;
    //       }
    //     }
    //   });

    //   filters.type = types;
    //   filters.rooms = rooms;

    //   if ($scope.debug) {
    //     console.log('Filters: ');
    //     console.log(filters);
    //   }

    //   for (var i = 0; i < _properties.properties.length; i++) {
    //     var prop = _properties.properties[i];

    //     if (filters.type.indexOf(prop.type) < 0 ) {
    //       continue;
    //     }

    //     if (! $scope.Helpers.intBetween(
    //       prop.price,
    //       filters['min-'+prop.type],
    //       filters['max-'+prop.type])) {
    //       continue;
    //     }

    //     if (! $scope.Helpers.intBetween(
    //       prop.sqFootage,
    //       filters['min-sq-ft'],
    //       filters['max-sq-ft'])) {
    //       continue;
    //     }

    //     if (filters.rooms.indexOf(prop.rooms) < 0 ) {
    //       var continueable = true;
    //       if (filters.rooms.indexOf('6') >= 0 && Number(prop.rooms) > 6) {
    //         continueable = false;
    //       }

    //       if (continueable) continue;
    //     }


    //     properties.push(_properties.properties[i]);
    //   }

    //   _config.onFilter(properties, filters);
    //   _currentProperties = properties;

    //   return properties;
    // };

    $this.init();

    return $this;
  };

  $scope.App({
    debug: false
  });

})(jQuery, window);