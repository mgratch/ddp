;( function($, window) {

  var $_scope = {
    ajaxUrl: ddpProperties_obj.ajax_url,
    ajaxKey: ddpProperties_obj.key
  };

  $_scope.mapPins = {
    pin: "M12.113 1C5.976 1 1 6 1 12.113c0 6.2 7.9 17 11.1 23.321c3.18-6.451 11.139-17.449 11.139-23.321 C23.227 6 18.3 1 12.1 1z M12.113 15.679c-1.834 0-3.321-1.487-3.321-3.321s1.487-3.321 3.321-3.321 s3.321 1.5 3.3 3.321S13.947 15.7 12.1 15.679z, M12.113 1c6.138 0 11.1 5 11.1 11.113c0 5.873-7.959 16.87-11.139 23.3 C8.875 29.1 1 18.3 1 12.113C1 6 6 1 12.1 1 M12.113 15.679c1.834 0 3.321-1.487 3.321-3.321 s-1.487-3.321-3.321-3.321s-3.321 1.487-3.321 3.321S10.279 15.7 12.1 15.7 M12.113 0C5.434 0 0 5.4 0 12.1 c0 4.7 4.1 11.5 7.7 17.579c1.354 2.3 2.6 4.4 3.5 6.193l0.904 1.788l0.886-1.797 c0.932-1.891 2.299-4.208 3.747-6.662c3.513-5.957 7.495-12.708 7.495-17.102C24.227 5.4 18.8 0 12.1 0L12.113 0z M12.113 14.679c-1.28 0-2.321-1.041-2.321-2.321s1.042-2.321 2.321-2.321c1.28 0 2.3 1 2.3 2.3 S13.394 14.7 12.1 14.679L12.113 14.679z",

    buy: "#d65b91",

    rent: "#369abd"
  };

  $_scope.Helpers = {
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

  var Base64 = {_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}};

  $_scope.Model = function() {
    var $_this = this;

    $_this.getProperties = function(args) {
      args = $.extend({
        complete: false,
        filters: false
      }, args);

      var data = {
        action: 'ddpLiveGetProperties',
        key: $_scope.ajaxKey,
        filters: args.filters
      };

      $.get($_scope.ajaxUrl, data, function(response) {
        response = $.parseJSON(response);

        if ($_scope.debug) {
          console.log("Properties ajax:");
          console.log(response);
        }

        if (args.complete) args.complete(response);
      });
    };

    return $_this;
  };

  $_scope.View = function() {
    var $_this = this;
    var _el = {};
    $_this.map = null;

    var init = function() {
      // Cache elements
      _el.listingContainer = $('.js-ddp-live-listing-container');
    };

    $_this.renderMap = function() {
      $_this.map = new GMaps({
        div: '#map',
        lat: 42.331427,
        lng: -83.045754,
        scrollwheel: false,
        zoom: 14
      });

      $_this.map.panBy(($(window).width() / 3) * (-1), 0);
     };

    $_this.addProperties = function(properties) {
      if (properties) {
        $_this.map.removeMarkers();

        for (var i = 0; i < properties.length; i++) {
          if ($_scope.Helpers.exists(properties[i].latitude) && $_scope.Helpers.exists(properties[i].longitude)) {

            $_this.map.addMarker({
              lat: properties[i].latitude,
              lng: properties[i].longitude,
              title: properties[i].title,
              animation: google.maps.Animation.DROP,
              icon: {
                path: $_scope.mapPins.pin,
                fillColor: $_scope.mapPins[properties[i].type],
                fillOpacity: 1,
                strokeColor: "#ffffff",
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

    $_this.showListings = function(atts) {
      atts = atts || {};
      atts = $.extend({
        container: _el.listingContainer,
        properties: false,
        onComplete: function() {}
      }, atts);

      if (! atts.properties) return false;
      if (! atts.container) return false;

      var data = {
        action: 'ddpPropertyListing',
        key: $_scope.ajaxKey,
        properties: atts.properties
      };

      $.get($_scope.ajaxUrl, data, function(response) {
        response = $.parseJSON(response);

        $(Base64.decode(response.html)).appendTo(atts.container);
        atts.onComplete();
      });
    };

    $_this.removeListings = function() {
      _el.listingContainer.html('');
    };

    init();
    return $_this;
  };

  $_scope.App = function (config) {
    var $_this = this;
    var _Model = $_scope.Model();
    var _View = $_scope.View();
    var _properties = false;
    var _currentProperties = {};
    var _el = {};
    $_this.filters = {};
    var _config = $.extend({
      debug: false,
      onUpdate: function(properties) {},
      onFilter: function(properties, filters){}
    }, config);

    $_scope.debug = _config.debug;

    $_this.init = function() {
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
            $_scope.View.noResults();
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
    };

    var registerSliders = function() {
      _el.sliders.each(function() {
        var $el = $(this),
            type = $el.attr('data-type'),
            ranges = _properties.ranges,
            min = parseInt(ranges[type]['min']),
            max = parseInt(ranges[type]['max']);

        if (!min) min = 0;
        if (!max) max = 0;

        var updateValues = function(minVal, maxVal) {

          var $group = $el.parents('.js-range-group');

          $group.find('.js-min-value').val(minVal);
          $group.find('.js-max-value').val(maxVal);
          $group.find('.js-min-value-display').text(numeral(minVal).format('0,0'));
          $group.find('.js-max-value-display').text(numeral(maxVal).format('0,0'));
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

      _el.showListingButton.click(function() {
        $el = $(this);
        var text = $el.find('.js-toggle-label');

        if (! $el.hasClass('active')) {
          _View.showListings({
            properties: _currentProperties
          });

          $el.addClass('active');
          text.text('Hide');
        } else {
          _View.removeListings();
          $el.removeClass('active');
          text.text('Show');
        }
      });
    };

    var update = function() {
      if ($_scope.debug) {
        console.log("Update triggered");
      }

      var properties = filterProperties();
      _config.onUpdate(properties);

      _View.addProperties(properties);
    };

    var filterProperties = function() {
      var properties = [];
      var filters = {};
      var types = [];
      var rooms = [];

      _el.filterValues.each(function() {
        var $el = $(this);
        var elType = $el.attr('type');
        var dataType = $el.attr('data-ddp-live-data-type');
        var value;
        var i;

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

      if ($_scope.debug) {
        console.log('Filters: ');
        console.log(filters);
      }

      for (i=0; i < _properties.properties.length; i++) {
        var prop = _properties.properties[i];

        if (filters.type.indexOf(prop.type) < 0 ) {
          continue;
        }

        if (! $_scope.Helpers.intBetween(
          prop.price,
          filters['min-'+prop.type],
          filters['max-'+prop.type])) {
          continue;
        }

        if (! $_scope.Helpers.intBetween(
          prop.sq_footage,
          filters['min-sq-ft'],
          filters['max-sq-ft'])) {
          continue;
        }

        if (filters.rooms.indexOf(prop.rooms) < 0 ) {
          var continueable = true;
          if (filters.rooms.indexOf("6") >= 0 && Number(prop.rooms) > 6) {
            continueable = false;
          }

          if (continueable) continue;
        }


        properties.push(_properties.properties[i]);
      }

      _config.onFilter(properties, filters);
      _currentProperties = properties;

      return properties;
    };

    var noResults = function() {

    };

    var showListings = function() {

    };

    $_this.init();

    return $_this;
  };

  $_scope.App({
    debug: true
  });

})(jQuery, window);