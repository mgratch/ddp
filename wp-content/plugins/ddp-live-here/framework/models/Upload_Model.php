<?php

namespace ddp\live;

class Upload_Model extends Model
{

  protected $postType = 'property';

  public function addProperties($properties)
  {

    $transformed = $this->transformPropertyData($properties);

    // check to see if it exists by address

    // add

      // add Meta

    // update

    // draft
  }

  public function transformPropertyData($properties)
  {

    // Group listings together by title. Will make everything else easier
    $grouped = [];

    foreach ($properties as $property) {
      $key = Helpers::sanitizeStr($property['property_title']);


    }

  }
}