<?php

namespace ddp\live;

class Type
{

  protected $state_list = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois",'IN'=>"Indiana",'IA'=>"Iowa",'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland",'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma",'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");

  public function cptSelect( $items, $values = array('slug'), $display = 'name' )
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

  public function getCurrentPostObject()
  {
    if( isset($_GET['post']) || isset($_POST['post_ID']) ) {
      $post_id = isset($_GET['post']) ? $_GET['post'] : $_POST['post_ID'] ;
      $post_obj = get_post( $post_id );
      $post_obj->template = get_post_meta($post_id,'_wp_page_template',TRUE);
    } else {
      $post_obj = new stdClass;
      $post_obj->template = null;
    }

    return $post_obj;
  }

  public function getCurrentPostType()
  {
    if ( isset( $_GET['post_type'] ) ) {
      $current_post_type = $_GET['post_type'];
    } elseif ( isset( $_GET['post'] ) ) {
      $current_post_type = get_post_type( $current_post_type = $_GET['post'] );
    } elseif ( isset( $_POST['post_ID'] ) ) {
      $current_post_type = get_post_type( $current_post_type = $_POST['post_ID'] );
    } else {
      $current_post_type = null;
    }

    return $current_post_type;
  }

}