<?php

namespace ioAdmin\ioAdminPages;

use ioAdmin\ioAdminBase\ioAdminBase;

class ioAdminPages extends ioAdminBase
{
  public $pages = [];
  public $sub_pages = [];
  public $html;
  protected $request;
  protected $screen;

  public function __construct()
  {
    parent::__construct();
    $this->request = $_SERVER['REQUEST_METHOD'];

    // IO Options
    $this->addPage( 'IO Options', 'IO Options', '', 'io-options', [$this, 'ioOptionsView'] );

    if( !empty( $_GET['page'] ) && ( array_key_exists( $_GET['page'], $this->pages ) || array_key_exists( $_GET['page'], $this->sub_pages ) ) ) {
      ob_start();
    }

    add_action( 'admin_menu',[$this, 'registerPages'] );
  }

  public function makeView()
  {
    wp_enqueue_style( 'bootstrap-custom', $this->config['asset_uri'] . '/css/bootstrap.min.css' );
    wp_enqueue_style( 'FontAwesome' );

    wp_register_script( 'io-clear-fields', $this->config['asset_uri'] . '/js/io-clear-fields.js', ['jquery'] );
    wp_register_script( 'happy-methods', $this->config['asset_uri'] . '/js/happy.methods.js', ['jquery'] );
    wp_register_script( 'happy', $this->config['asset_uri'] . '/js/happy.js', ['jquery', 'happy-methods'] );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-autocomplete' );
    wp_enqueue_script( 'io-clear-fields' );
    wp_enqueue_script( 'happy-methods' );
    wp_enqueue_script( 'happy' );

    return $this->blade();
  }

  public function addPage( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url = null, $position = null )
  {

    $capability = !empty( $capability ) ? $capability : 'publish_posts';

    $this->pages[$menu_slug] = [
      'page_title' => $page_title,
      'menu_title' => $menu_title,
      'capability' => $capability,
      'menu_slug' => $menu_slug,
      'function' => $function,
      'icon_url' => $icon_url,
      'position' => $position
    ];
  }

  public function addSubPage( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function )
  {
    $capability = !empty( $capability ) ? $capability : 'publish_posts';

    $this->sub_pages[$menu_slug] = [
      ['parent_slug'] => $parent_slug,
      'page_title' => $page_title,
      'menu_title' => $menu_title,
      'capability' => $capability,
      'menu_slug' => $menu_slug,
      'function' => $function,
    ];
  }

  public function registerPages()
  {

    foreach ($this->pages as $page) {
      add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['function'], $page['icon_url'], $page['position'] );
    }

    foreach ($this->sub_pages as $page) {
      add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['function'] );
    }
  }

  public function ioOptionsView()
  {
    // view specific styles
    wp_enqueue_style( 'io-admin', $this->config['asset_uri'] . '/css/io-admin.css' );

    $state_list = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois",'IN'=>"Indiana",'IA'=>"Iowa",'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland",'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma",'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");

    $social_fields = [
      'facebook' => 'Facebook',
      'twitter' => 'Twitter',
      'linkedin' => 'Linkedin',
      'youtube' => 'Youtube',
      'vimeo' => 'Vimeo',
      'instagram' => 'Instagram',
      'google-plus' => 'Google Plus',
      'spotify' => 'Spotify'
    ];

    if( $this->request == 'POST' ) {
      $this->updateOption( $this->config['options_keys']['io-options'], $_POST, $_GET['page'] );
    }

    $options = get_option($this->config['options_keys']['io-options']);
    $options = !empty($options) ? $options : [];

    $vars = [
      'layout' => 'layouts.master',
      'page_title' => 'IO Options',
      'states' => $state_list,
      'social_fields' => $social_fields,
      'options' => $options,
    ];

    echo $this->makeView()->view()->make('io-options', $vars);
  }

  public static function userMessages()
  {
    if( !empty( $_GET['io-message'] ) ) {
      switch( $_GET['io-message'] ) {

        case 1:
          return ioAdminBase::adminMessage('updated', 'Settings Saved');
        break;

        case 2:
          return ioAdminBase::adminMessage('error', 'No settings changed / error updating settings. Please verify settings below.');
        break;
      }
    }
  }
}