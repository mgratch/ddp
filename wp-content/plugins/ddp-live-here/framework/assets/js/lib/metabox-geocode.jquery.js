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
              var codes = [];
              $.each(response.geocodes, function(i, val) {
                codes.push(val);
              });
              _elements.$latitudeField.val(codes[0]);
              _elements.$longitudeField.val(codes[1]);
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