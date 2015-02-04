<?php

namespace ddp\live;

class SL_Framework
{
  public function __construct()
  {
    $this->loader();
  }

  public function loader()
  {
    $directories = array(
      'models',
      'controllers',
    );

    include_once __DIR__.'/vendor/super-cpt/super-cpt.php';

    foreach ($directories as $dir) {
      foreach (glob(__DIR__.'/../'.$dir.'/*.php') as $filename) {
        include_once $filename;
        $class_name = preg_replace('/\.php/', '', basename($filename));
        $class_name = __NAMESPACE__.'\\'.$class_name;
        if ($dir == 'controllers') {
          $instance = new $class_name;

          $class_name = str_replace(__NAMESPACE__.'\\', '', $class_name);

          Instance::add(array(
            $class_name => $instance
          ));
        }
      }
    }

    $this->registerAssets();
  }

  public function registerAssets()
  {
    $config = Config::get();

    $script_defaults = array(
      'deps' => null,
      'ver' => null,
      'footer' => false,
      'enqueue' => false,
      'admin' => false,
      'ajax' => false,
      'ajax_obj_name' => false
    );

    $style_defaults = array(
      'deps' => null,
      'ver' => null,
      'enqueue' => false,
      'admin' => false
    );

    if (isset($config['scripts'])) {
      foreach ($config['scripts'] as $handle => $atts) {
        $atts = array_merge($script_defaults, $atts);
        $action = $atts['admin'] ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';

        add_action($action, function() use ($handle, $atts) {
          wp_register_script(
            $handle,
            $atts['src'],
            $atts['deps'],
            $atts['ver'],
            $atts['footer']
          );

          if ($atts['ajax']) {

            if ($atts['ajax_obj_name']) {
              $localized_name = $atts['ajax_obj_name'];
            } else {
              $localized_name = preg_replace('/\./', '_', $handle.'_obj');
            }

            wp_localize_script(
              $handle,
              $localized_name,
              array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'key' => wp_create_nonce($handle)
              )
            );
          }

          if ($atts['enqueue']) {
            wp_enqueue_script($handle);
          }
        });

      }
    }

    if (isset($config['styles'])) {
      foreach ($config['styles'] as $handle => $atts) {
        $atts = array_merge($style_defaults, $atts);
        $action = $atts['admin'] ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';

        add_action($action, function() use ($handle, $atts) {
          wp_register_style(
            $handle,
            $atts['src'],
            $atts['deps'],
            $atts['ver'],
            $atts['media']
          );

          if ($atts['enqueue']) {
            wp_enqueue_style($handle);
          }
        });

      }
    }
  }
}