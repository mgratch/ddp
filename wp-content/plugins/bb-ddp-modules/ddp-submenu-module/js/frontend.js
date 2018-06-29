/**
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
            'menu': $('.menu--side')
        };

        app.$c.topLinksItems = app.$c.menu.children('.menu-item-has-children');
        app.$c.subMenus = app.$c.topLinksItems.children('.menu--sub-sub-menu');
        app.$c.topLinks = app.$c.topLinksItems.children('.menu__link');
    };

    // Combine all events.
    app.bindEvents = function () {
        app.$c.topLinks.on('click touchstart', app.preventClick);
        app.$c.subMenus.on('click touchstart', app.preventBubbling);
        app.$c.topLinksItems.on('click touchstart', app.expandSubmenu);
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
