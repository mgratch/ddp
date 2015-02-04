( function($) {
  new GMaps({
    div: '#map',
    lat: -12.043333,
    lng: -77.028333,
    scrollwheel: false
  });


  $('.js-range-slider').slider({
    range: true,
    min: 0,
    max: 500,
    values: [ 0, 500 ],
    slide: function( event, ui ) {
      var el = $(this);
      var values = ui.values;
      var group = el.parents('.js-range-group');
      group.find('.js-min-value').val(values[0]);
      group.find('.js-max-value').val(values[1]);
    }
  });
})(jQuery);