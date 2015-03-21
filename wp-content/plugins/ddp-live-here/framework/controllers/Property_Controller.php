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

    add_action('wp_ajax_ddpPropertyDetail', array($this, 'getPropertyDetailAjax'));
    add_action('wp_ajax_nopriv_ddpPropertyDetail', array($this, 'getPropertyDetailAjax'));
  }

  public function postType($type)
  {
    $properties = $type->scpt(
      'property',
      'Property',
      'Properties',
      array(
        'supports' => array(
          'title',
          'editor'
        )
      )
    );

    $properties->add_meta_box( array(
      'id' => 'property-attributes',
      'context' => 'normal',
      'fields' => array(
        'property_type' => array(
          'type' => 'select',
          'options' => array('Buy', 'Rent')
        ),
        'property_price' => array(
          'type' => 'text'
        ),
        'property_term' => array(
          'type' => 'select',
          'options' => array('Monthly', 'Yearly')
        ),
        'property_sq_footage' => array(
          'type' => 'text'
        ),
        'property_rooms' => array(
          'type' => 'text'
        ),
        'property_bathrooms' => array(
          'type' => 'text'
        ),
        'property_agent_email' => array(
          'type' => 'email'
        ),
        'property_features' => array(
          'type' => 'textarea'
        ),
        'property_address' => array(
          'type' => 'text',
          'style' => 'width: 100%;',
          'field_description' => 'Include apartment/building number/suite.',
          'data-field-type' => 'address'
        ),
        'property_city' => array(
          'type' => 'text',
          'data-field-type' => 'city'
        ),
        'property_state' => array(
          'type' => 'text',
          'length' => 2,
          'data-field-type' => 'state'
        ),
        'property_zip' => array(
          'type' => 'text',
          'data-field-type' => 'zip'
        ),
        'property_latitude' => array(
          'type' => 'text',
          'length' => 50,
          'data-field-type' => 'latitude'
        ),
        'property_longitude' => array(
          'type' => 'text',
          'length' => 50,
          'data-field-type' => 'longitude'
        ),
        'property_get_latlng' => array(
          'type' => 'button',
          'button_text' => 'Get Coords <span class="js-property-admin-loader" style="display:none;"><div style="max-width:.8em;height:auto;margin:0 1em;display:inline-block;"><svg style="width:100%;height:100%" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="#fff"> <rect y="10" width="15" height="120" rx="6"> <animate attributeName="height" begin="0.5s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/> <animate attributeName="y" begin="0.5s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/> </rect> <rect x="30" y="10" width="15" height="120" rx="6"> <animate attributeName="height" begin="0.25s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/> <animate attributeName="y" begin="0.25s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/> </rect> <rect x="60" width="15" height="140" rx="6"> <animate attributeName="height" begin="0s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/> <animate attributeName="y" begin="0s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/> </rect> <rect x="90" y="10" width="15" height="120" rx="6"> <animate attributeName="height" begin="0.25s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/> <animate attributeName="y" begin="0.25s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/> </rect> <rect x="120" y="10" width="15" height="120" rx="6"> <animate attributeName="height" begin="0.5s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite"/> <animate attributeName="y" begin="0.5s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite"/> </rect></svg></div></span>',
          'data-action' => 'getGeocodes',
          'label' => false
        )
      )
    ) );

    if ($type->getCurrentPostType() === 'property') {
      add_action('admin_enqueue_scripts', function() {
        wp_enqueue_script('ddpLiveGoogleMapsAPIAdmin');
        wp_enqueue_script('ddpPropertyAdmin');
      });
    }
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

    $vars = array(
      'properties' => $args['properties']
    );

    $response['html'] = base64_encode($this->view->makeView('ajax.listing', $vars));

    echo json_encode($response);
    die();
  }

  public function getPropertyDetailAjax()
  {
    $args = $_GET;
    check_ajax_referer('ddpLiveInteractive.js', 'key', true);
    $response = array();

    $vars = array(
      'property' => array_pop($this->model->getProperty($_GET['property_id']))
    );

    $response['html'] = base64_encode($this->view->makeView('ajax.detail', $vars));

    echo json_encode($response);
    die();
  }
}