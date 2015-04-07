;(function($, window) {
  'use strict';

  window.PropertyAdmin = function(args) {
    var $this = this;
    var _private = {};
    var _el = {};
    var geocoder = new window.google.maps.Geocoder();

    var _args = args || {};
    _args = $.extend({
      loaderSelector: false
    }, args);

    $this.init = function() {
      _private.cacheElements();
      _private.bindActions();
      return $this;
    };

    _private.bindActions = function() {
      _el.$geocodeButton.click(function() {
        var address = _private.getAddress();

        if (address.errors === false) {
          $this.clearErrors();
          _private.loader.activate();

          $this.getGeocode({
            address: address.address,
            onSuccess: function(response) {
              _el.$latitudeField.val(response.geocodes.k);
              _el.$longitudeField.val(response.geocodes.D);
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

      $.each(_el.address, function(index, value) {
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
      _el.$geocodeButton = $('[data-action="getGeocodes"]');
      _el.address = {
        $address: $('[data-field-type="address"]'),
        $city: $('[data-field-type="city"]'),
        $state: $('[data-field-type="state"]'),
        $zip: $('[data-field-type="zip"]')
      };
      _el.$latitudeField = $('[data-field-type="latitude"]');
      _el.$longitudeField = $('[data-field-type="longitude"]');

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

  $(function() {
    new window.PropertyAdmin({
      loaderSelector: '.js-property-admin-loader'
    });
  });
})(jQuery, window);