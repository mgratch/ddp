<?php

namespace ddp\live;

class Property_Model extends Model
{
  protected $table_name = 'properties';
  protected $create = array(
    'columns' => array(
      'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
      'title' => 'varchar(255) DEFAULT NULL',
      'type' => 'varchar(10) DEFAULT NULL',
      'price' => 'int(11) DEFAULT NULL' ,
      'term' => 'varchar(10) DEFAULT NULL',
      'sq_footage' => 'int(11) DEFAULT NULL',
      'rooms' => 'varchar(10) DEFAULT NULL',
      'agent' => 'varchar(128) DEFAULT NULL',
      'description' => 'varchar(255) DEFAULT NULL',
      'features' => 'varchar(255) DEFAULT NULL',
      'pictures' => 'varchar(255) DEFAULT NULL',
      'address' => 'varchar(128) DEFAULT NULL',
      'city' => 'varchar(128) DEFAULT NULL',
      'zip' => 'varchar(10) DEFAULT NULL',
      'state' => 'varchar(2) DEFAULT NULL',
      'latitude' => 'varchar(128) DEFAULT NULL',
      'longitude' => 'varchar(128) DEFAULT NULL'
    ),
    'indexes' => array(
      'PRIMARY KEY (`id`)',
      'KEY `type` (`type`)'
    )
  );

  function actions()
  {

  }
}