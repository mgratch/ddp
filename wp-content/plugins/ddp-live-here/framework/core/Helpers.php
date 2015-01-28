<?php

namespace sixlabs\sl_framework;

class Helpers
{
  public static function sanitizeStr($str)
  {
    $string = trim( $string );
    $string = preg_replace('/ /', '-', $string);
    $string = preg_replace('/[^A-Za-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);

    return strtolower( $string );
  }

  public static function parseOptions($items, $values = ['slug'], $display = 'name')
  {

    $select = array();
    foreach( $items as $item ) {
        //maybe detect if this is an object or an array then objectify it?
        if( is_object( $items ) || is_object( $items[0]) )
         $item = get_object_vars ($item );

         //build keys separated by '+' if needed
         $key = '';
         if(!empty($values) && is_array($values)){
            foreach($values as $value){
                   $key = $item[$value].'+';
            }
            $key=substr($key,0,strlen($key)-1);
         } elseif(!empty($values)) {
                $key= $item[$values];
         }

         //TODO - could build $display to work like $values, not sure it is needed
      $select[$key] = $item[$display];
    }

    return $select;
  }

  public static function create_unique_slug($string, $id = null, $table = null, $slug_col = null, $id_col = 'id')
  {
    global $wpdb;
    $slug = Helpers::sanitizeStr($string);

    if( !empty( $id ) ) {
      $old_slug = $wpdb->get_var( "SELECT {$slug_col} FROM {$table} WHERE {$id_col} = '{$id}'" );

      if( $slug == $old_slug )
        return $old_slug;

    }

    $query = function( $slug_col, $table, $slug ) {
      return $wpdb->get_results( "SELECT {$slug_col} FROM {$table} WHERE {$slug_col} = '{$slug}'" );
    };

    $check = $query( $slug_col, $table, $slug );

    if( !empty( $check ) ) {
      $orig_slug = $slug;
      $count = 2;
      while( $query( $slug_col, $table, $slug ) ) {
        $slug = $orig_slug . '-' . $count;
        $count++;
      }
    }

    return $slug;
  }

  public static function adminMessage($type = '', $message = '')
  {
    echo '<div id="message" class="'.esc_attr( $type ).'">'.wpautop( $message ).'</div>';
  }
}