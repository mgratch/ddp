( function( $ ) {
	
	/**
	 * Handles logic for the user templates admin list interface.
	 *
	 * @class FLBuilderUserTemplatesAdminList
	 * @since 1.10
	 */
	FLBuilderUserTemplatesAdminList = {
		
		/**
		 * Initializes the user templates admin list interface.
		 *
		 * @since 1.10
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			this._setupAddNewButton();
			this._setupSearch();
		},

		/**
		 * Changes the Add New button URL to point to our
		 * custom Add New page.
		 *
		 * @since 1.10
		 * @access private
		 * @method _setupSearch
		 */
		_setupAddNewButton: function()
		{
			var url = FLBuilderConfig.addNewURL + '&fl-builder-template-type=' + FLBuilderConfig.userTemplateType;
				
			$( '.page-title-action' ).attr( 'href', url ).show();
		},

		/**
		 * Adds a hidden input to the search for the user
		 * template type.
		 *
		 * @since 1.10
		 * @access private
		 * @method _setupSearch
		 */
		_setupSearch: function()
		{
			var type  = FLBuilderConfig.userTemplateType,
				input = '<input type="hidden" name="fl-builder-template-type" value="' + type + '">'
			
			$( '.search-box' ).after( input );
		}
	};
	
	// Initialize
	$( function() { FLBuilderUserTemplatesAdminList._init(); } );

} )( jQuery );