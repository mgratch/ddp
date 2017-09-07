<?php

namespace ddp\live;

class Property_Model extends Model
{

  public function actions() {
    // var_dump($this->findAll());
    // $this->findAll();
  }

  public function findAll()
  {
    $properties = array();
    $properties_posts = get_posts(array(
      'numberposts' => -1,
      'post_type'   => 'property'
    ));

    foreach ($properties_posts as $property) {
      $properties[] = $this->serializerProperty($property);
    }

    return $properties;
  }

  public function getProperty($id = false)
  {
    if (! $id) {
      return false;
    }

    $property = get_post($id);

    return $this->serializerProperty($property);
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
      $properties[] = $this->serializerProperty($property);
    }

    return $properties;
  }

  private function serializerProperty($property)
  {
    $newProperty = (object) array();
    $meta = Helpers::parseMeta(
      get_post_custom($property->ID),
      array('rent_listings')
    );

    $imageURL = function($image_id = false, $crop = 'full') {
      if ($image_id === false) {
        return false;
      }

      return wp_get_attachment_image_src(
        $image_id,
        $crop,
        false
      );
    };

    $filterMetaValues = function($values, $function) {
      return $function($values);
    };

    $newProperty->id = (string) $property->ID;
    $newProperty->title = $property->post_title;
    $newProperty->type = strtolower($meta['property_type']);
    if (!empty($meta['rent_listings'])) {
	    $newProperty->availability = $this->hasAvailable($meta['rent_listings']);
	  } else {
		  $newProperty->availability = false;
	  }
    $newProperty->agent = (object) array(
      'name'    => Helpers::emptySet($meta, 'property_agent_name', false),
      'phone'   => Helpers::emptySet($meta, 'property_agent_phone', false),
      'email'   => Helpers::emptySet($meta, 'property_agent_email', false),
      'website' => Helpers::emptySet($meta, 'property_agent_website', false)
    );
    if ($newProperty->type == 'sale') {
      $newProperty->sale = (object) array(
        'price'     => Helpers::emptySet($meta, 'property_price'),
        'bedrooms'  => Helpers::emptySet($meta, 'property_bedrooms', 0),
        'bathrooms' => Helpers::emptySet($meta, 'property_bathrooms'),
        'sq_feet'   => Helpers::emptySet($meta, 'property_sq_footage')
      );
    }
    if ($newProperty->type == 'rent') {
      $newProperty->rent = (object) array(
        'listings'     => $this->serializerListings($meta['rent_listings']),
        'attributes'    => (object) array(
          'pets'         => (bool) Helpers::emptySet($meta, 'property_pets', false),
          'fitness'      => (bool) Helpers::emptySet($meta, 'property_fitness', false),
          'washer_dryer' => (bool) Helpers::emptySet($meta, 'property_washer_dryer', false),
          'parking'      => (bool) Helpers::emptySet($meta, 'property_parking', false)
        ),
        'pricing' => $filterMetaValues($meta['rent_listings'], function($values) {
            $range = array(
              'lowest' => 9999999999999,
              'highest' => 0
            );

            foreach ($values as $listing) {
              if ($listing['property_price_high'] > (int) $range['highest']) {
                $range['highest'] = (int) $listing['property_price_high'];
              }

              if ($listing['property_price_low'] < (int) $range['lowest']) {
                $range['lowest'] = (int) $listing['property_price_low'];
              }
            }

            if ($range['lowest'] === 9999999999999) {
              $range['lowest'] = 0;
            }

            return (object) $range;
        })
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
    $newProperty->images = (object) array(
      'listingImage' => $imageURL(
        $meta['property_listing_photo'],
        'ddp-live-here-listing'
      ),
      'detailImages' => $filterMetaValues($meta['property_photos'], function($values) {
        if (empty($values)) {
          return false;
        }

        $photoURL = array();
        foreach ($values as $photo) {
          if (!empty($photo['photo'])) {
            $photoURL[] = wp_get_attachment_image_src(
              $photo['photo'],
              'full',
              null
            );
          }
        }

        return $photoURL;
      })
    );

    return $newProperty;
  }

  private function serializerListings(array $listings)
  {
    $newListings = array();

    foreach($listings as $listing) {
      $newListing = (object) array();
      $newListing->title = Helpers::emptySet($listing, 'unit_title');
      $newListing->bedrooms = Helpers::emptySet($listing, 'property_bedrooms', 0);
      $newListing->bathrooms = Helpers::emptySet($listing, 'property_bathrooms');
      $newListing->priceHigh = Helpers::emptySet($listing, 'property_price_high');
      $newListing->priceLow = Helpers::emptySet($listing, 'property_price_low');
      $newListing->sqFeetLow = Helpers::emptySet($listing, 'property_sq_footage_low');
      $newListing->sqFeetHigh = Helpers::emptySet($listing, 'property_sq_footage_high');
      $newListing->available = (bool) Helpers::emptySet($listing, 'property_available', false);

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