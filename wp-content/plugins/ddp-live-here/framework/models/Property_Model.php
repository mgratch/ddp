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

    return $this->transformerProperty($property);
  }

  public function getProperties(array $propertyIds)
  {
    $properties = array();
    $property_posts = get_posts(array(
      'numberposts' => -1,
      'post_type'   => 'property',
      'post__in'    => $propertyIds
    ));

    foreach ($property_posts as $property) {
      $properties[] = $this->transformerProperty($property);
    }

    return $properties;
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
      'name'  => Helpers::emptySet($meta, 'property_agent_name'),
      'phone' => Helpers::emptySet($meta, 'property_agent_phone'),
      'email' => Helpers::emptySet($meta, 'property_agent_email')
    );
    if ($newProperty->type == 'sale') {
      $newProperty->sale = (object) array(
        'price'     => Helpers::emptySet($meta, 'property_price'),
        'bedrooms'  => Helpers::emptySet($meta, 'property_bedrooms'),
        'bathrooms' => Helpers::emptySet($meta, 'property_bathrooms'),
        'sq_feet'   => Helpers::emptySet($meta, 'property_sq_footage')
      );
    }
    if ($newProperty->type == 'rent') {
      $newProperty->rent = (object) array(
        'listings' => $this->transformerListings($meta['rent_listings'])
      );
    }
    $newProperty->description = $property->post_content;
    $newProperty->features = Helpers::emptySet($meta, 'property_features');
    $newProperty->address = Helpers::emptySet($meta, 'property_address');
    $newProperty->city = Helpers::emptySet($meta, 'property_city');
    $newProperty->zip = Helpers::emptySet($meta, 'property_zip');
    $newProperty->state = Helpers::emptySet($meta, 'property_state');
    $newProperty->latitude = Helpers::emptySet($meta, 'property_latitude');
    $newProperty->longitude = Helpers::emptySet($meta, 'property_longitude');

    return $newProperty;
  }

  private function transformerListings(array $listings)
  {
    $newListings = array();

    foreach($listings as $listing) {
      $newListing = (object) array();
      $newListing->title = Helpers::emptySet($listing, 'unit_title');
      $newListing->bedrooms = Helpers::emptySet($listing, 'property_bedrooms');
      $newListing->bathrooms = Helpers::emptySet($listing, 'property_bathrooms');
      $newListing->priceHigh = Helpers::emptySet($listing, 'property_price_high');
      $newListing->priceLow = Helpers::emptySet($listing, 'property_price_low');
      $newListing->sqFeetLow = Helpers::emptySet($listing, 'property_sq_footage_low');
      $newListing->sqFeetHigh = Helpers::emptySet($listing, 'property_sq_footage_high');
      $newListing->attribues = (object) array(
        'pets'         => (bool) Helpers::emptySet($listing, 'property_pets', false),
        'fitness'      => (bool) Helpers::emptySet($listing, 'property_fitness', false),
        'washer_dryer' => (bool) Helpers::emptySet($listing, 'property_washer_dryer', false)
      );
      $newListing->available = Helpers::emptySet($listing, 'property_available');

      $newListings[] = $newListing;
    }

    return $newListings;
  }

  // private function getListingPrice(array $args)
  // {
  //   $args = array_merge(array(
  //     'property' => false,
  //     'type' => false
  //   ), $args);

  //   if ($args['type'] == 'rent') {

  //   }

  //   if ($args['type'] == 'buy') {

  //   }
  // }

  private function hasAvailable(array $listings)
  {
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