<?php

namespace ddp\live;

class Property_Model extends Model
{
  // Things get a little weird here because this was a custom table
  // that was supposed to work off of apis but that changed to post types
  // so we ar transforming the data to work with the existing codebase

  public function findAll()
  {
    $properties = array();
    $properties_posts = get_posts(array(
      'numberposts' => -1,
      'post_type' => 'property'
    ));

    foreach ($properties_posts as $property) {
      $properties[] = $this->parseMeta($property);
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

  private function parseMeta($property)
  {
    $newProperty = (object) array();
    $meta = Helpers::parseMeta(get_post_custom($property->ID));

    if (empty($meta['property_term'])) {
      $meta['property_term'] == null;
    }

    $newProperty->id = (string) $property->ID;
    $newProperty->title = $property->post_title;
    $newProperty->type = strtolower($meta['property_type']);
    $newProperty->price = $meta['property_price'];
    $newProperty->term = $meta['property_term'];
    $newProperty->sq_footage = $meta['property_sq_footage'];
    $newProperty->rooms = $meta['property_rooms'];
    $newProperty->baths = $meta['property_bathrooms'];
    $newProperty->agent = $meta['property_agent_email'];
    $newProperty->description = $property->post_content;
    $newProperty->features = $meta['property_features'];
    $newProperty->address = $meta['property_address'];
    $newProperty->city = $meta['property_city'];
    $newProperty->zip = $meta['property_zip'];
    $newProperty->state = $meta['property_state'];
    $newProperty->latitude = $meta['property_latitude'];
    $newProperty->longitude = $meta['property_longitude'];
    // $newProperty->pictures = false;

    return $newProperty;
  }
}