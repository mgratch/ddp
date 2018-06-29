(function($){

	/**
	 * Helper class for rendering layout changes via AJAX.
	 *
	 * @class FLBuilderAJAXLayout
	 * @since 1.7
	 */
	FLBuilderAJAXLayout = function( data, callback )
	{
		this._data 					= $.extend( {}, this._defaults, typeof data == 'string' ? JSON.parse( data ) : data );
		this._callback				= callback;
		this._post    				= FLBuilderConfig.postId;
		this._head    				= $('head').eq(0);
		this._body    				= $('body').eq(0);

		// Setup the new CSS vars if we have new CSS.
		if ( this._data.css ) {
			this._loader  = $('<img src="' + this._data.css + '" />');
			this._oldCss  = $('link[href*="/cache/' + this._post + '"]');
			this._newCss  = $('<link rel="stylesheet" id="fl-builder-layout-' + this._post + '-css"  href="'+ this._data.css +'" />');
		}

		// Setup partial refresh vars.
		if ( this._data.partial ) {
			if ( this._data.js ) {
				this._oldJs = $('#fl-builder-partial-refresh-js');
				this._newJs = $('<script type="text/javascript" id="fl-builder-partial-refresh-js">'+ this._data.js +'</script>');
			}
			if ( this._data.nodeId ) {
				if ( this._data.oldNodeId ) {
					this._oldScriptsStyles 	= $( '.fl-builder-node-scripts-styles[data-node="' + this._data.oldNodeId + '"]' );
					this._content 			= $( '.fl-node-' + this._data.oldNodeId );
				}
				else {
					this._oldScriptsStyles 	= $( '.fl-builder-node-scripts-styles[data-node="' + this._data.nodeId + '"]' );
					this._content 			= $( '.fl-node-' + this._data.nodeId ).eq(0);
				}
			}
		}
		// Setup full refresh vars.
		else {
			this._oldJs   			= $('script[src*="/cache/' + this._post + '"]');
			this._newJs   			= $('<script src="'+ this._data.js +'"></script>');
			this._oldScriptsStyles 	= $( '.fl-builder-layout-scripts-styles' );
			this._content 			= $( FLBuilder._contentClass );
		}

		this._init();
	};

	/**
	 * Prototype for new instances.
	 *
	 * @since 1.7.
	 * @property {Object} prototype
	 */
	FLBuilderAJAXLayout.prototype = {

		/**
		 * Defaults for the data sent from the server.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _defaults
		 */
		_defaults 			: {
			partial 		: false,
			nodeId 			: null,
			nodeType 		: null,
			nodeParent 		: null,
			nodePosition 	: null,
			oldNodeId 		: null,
			html 			: null,
			scriptsStyles 	: null,
			css 			: null,
			js 				: null
		},

		/**
		 * Data from the server for this render.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _data
		 */
		_data 				: null,

		/**
		 * A function to call when the render is complete.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Function} _callback
		 */
		_callback			: function(){},

		/**
		 * The ID of this post.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Number} _post
		 */
		_post    			: null,

		/**
		 * A jQuery reference to the head element.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _head
		 */
		_head    			: null,

		/**
		 * A jQuery reference to the body element.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _body
		 */
		_body    			: null,

		/**
		 * An jQuery reference to an image element that is used
		 * to preload the new CSS file using the onerror hack.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _loader
		 */
		_loader  			: null,

		/**
		 * An jQuery reference to the old CSS element.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _oldCss
		 */
		_oldCss				: null,

		/**
		 * An jQuery reference to the new CSS element.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _newCss
		 */
		_newCss				: null,

		/**
		 * An jQuery reference to the old JS element.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _oldJs
		 */
		_oldJs				: null,

		/**
		 * An jQuery reference to the new JS element.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _newJs
		 */
		_newJs   			: null,

		/**
		 * An jQuery reference to the old div that holds scripts
		 * and styles generated by widgets and shortcodes.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _oldScriptsStyles
		 */
		_oldScriptsStyles 	: null,

		/**
		 * An jQuery reference to the content element.
		 *
		 * @since 1.7
		 * @access private
		 * @property {Object} _content
		 */
		_content 			: null,

		/**
		 * Starts the render by loading the new CSS file.
		 *
		 * @since 1.7
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			// Set the body height so the page doesn't scroll.
			this._body.height( this._body.height() );

			// Load the new CSS.
			if ( this._loader )  {

				// Set the loader's error event.
				this._loader.on( 'error', $.proxy( this._loadNewCSSComplete, this ) );

				// Add the loader to the body.
				this._body.append( this._loader );
			}
			// We don't have new CSS, finish the render.
			else {
				this._finish();
			}
		},

		/**
		 * Removes the loader, adds the new CSS once it has loaded,
		 * and sets a quick timeout to finish the render.
		 *
		 * @since 1.7
		 * @access private
		 * @method _loadNewCSSComplete
		 */
		_loadNewCSSComplete: function()
		{
			// Remove the loader.
			this._loader.remove();

			// Add the new layout css.
			if ( this._oldCss.length > 0 ) {
				this._oldCss.after( this._newCss );
			}
			else {
				this._head.append( this._newCss );
			}

			// Set a quick timeout to ensure the css has taken effect.
			setTimeout( $.proxy( this._finish, this ), 250 );
		},

		/**
		 * Finishes the render after the CSS has been loaded.
		 *
		 * @since 1.7
		 * @access private
		 * @method _finish
		 */
		_finish: function()
		{
			// Remove the old content and assets.
			this._removeOldContentAndAssets();

			// Clean the new HTML.
			this._cleanNewHTML();

			// Clean up the new JS and CSS assets.
			this._cleanNewAssets();

			// Add the new HTML.
			this._addNewHTML();

			// Add widget/shortcode JS and CSS assets.
			this._addNewScriptsStyles();

			// Add the new layout JS.
			this._addNewJS();

			// Send the layout rendered event.
			$( FLBuilder._contentClass ).trigger( 'fl-builder.layout-rendered' );

			// Hide the loader.
			FLBuilder.hideAjaxLoader();

			// Run the callback.
			if ( typeof this._callback != 'undefined' ) {
				this._callback();
			}

			// Fire the complete hook.
			FLBuilder.triggerHook( 'didRenderLayoutComplete' );
		},

		/**
		 * Removes old content and assets from the page.
		 *
		 * @since 1.7
		 * @access private
		 * @method _removeOldContentAndAssets
		 */
		_removeOldContentAndAssets: function()
		{
			if ( this._content ) {
				this._content.empty();
			}
			if ( this._oldCss ) {
				this._oldCss.remove();
			}
			if ( this._oldJs ) {
				this._oldJs.remove();
			}
			if ( this._oldScriptsStyles ) {
				this._oldScriptsStyles.remove();
			}
		},

		/**
		 * Removes scripts and styles from _data.html that have been added by
		 * widgets and shortcodes and adds them to _data.scriptsStyles.
		 *
		 * @since 1.7
		 * @access private
		 * @method _cleanNewHTML
		 */
		_cleanNewHTML: function()
		{
			// Only proceed if _data.scriptsStyles is set.
			if ( ! this._data.scriptsStyles ) {
				return;
			}

			// Setup vars.
			var html 	 		= $( '<div>' + this._data.html + '</div>' ),
				nodeClass 		= 'fl-row',
				scriptsStyles 	= this._data.scriptsStyles,
				removed 		= '';

			// Get the class of the nodes that should be in data.html.
			if ( this._data.partial ) {
				if ( 'column-group' == this._data.nodeType ) {
					nodeClass = 'fl-col-group';
				}
				else if ( 'column' == this._data.nodeType ) {
					nodeClass = 'fl-col';
				}
				else {
					nodeClass = 'fl-' + this._data.nodeType;
				}
			}

			// Remove elements that shouldn't be in data.html.
			html.find( '> *, script' ).each( function() {
				if ( ! $( this ).hasClass( nodeClass ) ) {
					removed 	   = $( this ).remove();
					scriptsStyles += removed[0].outerHTML;
				}
			});

			// Wrap scriptsStyles if we have any content in it.
			if ( '' !== scriptsStyles ) {
				if ( this._data.partial ) {
					scriptsStyles = '<div class="fl-builder-node-scripts-styles" data-node="' + this._data.nodeId + '">' + scriptsStyles + '<div>';
				}
				else {
					scriptsStyles = '<div class="fl-builder-node-scripts-styles">' + scriptsStyles + '<div>';
				}
			}

			// Update the data object.
			this._data.html 			= html.html();
			this._data.scriptsStyles 	= scriptsStyles;
		},

		/**
		 * Adds the new HTML to the page.
		 *
		 * @since 1.7
		 * @access private
		 * @method _addNewHTML
		 */
		_addNewHTML: function()
		{
			var siblings;

			// Add HTML for a partial refresh.
			if ( this._data.partial ) {

				// If data.nodeParent is present, we have a new node.
				if ( this._data.nodeParent ) {

					// Get sibling rows.
					if ( this._data.nodeParent.hasClass( 'fl-builder-content' ) ) {
						siblings = this._data.nodeParent.find( '.fl-row' );
					}
					// Get sibling column groups.
					else if ( this._data.nodeParent.hasClass( 'fl-row-content' ) ) {
						siblings = this._data.nodeParent.find( ' > .fl-col-group' );
					}
					// Get sibling columns.
					else if ( this._data.nodeParent.hasClass( 'fl-col-group' ) ) {
						siblings = this._data.nodeParent.find( ' > .fl-col' );
					}
					// Get sibling modules.
					else {
						siblings = this._data.nodeParent.find( ' > .fl-col-group, > .fl-module' );
					}

					// Filter out any clones created by duplicating.
					siblings = siblings.filter( ':not(.fl-builder-node-clone)' );

					// Add the new node.
					if ( 0 === siblings.length || siblings.length == this._data.nodePosition ) {
						this._data.nodeParent.append( this._data.html );
					}
					else {
						siblings.eq( this._data.nodePosition ).before( this._data.html );
					}

					// Remove node loading placeholder in case we have one.
					if ( this._data.nodeId ) {
						FLBuilder._removeNodeLoadingPlaceholder( $( '.fl-node-' + this._data.nodeId ) );
					}
				}
				// We must be refreshing an existing node.
				else {
					this._content.after( this._data.html );
					this._content.remove();
				}
			}
			// Add HTML for a full refresh.
			else {
				this._content.append( this._data.html );
			}

			// Refresh preview HTML of nodes within other nodes (such as modules in a row) to ensure
			// any changes to the nested node are preserved after we've inserted the new HTML.
			if ( FLBuilder.preview && this._data.nodeId && this._data.nodeId != FLBuilder.preview.nodeId ) {
				if ( $( FLBuilder.preview.classes.node ).length ) {
					$( FLBuilder.preview.classes.node ).html( FLBuilder.preview.elements.node.html() );
				}
			}
		},

		/**
		 * Removes unnecessary JS and CSS assets from the layout.
		 *
		 * @since 1.7
		 * @access private
		 * @method _cleanAssets
		 */
		_cleanNewAssets: function()
		{
			var nodeId 	= null,
				self 	= this;

			// Remove duplicate assets from _data.html.
			this._data.html = this._removeDuplicateAssets( this._data.html );

			// Remove duplicate assets from _data.scriptsStyles.
			if ( this._data.scriptsStyles && '' !== this._data.scriptsStyles ) {
				this._data.scriptsStyles = this._removeDuplicateAssets( this._data.scriptsStyles );
			}

			// Remove all partial JS and CSS if this is a full render.
			if ( ! this._data.partial ) {
				$( '#fl-builder-partial-refresh-js' ).remove();
				$( '.fl-builder-node-scripts-styles' ).remove();
			}
			// Else, remove assets that aren't needed.
			else {

				$( '.fl-builder-node-scripts-styles' ).each( function() {
					if ( self._data.html.indexOf( 'fl-node-' + $( this ).data( 'node' ) ) > -1 ) {
						$( this ).remove();
					}
				} );
			}
		},

		/**
		 * Removes JS and CSS that is already on the page
		 * from the provided HTML content.
		 *
		 * @since 1.7
		 * @access private
		 * @method _removeDuplicateAssets
		 * @param {String} html The HTML content to remove assets from.
		 * @return {String} The cleaned HTML content.
		 */
		_removeDuplicateAssets: function( html )
		{
			var cleaned = $( '<div>' + html + '</div>' ),
				src     = '',
				script  = null,
				href    = '',
				link    = null,
				loc 	= window.location,
				origin  = loc.protocol + '//' + loc.hostname + ( loc.port ? ':' + loc.port : '' );

			// Remove duplicate scripts.
			cleaned.find( 'script' ).each( function() {

				src = $( this ).attr( 'src' );

				if ( 'undefined' != typeof src ) {

					src     = src.replace( origin, '' );
					script  = $( 'script[src*="' + src + '"]' );

					if ( script.length > 0 ) {
						$( this ).remove();
					}
				}
			});

			// Remove duplicate links.
			cleaned.find( 'link' ).each( function() {

				href = $( this ).attr( 'href' );

				if ( 'undefined' != typeof href ) {

					href  = href.replace( origin, '' );
					link  = $( 'link[href*="' + href + '"]' );

					if ( link.length > 0 ) {
						$( this ).remove();
					}
				}
			});

			return cleaned.html();
		},

		/**
		 * Adds the new scripts and styles to the page.
		 *
		 * @since 1.7
		 * @access private
		 * @method _addNewScriptsStyles
		 */
		_addNewScriptsStyles: function()
		{
			if ( this._data.scriptsStyles && '' !== this._data.scriptsStyles ) {
				this._body.append( this._data.scriptsStyles );
			}
		},

		/**
		 * Adds the new layout JS to the page.
		 *
		 * @since 1.7
		 * @access private
		 * @method _addNewJS
		 */
		_addNewJS: function()
		{
			setTimeout( $.proxy( function() {

				if ( this._newJs ) {
					this._head.append( this._newJs );
				}

			}, this ), 50 );
		},

		/**
		 * Called when the render has been completed.
		 *
		 * @since 1.7
		 * @access private
		 * @method _complete
		 */
		_complete: function()
		{
			FLBuilder._setupEmptyLayout();
			FLBuilder._highlightEmptyCols();
			FLBuilder._initDropTargets();
			FLBuilder._initSortables();
			FLBuilder._resizeLayout();
			FLBuilder._initMediaElements();
			FLBuilderLayout.init();
			FLBuilderResponsiveEditing.refreshPreview();

			this._body.height( 'auto' );
		}
	};

})(jQuery);
