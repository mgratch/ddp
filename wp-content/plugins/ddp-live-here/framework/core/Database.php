<?php

namespace ddp\live;

class Database
{
  protected $wpdb;
  protected $table_name;
  protected $create;

  public function __construct($data = array())
  {
    global $wpdb;
    $this->wpdb = $wpdb;
    $this->table_name = $this->wpdb->prefix.$data['table_name'];
    $this->create = $data['create'];

    if (! $this->check()) {
      $this->create();
    }
  }

  public function check()
  {
    if ($this->wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'") != $this->table_name) {
      return false;
    }

    return true;
  }

  public function create()
  {
    $sql = array();
    $sql[] = "CREATE TABLE `{$this->table_name}` (";

    $columns = array();
    foreach ($this->create['columns'] as $name => $attributes) {
      $columns[] = "`{$name}` {$attributes}";
    }

    $sql[] = implode(",\r\n", $columns) . ",";

    $indexes = array();
    foreach ($this->create['indexes'] as $key => $index) {
      $indexes[] = $index;
    }

    $sql[] = implode(",\r\n", $indexes);

    $sql[] = ")";

    $this->wpdb->query(trim(implode("\r\n", $sql)));
  }
}