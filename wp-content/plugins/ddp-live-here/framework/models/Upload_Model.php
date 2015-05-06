<?php

namespace ddp\live;

class Upload_Model extends Model
{

  protected $postType = 'property';

  public function addProperties($properties)
  {
    $transformed = $this->transformPropertyData($properties);

    foreach ($transformed as $pKey => $property) {
      $exists = false;
      $post_id = false;
      $keyExclude = array(
        'property_title',
        'rent',
        'sale',
        'property_latitude',
        'property_longitude'
      );

      // check to see if it exists by address

      // add
      if ($exists === false) {
        $post_id = wp_insert_post(array(
          'post_type' => $this->postType,
          'post_title' => $property->property_title,
          'post_content' => $property->property_description,
          'post_status' => 'publish'
        ));
      }

        // add Meta
        foreach ($property->data as $mKey => $metaValue) {
          if (!in_array($mKey, $keyExclude)) {
            update_post_meta(
              $post_id,
              $mKey,
              $metaValue
            );
          }

          if ($property->data->property_type === 'rent' && $mKey === 'rent') {
            foreach ($property->data->rent->attributes as $rKey => $rMeta) {
              update_post_meta(
                $post_id,
                $rKey,
                $rMeta
              );
            }

            // clear out listings
            delete_post_meta($post_id, 'rent_listings');

            foreach ($property->data->rent->listings as $listing) {
              add_post_meta(
                $post_id,
                'rent_listings',
                $listing
              );
            }
          }
        }

      // update

      // draft
    }
  }

  public function transformPropertyData($properties)
  {

    // Group listings together by title. Will make everything else easier
    $grouped = [];

    $calcPrice = function($price) {
      $priceOut = array(
        'low' => '',
        'high' => ''
      );

      if (preg_match('/-/', $price)) {
        $parts = explode('-', $price);
        $priceOut['low'] = $parts[0];
        $priceOut['high'] = $parts[1];
      } else {
        $priceOut['low'] = $price;
      }

      return (object) $priceOut;
    };

    foreach ($properties as $property) {
      $key = Helpers::sanitizeStr($property['property_title']);

      // Set initial property data
      if (!array_key_exists($key, $grouped)) {
        $grouped[$key] = (object) array(
          'property_title'         => $property['property_title'],
          'property_description'   => $property['description'],
          'data'          => (object) array(
            'property_type'          => $property['type'],
            'property_agent_name'    => Helpers::emptySet($property, 'agent_name', false),
            'property_agent_phone'   => Helpers::emptySet($property, 'agent_phone', false),
            'property_agent_email'   => Helpers::emptySet($property, 'agent_email', false),
            'property_agent_website' => Helpers::emptySet($property, 'agent_website', false),
            'property_address'       => $property['address'],
            'property_city'          => $property['city'],
            'property_state'         => $property['state'],
            'property_zip'           => $property['zip'],
            'property_latitude'      => $property['latitude'],
            'property_longitude'     => $property['longitude']
          )
        );

        // set up base structure
        if ($property['type'] === 'rent') {
          $grouped[$key]->data->rent = (object) array(
          'attributes' => (object) array(
            'property_pets'         => (bool) Helpers::emptySet($property, 'pets', false),
            'property_fitness'      => (bool) Helpers::emptySet($property, 'fitness', false),
            'property_washer_dryer' => (bool) Helpers::emptySet($property, 'washer_dryer', false),
            'property_parking'      => (bool) Helpers::emptySet($property, 'parking', false)
          ),
          'listings'   => array()
        );
        }
      }

      // if sale

      // if rental
      if ($property['type'] === 'rent') {
        $grouped[$key]->data->rent->listings[] = array(
          'unit_title'               => $property['unit_title'],
          'property_bedrooms'        => $property['bedrooms'],
          'property_bathrooms'       => $property['bathrooms'],
          'property_price_low'       => $calcPrice($property['price'])->low,
          'property_price_high'      => $calcPrice($property['price'])->high,
          'property_available'       => (bool) $property['available'],
          'property_sq_footage_low'  => '',
          'property_sq_footage_high' => ''
        );
      }
    }

    return $grouped;
  }
}