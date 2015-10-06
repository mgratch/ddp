( function($) {
  /**
   * Resets the field values and updates the name index
   * @param  {object} el The cloned element
   * @param  {int} total The current total of cloned fields
   * @return void
   */
  $.fn.clear_fields = function() {

    el = $(this);

    el.find('input, textarea').each(function() {
      if( $(this).data('keep') === undefined ) {
        $(this).val('');
        $(this).removeAttr('checked');
      }
    });

    var select = el.find('select');
    var selected_default;
    var key = 0;

    select.each(function() {
      if( $(this).data('keep') !== undefined ) {
         $(this).children().each(function() {
          if( $(this).data('default-select') != undefined ) {
            selected_default = key;
          }
          key++;
        });
      }
    });

    if( $(selected_default).length ) {
      $(select).prop('selectedIndex', selected_default);
    } else {
      $(select).prop('selectedIndex', 0);
    }

    el.find('select[multiple="multiple"]').each(function() {
      $(this).children().each(function() {
        $(this).removeAttr('selected');
      });
    });
  };
})(jQuery);