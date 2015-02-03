<?php

namespace ddp\live;

class Property_Controller extends Controller
{
  public function actions()
  {

  }

  public function postType($type)
  {
    $foos = $type->scpt( 'foo', 'Foo', 'Foos' );

    $foos->add_meta_box( array(
      'id' => 'box-id',
      'context' => 'side',
      'fields' => array(
        'field-name' => array()
      )
    ) );
  }

  public function interactiveMap() {
    wp_enqueue_script('ddpProperties.js');
    wp_enqueue_style('ddpProperties.css');
    return $this->view->makeView('master');
  }
}