<?php

namespace IODD\DDPLegacy\Router;

use IODD\DDPLegacy\Config\Config as Config;

class LegacyRouter
{
  protected $legacyThemePath;
  protected $legacyThemeUri;

  public function __construct()
  {
    $this->legacyThemePath = Config::get('legacy_theme_path');
    $this->legacyThemeUri = Config::get('legacy_theme_uri');

    $this->actions();
  }

  public function actions()
  {
    add_filter('template_include', function($template) {
      global $post;
      $isLegacy = false;

      // We loose all the incoming template names when we removed the templates
      // from the theme so we do some mapping below.

      // we need custom meta to get the template file
      if (@$postTemplate = get_post_custom($post->ID)['_wp_page_template'][0]) {
        $template = $postTemplate;
      }

      // fallback mapping for the 'default' template since that does not come
      // as a filename.
      if ($template === 'default') {
        $template = 'page.php';
      }

      // special handling for archives
      if (is_archive()) {
        if ($archive = $this->archive($post)) {
          $template = $archive;
          $isLegacy = true;
        }
      }

      // special handling for singles
      if (is_single()) {
        if ($single = $this->single($post)) {
          $template = $single;
          $isLegacy = true;
        }
      }

      // Normal Mapping
      if (!is_archive() && ! is_single()) {
        if ($legacyTemplate = $this->standard($template)) {
          $template = $legacyTemplate;
          $isLegacy = true;
        } else {
          $template = locate_template($template);
        }
      }

      if ($isLegacy) {
        require_once $this->legacyThemePath . 'functions.php';

        // If it is a legacy template we need to get change the template
        // directory reference so we can find the files.
        add_filter('template_directory_uri', function() {
          return $this->legacyThemeUri;
        });

        // Its a legacy file, we need to snag the css and js.
        $this->legacyAssets();
      }

      return $template;
    });
  }

  public function archive($post)
  {
    $postTypeTemplate = $this->legacyThemePath . 'archive-'.$post->post_type.'.php';

    if (file_exists($postTypeTemplate)) {
      return $postTypeTemplate;
    }

    if ($localTemplate = locate_template('archive-'.$post->post_type.'.php')) {
      return $localTemplate;
    }

    if (file_exists($this->legacyThemePath . 'archive.php')) {
      return $this->legacyThemePath . 'archive.php';
    }

    // Worst case, bail out to the theme archive.php
    return locate_template('archive.php');
  }

  public function single($post)
  {
    $postTypeTemplate = $this->legacyThemePath . 'single-'.$post->post_type.'.php';

    if (file_exists($postTypeTemplate)) {
      return $postTypeTemplate;
    }

    if ($localTemplate = locate_template('single-'.$post->post_type.'.php')) {
      return $localTemplate;
    }

    if (file_exists($this->legacyThemePath . 'single.php')) {
      return $this->legacyThemePath . 'single.php';
    }

    // Worst case, bail out to the theme single.php
    return locate_template('single.php');
  }

  public function standard($template)
  {
    $legacyTemplate = $this->legacyThemePath . basename($template);

    if (file_exists($legacyTemplate)) {
      return $legacyTemplate;
    }

    return false;
  }

  public function legacyAssets()
  {
    add_action('wp_enqueue_scripts', function() {
      wp_enqueue_style(
        'legacy_stylesheet.primary',
        $this->legacyThemeUri . '/style.css'
      );

      wp_enqueue_style(
        'legacy_stylesheet.bootstrap',
        $this->legacyThemeUri . '/style.css'
      );

      wp_enqueue_style(
        'legacy_stylesheet.print',
        $this->legacyThemeUri . '/bootstrap/css/bootstrap.css'
      );

      wp_enqueue_style(
        'legacy_stylesheet.swiper',
        $this->legacyThemeUri . '/css/idangerous.swiper.css'
      );

      wp_enqueue_script(
        'legacy_scripts.swiper',
        $this->legacyThemeUri . '/javascript/idangerous.swiper.js',
        ['jquery'],
        null,
        true
      );

      wp_enqueue_script(
        'legacy_scripts.bootstrap',
        $this->legacyThemeUri . '/javascript/bootstrap.js',
        ['jquery'],
        null,
        true
      );

      wp_enqueue_script(
        'legacy_scripts.jquery_mobile_custom',
        $this->legacyThemeUri . '/javascript/jquery.mobile.custom.min.js',
        ['jquery'],
        null,
        true
      );

      wp_enqueue_script(
        'legacy_scripts.ddp',
        $this->legacyThemeUri . '/javascript/ddp.js',
        ['jquery'],
        null,
        true
      );

      wp_enqueue_script(
        'legacy_scripts.tinysort',
        $this->legacyThemeUri . '/javascript/jquery.tinysort.js',
        ['jquery'],
        null,
        true
      );

      wp_enqueue_script(
        'legacy_scripts.pdfobject',
        $this->legacyThemeUri . '/javascript/pdfobject.js',
        ['jquery'],
        null,
        true
      );

    }, 666);
  }
}
