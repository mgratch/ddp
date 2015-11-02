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
    $('.header--main').toggleClass('mobile-menu-open');
    $('.nav--main').slideToggle(250);
  }

  /**
   * Compress Main Menu on scroll
   *
   * @return void
   */
  function scrollCompressMenu() {
    var $viewport = $(window);
    var $mobileSwitch = 855;
    var $topMenuItemPadding = 43;
    var $bottomMenuItemPadding = $topMenuItemPadding - 6;
    var $logo = $('.site-logo');
    var $icon = $('.site-logo__icon');
    var $iconWidth = $icon[0].getBoundingClientRect().width;
    var $topMenuItem = $('.menu--main > .menu__item');
    var $nav = $('.nav--main');
    var $header = $('.header--main');

    if ($viewport.width() >= $mobileSwitch) {
      $topMenuItem.each(function() {
        var $el = $(this);
        var $topMenuItemLink = $el.children('.menu__link');
        var $topMenuItemLinkCopy = $el.find('.js-link-copy');

        if ($topMenuItemLinkCopy.height() < 35 ) {
          $topMenuItemLink.css({
            'padding-top' : $topMenuItemPadding + 'px',
            'padding-bottom' : $bottomMenuItemPadding + 'px'
          });
        } else {
          $topMenuItemLink.css({
            'padding-top' : ($topMenuItemPadding - 9) + 'px',
            'padding-bottom' : ($bottomMenuItemPadding - 9) + 'px'
          });
        };
      });
    };

    if ($viewport.width() >= $mobileSwitch) {
      $logo.css({
        'width'  : $logo.width() + 'px',
        'height' : $logo.parent().height() + 'px'
      });
    } else {
      $logo.css({
        'width'  : $logo.width() + 'px',
        'height' : '104px'
      });
      $nav.css({
        'max-height' : 'calc( 100vh - 111px )'
      });
    };

    $viewport.scroll(function() {
      var $trackScroll = $viewport.scrollTop();
      var $compressTopPadding = $topMenuItemPadding - $trackScroll;
      var $compressBottomPadding = $bottomMenuItemPadding - $trackScroll;
      var $shrinkIconHeight = $topMenuItem.height();
      var $shrinkIconMobileHeight = 104 - ($trackScroll / 0.5);
      var $shrinkIconWidth = $iconWidth - ($trackScroll / 0.875);

      if ($compressTopPadding <= 18) {
        $compressTopPadding = 18;
        $compressBottomPadding = 12;
      }
      if ($shrinkIconHeight <= 54) {
        $shrinkIconHeight = 54;
      };
      if ($shrinkIconMobileHeight <= 54) {
        $shrinkIconMobileHeight = 54;
      };
      if ($shrinkIconWidth <= 26.125) {
        $shrinkIconWidth = 26.125;
      }

      if ($viewport.width() >= $mobileSwitch) {
        $topMenuItem.each(function() {
          var $el = $(this);
          var $topMenuItemLink = $el.children('.menu__link');
          var $topMenuItemLinkCopy = $el.find('.js-link-copy');

          if ($topMenuItemLinkCopy.height() < 35 ) {
            $topMenuItemLink.css({
              'padding-top' : $compressTopPadding + 'px',
              'padding-bottom' : $compressBottomPadding + 'px'
            });
          } else {
            $topMenuItemLink.css({
              'padding-top' : ($compressTopPadding - 9) + 'px',
              'padding-bottom' : ($compressBottomPadding - 9) + 'px'
            });
          };
        });
      } else {
        $nav.css({
          'max-height' : 'calc( 100vh - ' + $shrinkIconMobileHeight + 'px )'
        });
      };

      if ($compressTopPadding < $topMenuItemPadding && !$logo.hasClass('.site-logo--icon-only')) {
        $logo.addClass('site-logo--icon-only');

        $icon.css({
          'width' : $shrinkIconWidth + 'px'
        });
        if ($viewport.width() >= $mobileSwitch) {
          $logo.css({
            'height' : $shrinkIconHeight + 'px'
          });
        } else {
          $logo.css({
            'height' : $shrinkIconMobileHeight + 'px'
          });
        };
      } else {
        $logo.removeClass('site-logo--icon-only');

        if ($viewport.width() >= $mobileSwitch) {
          $logo.css({
            'width' : $logo.parent().width() + 'px',
            'height' : $logo.parent().height() + 'px'
          });
        } else {
          $logo.css({
            'width' : $logo.parent().width() + 'px',
            'height' : '104px'
          });
        };
      };
    });

    $viewport.resize(function() {
      var $trackScroll = $viewport.scrollTop();
      var $currentTopPadding = $topMenuItemPadding - $trackScroll;
      var $currentBottomPadding = $bottomMenuItemPadding - $trackScroll;
      var $currentHeaderHeight = $('.header--main').height();

      if ($currentTopPadding <= 18) {
        $currentTopPadding = 18;
        $currentBottomPadding = 12;
      }

      if ($viewport.width() >= $mobileSwitch) {
        $topMenuItem.each(function() {
          var $el = $(this);
          var $topMenuItemLink = $el.children('.menu__link');
          var $topMenuItemLinkCopy = $el.find('.js-link-copy');

          if ($topMenuItemLinkCopy.height() < 35 ) {
            $topMenuItemLink.css({
              'padding-top' : $currentTopPadding + 'px',
              'padding-bottom' : $currentBottomPadding + 'px'
            });
          } else {
            $topMenuItemLink.css({
              'padding-top' : ($currentTopPadding - 9) + 'px',
              'padding-bottom' : ($currentBottomPadding - 9) + 'px'
            });
          };
        });
        $nav.removeAttr('style');
      } else {
        $nav.css({
          'max-height' : 'calc( 100vh - ' + $currentHeaderHeight + 'px )'
        });
        $('.menu__link').removeAttr('style');
      };

      if ($viewport.width() >= $mobileSwitch) {
        $logo.css({
          'width'  : $logo.width() + 'px',
          'height' : $logo.parent().height() + 'px'
        });
      } else {
        $logo.css({
          'width'  : $logo.width() + 'px',
          'height' : $currentHeaderHeight + 'px'
        });
      };
    });
  }

  function heroContentPosition() {
    var headerHeight = $('.header--main')[0].getBoundingClientRect().height;

    $('.hero__content').css({
      'top' : headerHeight + 'px',
    });

    $(window).scroll(function() {
      var headerHeight = $('.header--main')[0].getBoundingClientRect().height;
      var headerTrack = headerHeight + $(window).scrollTop();

      if (headerHeight == 61) {
        headerTrack = '86';
      }

      $('.hero__content').css({
        'top' : headerTrack + 'px',
      });
    });
  }

  /**
   * Adds menu toggle to sub-menu items with children
   */
  function addMenuToggle() {
    var $toggle = $('<span class="menu--sub-menu__toggle"></span>');
    var $current = $('.menu--sub-sub-menu > .menu__item--current');
    var $currentParent = $current.parents('.menu__item--current-item-parent');
    var $currentMenu = $currentParent.find('.menu--sub-sub-menu');

    $toggle.appendTo('.menu--sub-menu > .menu__item--has-children, .menu--side > .menu__item--has-children');
    $('.menu--sub-sub-menu').hide();

    if (Boolean($current.length)) {
      $currentParent.addClass('menu__item--toggle-open');
      $currentMenu.show();
    };

    $('.js-menu-toggle > .menu__link, .menu--sub-menu__toggle').click(function(e) {
      e.preventDefault();
      var $el = $(this);
      var $parent = $el.parent();
      var $menu = $parent.find('.menu--sub-sub-menu');

      if (!$parent.hasClass('menu__item--toggle-open')) {
        $parent.addClass('menu__item--toggle-open');
        $menu.slideDown(250);
      } else {
        $parent.removeClass('menu__item--toggle-open');
        $menu.slideUp(250);
      };
    });
  }

  /**
   * Control tab switching
   */
  function tabSwitching() {
    var $tab = $('.js-tab');
    var $content = $('.js-tab-content');

    $tab.eq(0).addClass('tab--active');
    // $content.not(':eq(0)').hide();
    $content.not(':eq(0)').velocity('transition.slideUpOut', { duration: 50 } );

    $tab.click(function() {
      var $el = $(this);
      var $container = $('.js-tab-content-container');

      if (!$el.hasClass('tab--active')) {
        $tab.removeClass('tab--active');
        $el.addClass('tab--active');

        $container.css({
          'min-height' : $container.height() + 'px'
        });

        $content.velocity('transition.slideUpOut', {
          duration: 175,
          complete: function () {
            $content.eq( $el.index('.js-tab') ).velocity('transition.slideDownIn', {
              duration: 250,
              complete: function () {
                $container.removeAttr('style');
              }
            });
          }
        });
      }
    });
  }

  // For ddp interactive map by the one and only ritz
  function setup_cat_nav() {
    $(".map-container .info-overlay .links a").bind('click', function(e) {
      e.preventDefault();

      var slug = $(this).attr("id");
      $(this).toggleClass("active");

      if ($(this).hasClass("active")) {
        toggle_markers(slug, true);
      } else {
        toggle_markers(slug, false);
      }
    });
  }

  // For ddp interactive map by the one and only ritz
  function toggle_markers(slug, state){
		for(var key in gmarkers){
			var marker = gmarkers[key];
			if(marker.category == slug){
				marker.setVisible(state);
			}
		}
	}

  /**
   * Document Ready Instance
   */
  $(document).ready(function(){

    scrollCompressMenu();
    heroContentPosition();
    tabSwitching();
    addMenuToggle();
    setup_cat_nav();

    // Mobile test conditionals
    if( $(document).is_mobile() ) {
      $('.mobile-button').bind({
        'touchend': function(){
          mobileMenu();
        }
      });
    } else {
      $('.mobile-button').bind({
        'click':  function(){
          mobileMenu();
        }
      });
    }
  });

})(jQuery);
