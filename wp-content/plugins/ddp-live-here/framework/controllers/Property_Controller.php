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
          'options' => array('sale' => 'Sale', 'rent' => 'Rent'),
          'data-js' => 'typeSelect'
        ),
        'property_agent_name' => array(
          'type' => 'text'
        ),
        'property_agent_phone' => array(
          'type' => 'text'
        ),
        'property_agent_email' => array(
          'type' => 'email'
        ),
        'property_agent_website' => array(
          'type' => 'text'
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

    $properties->add_meta_box( array(
      'id' => 'sale-attributes',
      'context' => 'normal',
      'fields' => array(
        'property_bedrooms' => array(
          'type' => 'text',
          'label' => 'Bedrooms'
        ),
        'property_bathrooms' => array(
          'type' => 'text',
          'label' => 'Bathrooms'
        ),
        'property_price' => array(
          'type' => 'text',
          'label' => 'Price'
        ),
        'property_sq_footage' => array(
          'type' => 'text',
          'label' => 'SQ Footage'
        )
      )
    ) );

    $properties->add_meta_box( array(
      'id' => 'rent-attributes',
      'context' => 'normal',
      'box_description' => '<p>For low / high value fields, if a range of values is not
       applicable, only fill in the "low" value field.</p>',
      'fields' => array(
        'property_pets' => array(
          'type' => 'checkbox',
          'label' => 'Pets'
        ),
        'property_fitness' => array(
          'type' => 'checkbox',
          'label' => 'Fitness'
        ),
        'property_washer_dryer' => array(
          'type' => 'checkbox',
          'label' => 'Washer / Dryer'
        ),
        'property_washer_dryer' => array(
          'type' => 'checkbox',
          'label' => 'Washer / Dryer'
        ),
        'property_parking' => array(
          'type' => 'checkbox',
          'label' => 'Parking Included'
        ),
        'rent_listings' => array(
          'type' => 'repeat',
          'fields' => array(
            'unit_title' => array(
              'type' => 'text',
              'field_description' => 'e.g. 1 Bedroom, 3 Bedroom'
            ),
            'property_bedrooms' => array(
              'type' => 'text',
              'label' => 'Bedrooms'
            ),
            'property_bathrooms' => array(
              'type' => 'text',
              'label' => 'Bathrooms'
            ),
            'property_price_low' => array(
              'type' => 'text',
              'label' => 'Price Low'
            ),
            'property_price_high' => array(
              'type' => 'text',
              'label' => 'Price High'
            ),
            'property_sq_footage_low' => array(
              'type' => 'text',
              'label' => 'SQ Footage Low'
            ),
            'property_sq_footage_high' => array(
              'type' => 'text',
              'label' => 'SQ Footage High'
            ),
            'property_available' => array(
              'type' => 'checkbox',
              'label' => 'Currently Available'
            )
          )
        )
      )
    ) );

    $properties->add_meta_box( array(
      'id' => 'property-photos',
      'context' => 'normal',
      'fields' => array(
        'property_listing_photo' => array(
          'type' => 'media',
          'field_description' => 'Minimum Size: 520px x 340px. Aspect Ratio: 26:17'
        ),
        'property_photos' => array(
          'type' => 'repeat',
          'fields' => array(
            'photo' => array(
              'type' => 'media',
              'field_description' => 'Minimum size: 1080px x 720px. Aspect Ratio: 3:2'
            )
          )
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

    echo json_encode($this->getProperties());
    die();
  }

  private function getProperties()
  {
    $response = false;
    $properties = $this->model->findAll();

    if ($properties) {
      $response = (object) array();
      $response->properties = $properties;
      $response->ranges = $this->getRanges($properties);
    }

    return $response;
  }

  private function getRanges(array $properties)
  {
    $ranges = array(
      'price' => array(
        'rent' => array(
          'min' => false,
          'max' => false
        ),
        'sale' => array(
          'min' => false,
          'max' => false
        )
      )
    );

    $prices = array(
      'rent' => array(),
      'sale' => array()
    );

    foreach ($properties as $property) {

      if ($property->type == 'rent') {
        foreach ($property->rent->listings as $listing) {
          $prices['rent'][] = $listing->priceHigh;
          $prices['rent'][] = $listing->priceLow;
        }
      }

      if ($property->type == 'sale') {
        $prices['sale'][] = $property->sale->price;
      }
    }

    if (!empty($prices['rent'])) {
      $ranges['price']['rent']['min'] = floor(min($prices['rent']) / 10) * 10;
    }
    if (!empty($prices['rent'])) {
      $ranges['price']['rent']['max'] = ceil(max($prices['rent']) / 10) * 10;
    }
    if (!empty($prices['sale'])) {
      $ranges['price']['sale']['min'] = floor(min($prices['sale']) / 10) * 10;
    }
    if (!empty($prices['sale'])) {
      $ranges['price']['sale']['max'] = ceil(max($prices['sale']) / 10) * 10;
    }

    return $ranges;  //.json_encode($properties);
  }

  public function getPropertyListingAjax()
  {
    $args = $_GET;
    check_ajax_referer('ddpLiveInteractive.js', 'key', true);
    $response = array();

    if (!empty($args['properties'])) {
      $properties = $this->model->getProperties($args['properties']);

      $vars = array(
        'properties' => $properties,
        'asset_url'   => Config::get('global.asset_uri')
      );

      $response['html'] = base64_encode($this->view->makeView('ajax.listing', $vars));
    } else {
      $response['html'] = base64_encode('<h2>No Listings</h2>');
    }

    echo json_encode($response);
    die();
  }

  public function getPropertyDetailAjax()
  {
    $args = $_GET;
    check_ajax_referer('ddpLiveInteractive.js', 'key', true);
    $response = array();

    $vars = array(
      'property' => $this->model->getProperty($args['propertyId'])
    );

    $response['html'] = base64_encode($this->view->makeView('ajax.detail', $vars));

    echo json_encode($response);
    die();
  }
}