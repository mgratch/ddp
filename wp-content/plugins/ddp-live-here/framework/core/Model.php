<?php

namespace ddp\live;

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
    $this->table_name = $this->prefix.$this->table_name;

    if (isset($this->table_name) && isset($this->create)) {
      new Database(array(
        'table_name' => $this->table_name,
        'create' => $this->create
      ));
    }

    if (method_exists($this, 'actions')) {
      $this->actions();
    }
  }

  public function findAll()
  {
    if (empty($this->table_name)) {
      return false;
    }

    $sql = trim("
      SELECT *
      FROM   {$this->table_name}
    ");

    $results = $this->wpdb->get_results($sql);

    if (empty($results)) {
      return false;
    }

    return $results;
  }
}