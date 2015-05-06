<?php

namespace ddp\live;

class Helpers
{

  public static function adminMessage($type = '', $message = '')
  {
    echo '<div id="message" class="'.esc_attr( $type ).'">'.wpautop( $message ).'</div>';
  }

  public static function createUniqueSlug($string, $id = null, $table = null, $slug_col = null, $id_col = 'id')
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

  public static function emptySet($array, $key, $default = null)
  {
    return !empty($array[$key]) ? $array[$key] : $default;
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

  public static function sanitizeStr($str)
  {
    $string = trim( $str );
    $string = preg_replace('/ /', '-', $string);
    $string = preg_replace('/[^A-Za-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);

    return strtolower( $string );
  }

  /**
   * Utility function to clean single items out of nested array
   * @param unknown_type $atts
   * @return string
   */
  public static function parseMeta( $customDataRaw, $dont_flatten = array() ) {
    $customData = array();
    $serialized = false;
    foreach($customDataRaw as $key => $data){
      $unserialize_data = array();
      if(count($data) > 1 ) {
          foreach( $data as $d )
            if( @unserialize( $d ) ) {
              $unserialize_data[] = unserialize( $d );
              $serialized = true;
            }

          if( $serialized )
            $data = $unserialize_data;

          $customData[$key] = $data;
      } else {
          if( @unserialize( $data[0] ) )
            $data[0] = unserialize($data[0]);

          if ( !empty( $dont_flatten ) && in_array( $key, $dont_flatten ) ) {
            $customData[$key] = $data;
          } elseif ( !empty( $dont_flatten ) && !in_array( $key, $dont_flatten ) ) {
            $customData[$key] = $data[0];
          } else {
            $customData[$key] = $data[0];
          }
      }
    }

    return $customData;
  }

  /**
   * Utility function to clean single items out of nested array
   * @param unknown_type $atts
   * @return string
   */
  public static function cleanMeta( $customDataRaw, $dont_flatten = array() ) {
    $customData = array();
    $serialized = false;
    foreach($customDataRaw as $key => $data){
      $unserialize_data = array();
      if(count($data) > 1 ) {
          foreach( $data as $d )
            if( @unserialize( $d ) ) {
              $unserialize_data[] = unserialize( $d );
              $serialized = true;
            }

          if( $serialized )
            $data = $unserialize_data;

          $customData[$key] = $data;
      } else {
          if( @unserialize( $data[0] ) )
            $data[0] = unserialize($data[0]);

          if ( !empty( $dont_flatten ) && in_array( $key, $dont_flatten ) ) {
            $customData[$key] = $data;
          } elseif ( !empty( $dont_flatten ) && !in_array( $key, $dont_flatten ) ) {
            $customData[$key] = $data[0];
          } else {
            $customData[$key] = $data[0];
          }
      }
    }

    return $customData;
  }

}