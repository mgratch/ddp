<?php

namespace ddp\live;

class Property_Controller extends Controller
{
  public function actions()
  {
    add_action('wp_ajax_ddpLiveGetProperties', array($this, 'getPropertiesAjax'));
    add_action('wp_ajax_no_priv_ddpLiveGetProperties', array($this, 'getPropertiesAjax'));
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
      $buy_range = array();
      $rent_range = array();
      $sq_foot_range = array();

      foreach ($properties as $p) {
        if ($p->type == 'rent') {
          $rent_range[] = $p->price;
        } else {
          $buy_range[] = $p->price;
        }

        $sq_foot_range[] = $p->sq_footage;
      }

      $ranges = array(
        'buy' => array(
          'min' => min($buy_range),
          'max' => max($buy_range)
        ),
        'rent' => array(
          'min' => min($rent_range),
          'max' => max($rent_range)
        ),
        'sq_ft' => array(
          'min' => min($sq_foot_range),
          'max' => max($sq_foot_range)
        ),
      );

      $response->ranges = $ranges;

      $response = json_encode($response);
    }

    echo $response;
    die();
  }
}