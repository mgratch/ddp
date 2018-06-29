/**
 * File menu.js
 *
 * Toggle Submenus when clicked
 */
window.wdsWindowReady = {};
(function (window, $, app) {
    // Constructor.
    app.init = function () {
        app.cache();
        app.bindEvents();
    };

    // Cache document elements.
    app.cache = function () {
        app.$c = {
            'window': $(window),
            'body': $(document.body),
            'menu': $('#menu-main')
        };

        app.$c.topLinks = app.$c.menu.children('.menu__item--has-children');
        app.$c.subMenuItems = app.$c.topLinks.find('.menu__item--has-children');
        app.$c.subMenus = app.$c.topLinks.find('.menu--sub-sub-menu');
        app.$c.subMenuLinks = app.$c.subMenuItems.find('.fl-has-submenu-container > a');
    };

    // Combine all events.
    app.bindEvents = function () {

        console.log(window.innerWidth);

        if (993 < window.innerWidth){
            app.$c.subMenuLinks.on('click touchstart', app.preventClick);
            app.$c.subMenus.on('click touchstart', app.preventBubbling);
            app.$c.subMenuItems.on('click touchstart', app.expandSubmenu);
        }
        window.onresize = function(event) {
            if (993 < window.innerWidth){
                app.$c.subMenuLinks.on('click touchstart', app.preventClick);
                app.$c.subMenus.on('click touchstart', app.preventBubbling);
                app.$c.subMenuItems.on('click touchstart', app.expandSubmenu);
            }
        };

    };

    //prevent bubbling events
    app.preventBubbling = function (e) {
        e.stopPropagation();
    };

    // Prevent Clicks
    app.preventClick = function (e) {
        e.preventDefault();
    };

    app.expandSubmenu = function () {
        $(this).find('.menu--sub-sub-menu').slideToggle();
        $(this).toggleClass('opened');
    };



    // Engage!
    $(app.init);
})(window, jQuery, window.wdsWindowReady);
