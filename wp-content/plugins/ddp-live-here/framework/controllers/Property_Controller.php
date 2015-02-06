<?php

namespace ddp\live;

class Property_Controller extends Controller
{
  public function actions()
  {
    add_action('wp_ajax_ddpLiveGetProperties', array($this, 'getPropertiesAjax'));
    add_action('wp_ajax_nopriv_ddpLiveGetProperties', array($this, 'getPropertiesAjax'));

    add_action('wp_ajax_ddpPropertyListing', array($this, 'getPropertyListingAjax'));
    add_action('wp_ajax_nopriv_ddpPropertyListing', array($this, 'getPropertyListingAjax'));
  }

  public function postType($type)
  {
    $foos = $type->scpt( 'foo', 'Foo', 'Foos' );

    $foos->add_meta_box( array(
      'id' => 'box-id',
      'context' => 'side',
      'fields' => array(
        'field-name' => array()
      )
    ) );
  }

  public function interactiveMap() {
    wp_enqueue_script('ddpLiveGoogleMapsAPI');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('ddpLiveInteractive.js');
    wp_enqueue_style('ddpLiveInteractive.css');
    return $this->view->makeView('master');
  }

  public function getPropertiesAjax()
  {
    $args = $_GET;
    check_ajax_referer('ddpLiveInteractive.js', 'key', true);
    $response = 'false';
    $properties = $this->model->findAll();

    if ($properties) {
      $response = (object) array();
      $response->properties = $properties;
      $response->ranges = array();
      $ranges = array();

      foreach ($properties as $p) {
        if (empty($p->price)) {
          $p->price = 0;
        }

        if (empty($p->sq_footage)) {
          $p->sq_footage = 0;
        }

        $ranges[$p->type][] = $p->price;

        $ranges['sq_ft'][] = $p->sq_footage;
      }

      // Make sure we are sending back at least the key
      if (!isset($ranges['buy'])) {
        $ranges['buy'] = array(0);
      }

      // Make sure we are sending back at least the key
      if (!isset($ranges['rent'])) {
        $ranges['rent'] = array(0);
      }

      foreach ($ranges as $type => $range) {
        $response->ranges[$type] = array(
          'min' => min($range),
          'max' => max($range)
        );
      }

      $response = json_encode($response);
    }

    echo $response;
    die();
  }

  public function getPropertyListingAjax()
  {
    $args = $_GET;
    check_ajax_referer('ddpLiveInteractive.js', 'key', true);
    $response = array();

    $response['html'] = base64_encode($this->view->makeView('ajax.listing'));

    echo json_encode($response);
    die();
  }
}