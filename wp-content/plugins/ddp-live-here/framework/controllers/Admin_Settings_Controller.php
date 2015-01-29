<?php

namespace ddp\live;

class Admin_Settings_Controller extends Controller
{
  public function actions(){

  }

  public function postType($type)
  {
    $foos = $type->scpt( 'bar', 'Bar', 'Bars' );

    $foos->add_meta_box( array(
      'id' => 'box-id',
      'context' => 'side',
      'fields' => array(
        'field-name' => array()
      )
    ) );
  }
}