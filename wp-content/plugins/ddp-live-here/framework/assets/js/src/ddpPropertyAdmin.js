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