<?php

namespace ddp\live;

class Property_Controller extends Controller
{
  public function actions()
  {

  }

  public function postType($type)
  {
    $foos = new Super_Custom_Post_Type( 'foo', 'Foo', 'Foos' );
  }
}