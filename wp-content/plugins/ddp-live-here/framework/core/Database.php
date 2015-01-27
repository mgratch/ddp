<?php

namespace sixlabs\sl_framework;

class Database
{
  protected $wpdb;

  public function __construct()
  {
    global $wpdb;
    $this->wpdb = $wpdb;
  }

  public function check($table_name)
  {

  }

  public function create($sql)
  {

  }
}