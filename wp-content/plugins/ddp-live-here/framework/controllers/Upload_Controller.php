<?php

namespace ddp\live;

use League\Csv\Reader as Reader;

class Upload_Controller extends Controller
{
  public function actions()
  {
    add_action('admin_menu', array($this, 'registerPages'));
  }

  public function registerPages()
  {
    add_submenu_page(
      'edit.php?post_type=property',
      'DDP Property Data Upload',
      'Data Upload',
      'publish_posts',
      'ddp-property-upload',
      array($this, 'adminUpload')
    );
  }

  public function adminUpload()
  {
    if (!empty($_POST) && !empty($_FILES)) {
     $uploaded =  $this->handleUpload($_FILES);

      if ($uploaded['success']) {
        $process = $this->processData($uploaded['file']);
      }
    }

    $vars = array();

    echo $this->view->makeView('admin.upload', $vars);
  }

  public function handleUpload($file)
  {
    $success = false;
    $file = $file['data_upload'];
    $upload_file = $file['name'];
    $upload_dir = wp_upload_dir();
    $base_path = $upload_dir['basedir'];
    $upload_dir = $base_path . '/properties/';

    if (! is_dir($upload_dir)) {
      mkdir($upload_dir);
    }

    $uploaded = $upload_dir . basename($upload_file) ;

    if (move_uploaded_file($file['tmp_name'], $uploaded)) {
      $success = true;
    }

    return array(
      'success' => $success,
      'file'   => $uploaded
    );
  }

  public function processData($file)
  {
    $csv = Reader::createFromPath($file);
    $csv->setOffset(1);
    $properties = $csv->fetchAssoc(array(
      'property_title',
      'type',
      'unit_title',
      'bedrooms',
      'bathrooms',
      'price',
      'sq_foot',
      'pets',
      'fitness',
      'parking',
      'washer_dryer',
      'agent_name',
      'agent_phone',
      'agent_email',
      'agent_website',
      'address',
      'city',
      'zip',
      'state',
      'latitude',
      'longitude',
      'available',
      'description'
    ));

    $this->model->addProperties($properties);
  }
}