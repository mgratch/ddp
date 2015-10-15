( function($) {
   /**
   * Will take children and do a expand and collapse on children.
   *
   * @param  {object} args Options
   *   children: {string} Child element to target. Default: li
   *   trigger: {string} Element to trigger the expand and collapse.
   *     Default: .js-trigger
   *   show: {string} Element to show when triggerd. Default: .js-expand
   *   expandedClass: {string} Class added to child when show element is expanded.
   *     Default: js-is-expanded
   *
   * @return void
   */
  $.fn.ioCollapse = function(args) {
    // defaults
    args = $.extend({
      children: 'li',
      trigger: '.js-trigger',
      show: '.js-expand',
      expandedClass: 'js-is-expanded'
    }, args);

    var el = $(this);
    var children = el.find(args.children);
    var trigger = children.find(args.trigger);
    var show = children.find(args.show);

    show.hide();

    trigger.live('click', function() {
      var container = $(this).parents(args.children);

      if (container.hasClass(args.expandedClass)) {
        // close all
        el.find('.'+args.expandedClass).find(args.show).hide();
        el.find('.'+args.expandedClass).removeClass(args.expandedClass);
      } else {
        // close all
        el.find('.'+args.expandedClass).find(args.show).hide();
        el.find('.'+args.expandedClass).removeClass(args.expandedClass);

        // open
        container.find(args.show).show();
        container.addClass(args.expandedClass);
      }
    });
  }

  /**
   * Does a test for mobile device. Returns true for mobile device.
   *
   * @return {Boolean}
   */
  $.fn.is_mobile = function(){
    var is_mobile;
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
      is_mobile = true;
    } else {
      is_mobile = false;
    }

    return is_mobile;
  }

  /**
   * Global smoooth scroller. NOTE: No click event inside function.
   *
   * @param  {object} options Scroller Options
   *   offset: {int} Offset of the scroll. Default: 0
   *   speed: {int} Speed of scroll. Default: 1000
   *
   *  Example: $('section.main').ioScroller();
   *
   * @return void
   */
  $.fn.ioScroller = function( options ) {
    // defaults
    var settings = $.extend({
      offset: 0,
      speed: 1000,
    }, options );

    var scrollPos = $(window).scrollTop();
    var target = $(this);

    if (target.length) {
      $('html,body').stop(true, false).animate({
        scrollTop: (target.offset().top - settings.offset ) }, settings.speed);
    }
  };

  /**
   * Clears out placeholder for search fields
   *
   * @param  {string} element   Search field ID
   *
   * Example: $('#s').placeholderValues('search the site');
   *
   * @return null
   */
  $.fn.placeholderValues = function(searchVal) {
    var element = $(this);

  	if( element.length > 0 ) {
  		element.blur(function() {
  			if( $(this).val() == '' ) {
  				$(this).val(searchVal);
  			}
  		});

  		element.focus(function() {
  			if( $(this).val() == searchVal ){
  				$(this).val('');
  			}
  		});
    }
  };

  /**
   * Prints single div content
   *
   * @return void
   */
  $.fn.printDiv = function() {
     var printContents = $(this).html();
     var originalContents = $('body').html();
     $('body').html(printContents);
     $('body').addClass('js-print');
     window.print();
     $('body').html(originalContents);
     $('body').removeClass('js-print');
   };

  /**
   * Sets sets equal heights to all child elements
   *
   * @param  {int} buffer Buffer for equal heights
   *
   * Example: $('#parent').equalHeights(10);
   *
   * @return null
   */
  $.fn.equalHeights = function(buffer) {
    // Defaults
    buffer = buffer || 0;

    var parent_element = $(this);

    var maxHeight = 0;
    parent_element.children().each(function() {
    	if( $(this).outerHeight() > maxHeight ) {
    		maxHeight = $(this).outerHeight();
    	}
    });

    maxHeight = (maxHeight + buffer);

  	parent_element.children().each(function() {
  		$(this).height(maxHeight);
  	});
  };

  /**
   * Slide toggles #menu-main UL
   *
   * @return void
   */
  function mobileMenu(){
    $('#menu-main').slideToggle();
  }

  /**
   * Collapse Main Menu on scroll
   *
   * @return void
   */
  function scrollCompressMenu() {
    var topMenuItemPadding = '43';
    var bottomMenuItemPadding = '37';
    var logoWidth = $('.site-logo').width();
    var iconWidth = $('.site-logo__icon')[0].getBoundingClientRect().width;

    $('.js-header-compress > .menu__item > .menu__link').css({
      'padding-top' : topMenuItemPadding + 'px',
      'padding-bottom' : bottomMenuItemPadding + 'px'
    });
    $('.site-logo').css({
      'width' : logoWidth + 'px'
    });

    $(window).scroll(function() {
      var trackScroll = $(window).scrollTop();
      var compressTopPadding = topMenuItemPadding - trackScroll;
      var compressBottomPadding = bottomMenuItemPadding - trackScroll;
      var shrinkIcon = iconWidth - trackScroll;


      if (compressTopPadding <= 18) {
        compressTopPadding = '18';
        compressBottomPadding = '12';
      }
      if (shrinkIcon <= 26.125) {
        shrinkIcon = '26.125';
      };

      $('.js-header-compress > .menu__item > .menu__link').css({
        'padding-top' : compressTopPadding + 'px',
        'padding-bottom' : compressBottomPadding + 'px'
      });

      if (compressTopPadding < topMenuItemPadding && !$('.site-logo').hasClass('.site-logo--icon-only')) {
        $('.site-logo').addClass('site-logo--icon-only');
        $('.site-logo').css({
          'width' : shrinkIcon + 'px'
        });
        $('.site-logo__icon').css({
          'width' : shrinkIcon + 'px'
        });
      } else {
        $('.site-logo').removeClass('site-logo--icon-only');
        $('.site-logo').css({
          'width' : logoWidth + 'px'
        });
      };
    })
  }

  /**
   * Adds menu toggle to sub-menu items with children
   */
  function addMenuToggle() {
    $('<span class="menu--sub-menu__toggle"></span>').appendTo('.menu--sub-menu > .menu__item--has-children');
  }

  /**
   * Document Ready Instance
   */
  $(document).ready(function(){

    scrollCompressMenu();
    addMenuToggle();

    // Mobile test conditionals
    if( $(document).is_mobile() ) {
       $('.mobile-nav-button').bind({
        'touchend': function(){
                mobileMenu();
              }
      });
    }  else {
      $('.mobile-nav-button').bind({
        'click':  function(){
                mobileMenu();
              }
      });
    }
  });

})(jQuery);