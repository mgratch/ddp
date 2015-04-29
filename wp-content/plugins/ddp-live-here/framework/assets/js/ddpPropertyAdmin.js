;(function($, window) {
  'use strict';

  var MetaGeocode = function(args) {
    var $this = this;
    var _private = {};
    var _elements = {};
    var geocoder = new window.google.maps.Geocoder();

    var _args = args || {};
    _args = $.extend({
      loaderSelector: false,
      metaBoxSelector: false
    }, args);

    $this.init = function() {

      if (_args.metaBoxSelector === false) {
        console.warn('MetaGeocode metaBoxSelector attribute missing');
        return false;
      }

      _private.cacheElements();
      _private.bindActions();

      return $this;
    };

    _private.bindActions = function() {
      _elements.$geocodeButton.click(function() {
        var address = _private.getAddress();

        if (address.errors === false) {
          $this.clearErrors();
          _private.loader.activate();

          $this.getGeocode({
            address: address.address,
            onSuccess: function(response) {
              _elements.$latitudeField.val(response.geocodes.k);
              _elements.$longitudeField.val(response.geocodes.D);
              _private.loader.deactivate();
            },
            onError: function(response) {
              _private.loader.deactivate();
              window.alert(response);
            }
          });
        }
      });

    };

    _private.loader = {
      activate: function() {
        if (_args.loaderSelector) {
          $(_args.loaderSelector).show();
        }
      },

      deactivate: function() {
        if (_args.loaderSelector) {
          $(_args.loaderSelector).hide();
        }
      }
    };

    _private.getAddress = function() {
      var address = [];
      var withErrors = false;

      $.each(_elements.address, function(index, value) {
        if (value.val().length < 1) {
          $this.fieldError({
            $el: value,
            message: 'Field is required for geocode'
          });

          withErrors = true;
        } else {
          address.push(value.val());
        }
      });

      return {
        errors: withErrors,
        address: address.join(' ')
      };
    };

    _private.cacheElements = function() {
      _elements.$metaBox = $(_args.metaBoxSelector);
      _elements.$geocodeButton = _elements.$metaBox.find('[data-action="getGeocodes"]');
      _elements.address = {
        $address: _elements.$metaBox.find('[data-field-type="address"]'),
        $city: _elements.$metaBox.find('[data-field-type="city"]'),
        $state: _elements.$metaBox.find('[data-field-type="state"]'),
        $zip: _elements.$metaBox.find('[data-field-type="zip"]')
      };
      _elements.$latitudeField = _elements.$metaBox.find('[data-field-type="latitude"]');
      _elements.$longitudeField = _elements.$metaBox.find('[data-field-type="longitude"]');

    };

    $this.getGeocode = function(args) {
      args = args || {};
      args = $.extend({
        address: false,
        onSuccess: function() {},
        onError: function() {}
      }, args);

      if (args.address === false) {
        args.onError({
          status: 'Address is required and expected to be a string'
        });

        return false;
      }

      geocoder.geocode({ 'address': args.address}, function(results, status) {
        if (status === window.google.maps.GeocoderStatus.OK) {
          args.onSuccess({
            status: status,
            geocodes: results[0].geometry.location
          });
        } else {
          args.onError({
            status: status
          });
        }
      });
    };

    $this.fieldError = function(args) {
      args = args || {};
      args = $.extend({
        $el: false,
        message: false
      }, args);

      $('<div class="input-error" style="color:red;">'+args.message+'</div>')
        .appendTo(args.$el.parent());

    };

    $this.clearErrors = function() {
      $('.input-error').remove();
    };

    return $this.init();
  };


  // Export
  window.MetaGeocode = MetaGeocode;

})(jQuery, window);
;(function($, window) {
  'use strict';

  var ddpPropertyAdmin = function(args) {
    args = args || {};
    var $this = this;
    var _elements = {};
    var _private = {};
    var _events = {};
    // var _args = $.extend({

    // }, args);

    $this.init = function() {
      _private.cacheElements();
      _private.bindEvents();

      // Fire select changes on load
      _elements.$typeSelect.change();

      return $this;
    };

    _private.cacheElements = function() {
      _elements.$typeSelect = $('[data-js="typeSelect"]');
      _elements.$rentAtributes = $('#rent-attributes');
      _elements.$saleAtributes = $('#sale-attributes');
    };

    _private.bindEvents = function() {
      _elements.$typeSelect.change(function() {
        var $el = $(this);
        _events.typeSelect($el);
      });
    };

    _events.typeSelect = function($el) {
      var value = $el.val();

      // Hide all boxes
      _elements.$rentAtributes.hide();
      _elements.$saleAtributes.hide();

      // Show correct boxes
      if (value === 'rent') {
        _elements.$rentAtributes.show();
      }

      if (value === 'sale') {
        _elements.$saleAtributes.show();
      }

      return value;
    };

    $this.init();
  };

  // Export
  window.ddpPropertyAdmin = ddpPropertyAdmin;
})(jQuery, window);

// Init
jQuery(function() {
  'use strict';

  new window.MetaGeocode({
    loaderSelector: '.js-property-admin-loader',
    metaBoxSelector: '#property-attributes'
  });

  new window.ddpPropertyAdmin();
});