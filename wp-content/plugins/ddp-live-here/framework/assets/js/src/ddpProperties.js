;( function($) {

  var $scope = {};

  $scope.mapPins = {
    pin: "M12.113 1C5.976 1 1 6 1 12.113c0 6.2 7.9 17 11.1 23.321c3.18-6.451 11.139-17.449 11.139-23.321 C23.227 6 18.3 1 12.1 1z M12.113 15.679c-1.834 0-3.321-1.487-3.321-3.321s1.487-3.321 3.321-3.321 s3.321 1.5 3.3 3.321S13.947 15.7 12.1 15.679z, M12.113 1c6.138 0 11.1 5 11.1 11.113c0 5.873-7.959 16.87-11.139 23.3 C8.875 29.1 1 18.3 1 12.113C1 6 6 1 12.1 1 M12.113 15.679c1.834 0 3.321-1.487 3.321-3.321 s-1.487-3.321-3.321-3.321s-3.321 1.487-3.321 3.321S10.279 15.7 12.1 15.7 M12.113 0C5.434 0 0 5.4 0 12.1 c0 4.7 4.1 11.5 7.7 17.579c1.354 2.3 2.6 4.4 3.5 6.193l0.904 1.788l0.886-1.797 c0.932-1.891 2.299-4.208 3.747-6.662c3.513-5.957 7.495-12.708 7.495-17.102C24.227 5.4 18.8 0 12.1 0L12.113 0z M12.113 14.679c-1.28 0-2.321-1.041-2.321-2.321s1.042-2.321 2.321-2.321c1.28 0 2.3 1 2.3 2.3 S13.394 14.7 12.1 14.679L12.113 14.679z",

    buy: "#d65b91",

    rent: "#369abd"
  };

  var $helpers = {
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
    }
  };

  var ddpLiveModel = function() {
    var $this = this;
    $this.public = {};
    $this.ajaxUrl = ddpProperties_obj.ajax_url;
    $this.ajaxKey = ddpProperties_obj.key;

    $this.public.getProperties = function(args)
    {
      args = $.extend({
        complete: false,
        filters: false
      }, args);

      var data = {
        action: 'ddpLiveGetProperties',
        key: $this.ajaxKey,
        filters: args.filters
      };

      $.get($this.ajaxUrl, data, function(response) {
        response = $.parseJSON(response);

        if ($scope.debug) {
          console.log("Properties ajax:");
          console.log(response);
        }

        if (args.complete) args.complete(response);
      });
    };

    return $this.public;
  };

  $.ddpLive = function (config)
  {
    var $this = this;
    $this.public = {};
    $this.model = ddpLiveModel();
    $this.properties = false;
    $this.config = $.extend({
      debug: false
    }, config);

    $scope.debug = $this.config.debug;

    $this.init = function()
    {
      $this.cacheElements();
      $this.bindEvents();

      $this.model.getProperties({
        complete: function(response) {
          $this.drawMap();

          if (response) {
            $this.properties = response;
            $this.registerSliders();
            $this.update();
          } else {
            $this.noResults();
          }
        }
      });

      return $this.public;
    };

    $this.cacheElements = function()
    {
      $this.el = {};
      $this.el.container = $('.js-live-here');
      $this.el.filters = $this.el.container.find('.js-live-here-filters');
      $this.el.sliders = $this.el.container.find('.js-range-slider');
    };

    $this.registerSliders = function()
    {
      $this.el.sliders.each(function() {
        var $el = $(this),
            type = $el.attr('data-type'),
            ranges = $this.properties.ranges,
            min = parseInt(ranges[type]['min']),
            max = parseInt(ranges[type]['max']);

        if (!min) min = 0;
        if (!max) max = 0;

        var updateValues = function(minVal, maxVal) {
          minVal = numeral(minVal).format('0,0');
          maxVal = numeral(maxVal).format('0,0');

          var $group = $el.parents('.js-range-group');

          $group.find('.js-min-value').val(minVal);
          $group.find('.js-max-value').val(maxVal);
          $group.find('.js-min-value-display').text(minVal);
          $group.find('.js-max-value-display').text(maxVal);
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
          stop: function(event, ui) {
            $this.update();
          }
        });
      });
    };

    $this.bindEvents = function()
    {

    };

    $this.update = function()
    {
      if ($scope.debug) {
        console.log("Update triggered");
      }

      var properties = $this.filterProperties();
      $this.addProperties(properties);
    };

    $this.filterProperties = function()
    {
      return $this.properties.properties;
    };

    $this.drawMap = function()
    {

      $this.public.map = new GMaps({
        div: '#map',
        lat: 42.331427,
        lng: -83.045754,
        scrollwheel: false
      });

      //$this.public.map.panBy(($(window).width() / 3) * (-1), 0);
    };

    $this.addProperties = function(properties)
    {

      if (properties) {
        var bounds = [];
        for (var i = 0; i < properties.length; i++) {
          if ($helpers.exists(properties[i].latitude) && $helpers.exists(properties[i].longitude)) {
            bounds.push(new google.maps.LatLng(properties[i].latitude, properties[i].longitude));

            $this.public.map.addMarker({
              lat: properties[i].latitude,
              lng: properties[i].longitude,
              title: properties[i].title,
              icon: {
                path: $scope.mapPins.pin,
                fillColor: $scope.mapPins[properties[i].type],
                fillOpacity: 1,
                strokeColor: "#ffffff",
                scale: 1,

              },
              infoWindow: {
                content: 'this.content'
              }
            });
          }
        }

        $this.public.map.fitLatLngBounds(bounds);
        $this.public.map.panBy(($(window).width() / 3) * (-1), 0);
      }
    };

    $this.noResults = function()
    {

    };

    $this.showListings = function()
    {

    };

    return $this.init();
  };

  $.ddpLive({
    debug: true
  });

})(jQuery);