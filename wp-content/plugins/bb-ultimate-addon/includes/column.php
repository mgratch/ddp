<?php

function uabb_column_settings_init() {

    require_once BB_ULTIMATE_ADDON_DIR . 'includes/column-settings.php';
    require_once BB_ULTIMATE_ADDON_DIR . 'includes/column-css.php';
    require_once BB_ULTIMATE_ADDON_DIR . 'includes/column-js.php';

    uabb_column_register_settings();
    uabb_column_render_css();
    uabb_column_render_js();
}

uabb_column_settings_init();
