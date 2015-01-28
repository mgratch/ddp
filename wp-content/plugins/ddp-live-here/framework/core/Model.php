<?php

namespace sixlabs\sl_framework;

class Model
{
  protected $wpdb;
  protected $prefix;

  public function __construct()
  {
    global $wpdb;
    $config = Config::get('database');
    $this->wpdb = $wpdb;
    $this->prefix = $config['prefix'];

    if (isset($this->table_name) && isset($this->create)) {
      new Database(array(
        'table_name' => $this->table_name,
        'create' => $this->create
      ));
    }
  }
}