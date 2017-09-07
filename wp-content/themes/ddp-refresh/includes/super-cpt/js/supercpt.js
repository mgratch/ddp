jQuery( function( $ ){

	/**
   * Resets the field values and updates the name index
   * @param  {object} el The cloned element
   * @param  {int} total The current total of cloned fields
   * @return void
   */
  function reset_fields( el, total ) {

    el.find('input, textarea').each(function() {
      $(this).val('');
    });

    el.find('.scpt-media-preview').html('');
    el.find('.scpt-remove-thumbnail').remove();
    el.find('.scpt-add-media').show();
    el.find('.scpt-media-id').val('');

    el.find('input').removeAttr('checked');

    var select = el.find('select');
    var selected_default;
    var key = 0;
    select.children().each(function() {
      if( $(this).data('default-select') != undefined ) {
        selected_default = key;
      }
      key++;
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

    // reset name
    el.find( 'input, textarea, select').each(function() {
      $(this).attr( 'name', $(this).data('name-prefix') + '[' + total + ']' + '[' + $(this).data('name') + ']' );
    });
  }


	$( '#post-body' ).on( 'click', '.scpt-remove-thumbnail', function(e) {
		e.preventDefault();
		$( this ).parents( '.scpt-field-wrap' ).find( '.scpt-media-id' ).val( 0 );
		$( this ).parents( '.scpt-field-wrap' ).find( '.scpt-add-media' ).show();
		$( this ).parents( '.scpt-field-wrap' ).find( '.scpt-media-preview' ).html( '' );
	});

	$( '#post-body' ).on( 'click', '.scpt-add-media', function() {
		console.log('here');
		var old_send_to_editor = wp.media.editor.send.attachment;
		var input = this;
		wp.media.editor.send.attachment = function( props, attachment ) {
			props.size = 'full';
			props = wp.media.string.props( props, attachment );
			props.align = null;
			$(input).parents( '.scpt-field-wrap' ).find( '.scpt-media-id' ).val( attachment.id );
			if ( attachment.type == 'image' ) {
				var preview = 'Uploaded image:<br /><div class="scpt-media-container"><img class="media-preview" src="' + props.src + '" /></div>';
			} else {
				var preview = 'Uploaded file:&nbsp;' + wp.media.string.link( props );
			}
			preview += '<br /><a class="scpt-remove-thumbnail button button-primary button-medium" href="#">Remove</a>';
			$( input ).parents( '.scpt-field-wrap' ).find( '.scpt-media-preview' ).html( preview );
			$( input ).parents( '.scpt-field-wrap' ).find( '.scpt-add-media' ).hide();
			wp.media.editor.send.attachment = old_send_to_editor;
		}
		wp.media.editor.open( input );
	} );

	// Toggle repeat Group
	$('[data-toggle-group]').live('click', function() {
		var group = $(this).parents('[data-scpt-repeat-group]');
		var content = group.find('.scpt-repeat-group-content');

		if( ! content.hasClass('closed') ) {
			content.addClass('closed').slideUp();
			$('i', this).attr('class', 'scpt-icon-toggle-close');
		} else {
			content.removeClass('closed').slideDown();
			$('i', this).attr('class', 'scpt-icon-toggle-open');
		}
	});

	// Remove repeat Group
	$('[data-scpt-remove]').live('click', function() {
		var group = $(this).parents('[data-scpt-repeat-group]');
		var container = group.parents('[data-scpt-repeat-group-container]');
		var total = container.find('[data-scpt-repeat-group]');
		total = total.length;


		if( total <= 1 ) {
			group.find('[data-scpt-add]').click();
			container.find('[data-group-title]').html( 1 );
		}

		$(this).parents('[data-scpt-repeat-group]').remove();

	});

	// Move Group Up
	$('[data-scpt-up]').live('click', function() {
		var group = $(this).parents('[data-scpt-repeat-group]');
		var previous = group.prev('[data-scpt-repeat-group]');
		group.insertBefore(previous);
	});

	// Move Group Down
	$('[data-scpt-down]').live('click', function() {
		var group = $(this).parents('[data-scpt-repeat-group]');
		var next = group.next('[data-scpt-repeat-group]');
		group.insertAfter(next);
	});

	// Toggle repeat group container
	$('[data-toggle-container]').click(function() {
		var container = $(this).parents('[data-scpt-repeat-group-container]');
		var content = container.find('[data-scpt-group-container-content]');

		if( ! content.hasClass('closed') ) {
			content.addClass('closed').slideUp();
			$('i', this).attr('class', 'scpt-icon-toggle-close');
		} else {
			content.removeClass('closed').slideDown();
			$('i', this).attr('class', 'scpt-icon-toggle-open');
		}
	});

	// Add a Group
	$('[data-scpt-add]').live('click', function() {
		var group = $(this).parents('[data-scpt-repeat-group]');
		var container = group.parents('[data-scpt-repeat-group-container]');
		var total = container.find('[data-scpt-repeat-group]');
		total = total.length;
		var clone = group.clone();
		reset_fields( clone, total );
		clone.find('[data-group-title]').html( ( total + 1) );
		clone.insertAfter(group);
    $(document).trigger('scpt-field-added');
	});
} );