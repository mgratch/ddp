;( function($) {

  var $scope = {};

  // Checks for null
  function exists(check) {
    if (check === null) {
      return false;
    }

    return true;
  }

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
          if (response) {
            $this.properties = response;
            $this.registerSliders();
          } else {
            $this.noResults();
          }

          $this.update();
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

        if (!min && !max) {
          min = 0;
          max = 0;
        }

        var updateValues = function(minVal, maxVal) {
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
          min: 0,
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
      $this.drawMap(properties);
    };

    $this.filterProperties = function()
    {
      return $this.properties.properties;
    };

    $this.drawMap = function(properties)
    {
      var map = new GMaps({
        div: '#map',
        lat: 42.331427,
        lng: -83.045754,
        scrollwheel: false
      });

      if (properties) {
        for (var i = 0; i < properties.length; i++) {
          if (exists(properties[i].latitude) && exists(properties[i].longitude)) {
            map.addMarker({
              lat: properties[i].latitude,
              lng: properties[i].longitude,
              title: properties[i].title
            });
          }
        }
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