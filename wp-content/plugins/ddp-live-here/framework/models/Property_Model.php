<?php

namespace ddp\live;

class Property_Model extends Model
{

  public function findAll()
  {
    $properties = array();
    $properties_posts = get_posts(array(
      'numberposts' => -1,
      'post_type'   => 'property'
    ));

    foreach ($properties_posts as $property) {
      $properties[] = $this->transformerProperty($property);
    }

    return $properties;
  }

  public function getProperty($id = false)
  {
    if (! $id) {
      return false;
    }

    $property = get_post($id);

    return $this->parseMeta($property);
  }

  private function transformerProperty($property)
  {
    $newProperty = (object) array();
    $meta = Helpers::parseMeta(
      get_post_custom($property->ID),
      array('rent_listings')
    );

    $newProperty->id = (string) $property->ID;
    $newProperty->title = $property->post_title;
    $newProperty->type = strtolower($meta['property_type']);
    $newProperty->availability = $this->hasAvailable($meta['rent_listings']);
    $newProperty->agent = (object) array(
      'name'  => $meta['property_agent_name'],
      'phone' => $meta['property_agent_phone'],
      'email' => $meta['property_agent_email']
    );
    if ($newProperty->type == 'sale') {
      $newProperty->sale = (object) array(
        'price'     => $meta['property_price'],
        'bedrooms'  => $meta['property_bedrooms'],
        'bathrooms' => $meta['property_bathrooms'],
        'sq_feet'   => $meta['property_sq_footage']
      );
    }
    if ($newProperty->type == 'rent') {
      $newProperty->rent = (object) array(
        'listings' => $this->transformerListings($meta['rent_listings'])
      );
    }
    $newProperty->description = $property->post_content;
    $newProperty->features = $meta['property_features'];
    $newProperty->address = $meta['property_address'];
    $newProperty->city = $meta['property_city'];
    $newProperty->zip = $meta['property_zip'];
    $newProperty->state = $meta['property_state'];
    $newProperty->latitude = $meta['property_latitude'];
    $newProperty->longitude = $meta['property_longitude'];

    return $newProperty;
  }

  private function transformerListings(array $listings) {
    $newListings = array();

    foreach($listings as $listing) {
      $newListing = (object) array();
      foreach ($listing as $item) {
        $newListing->title = Helpers::emptySet($item, 'unit_title');
        $newListing->bedrooms = Helpers::emptySet($item, 'property_bedrooms');
        $newListing->bathrooms = Helpers::emptySet($item, 'property_bathrooms');
        $newListing->price = Helpers::emptySet($item, 'property_price');
        $newListing->sq_feet = Helpers::emptySet($item, 'property_sq_footage');
        $newListing->attribues = (object) array(
          'pets'         => Helpers::emptySet($item, 'property_pets'),
          'fitness'      => Helpers::emptySet($item, 'property_fitness'),
          'washer_dryer' => Helpers::emptySet($item, 'property_washer_dryer')
        );
        $newListing->available = Helpers::emptySet($item, 'property_available');
      }

      $newListings[] = $newListing;
    }

    return $newListings;
  }

  private function hasAvailable(array $listings) {
    $availibility = false;

    foreach ($listings as $listing) {
      if ((bool) $listing['property_available']) {
        $availibility = true;
        break;
      }
    }

    return $availibility;
  }
}