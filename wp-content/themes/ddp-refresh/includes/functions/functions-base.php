<?php
// Changes media link to default to none
update_option('image_default_link_type','none');
remove_action('wp_head', 'wp_generator');

// Filter Yoast Meta Priority
add_filter( 'wpseo_metabox_prio', function() { return 'low';} );

//CUSTOM LOGIN LOGO
function my_login_logo() { ?>
    <style type="text/css">
      body.login div#login h1 a {
        width: 100% !important;
        height: 150px !important;
        max-width: 320px;
        background-size: 100%;
        background-image: url(<?php echo get_template_directory_uri();?>/images/custom-login-logo.png);
        background-image: url(<?php echo get_template_directory_uri();?>/images/custom-login-logo.svg), none;
        background-position: center bottom;
      }
      .login form {
        margin-left: 0;
      }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// Changes login url to go to site home page
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

// Theme Support
add_theme_support( 'post-thumbnails' );
register_nav_menu(  'main', 'Main Menu in Header' );

/**
 * Gets post content by page or post slug
 * @param  string  $slug Post or page slug
 * @param  boolean $add_post_custom Adds get_post_custom results to post array
 * @return array post object
 */
function get_content_by_slug( $slug, $add_post_custom = false ) {
  global $wpdb;

  $id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_status = 'publish' ", $slug ) );

  if( !empty( $id ) )
    $post = get_post( $id );

  if( !empty( $id ) && !empty( $post ) ) {
    if( $add_post_custom ) {
      $post->post_custom = get_post_custom( $post->ID );
    }

    return $post;

  } else {
    return null;
  }
}

// Display numbered pagination with 'of' total pages - accepts an array from the paginate_links function
function displayNumberedPagination($pagination){
  $next = '';
  $last_page = '';
  $strHTML = '';

  for($intX = 0;$intX < count($pagination);$intX++){
    //take off the prev
    if(strpos($pagination[$intX],'prev') > 0){
      $strHTML .= $pagination[$intX];
      //unset($pagination[$intX]);
    } else if(strpos($pagination[$intX],'next') > 0){
      //take off the next
      $next = $pagination[$intX];
      //unset($pagination[$intX]);
    } else if ((strpos($pagination[count($pagination) -1],'next') > 0 && $intX == count($pagination) -2) || ($intX == count($pagination) -1) ){
      $last_page = $pagination[$intX];
    } else {
      //take off the dots
      //if(strpos($pagination[$intX],'dots') === false) {
      $strHTML .= $pagination[$intX];
      //  }

    }
  }

  if($next || $last_page){
    $strHTML .='<span>of</span>'.$last_page.$next;
  }

  return $strHTML;
}

// Allows RoyalSlider to auto update on post save for post sliders *MUST ADD CORRECT SLIDER NUMBER TO TRANSIENT BELOW*
function rs_clear_cache() {
  delete_transient( 'new-royalslider-posts-1' );
}
add_action( 'save_post', 'rs_clear_cache' );

// Custom excerpt displaying full paragraphs and read more link *user defined number of paragraphs*
function custom_excerpt_paragraphs($strText, $intParagraphs, $postId){
  preg_match_all('#<p>(.*)</p>#Us', wpautop($strText), $arrPara);
  $arrShown = array_slice($arrPara[0], 0, ($intParagraphs));
//For ...more inline directly after paragraph
  $arrShown[count($arrShown)-1] = str_replace("</p>","<a href='".get_permalink($postId). "' class='custom_excerpt_read_more'> …more</a></p>" , $arrShown[count($arrShown)-1]);
//For Read more in a new paragraph after paragraph
  //$arrShown[count($arrShown)-1] = str_replace("</p>","</p><a class='read-more-link' href='".get_permalink($postId). "'>Read more</a>" , $arrShown[count($arrShown)-1]);
  return implode("", $arrShown);
}

/**
 * Get Custom Excerpt from Content
 * @param  object $post  Post Object
 * @param  int $limit  Word limit
 * @param  string $read_more_text  Text for read more link. (bool) false for no link
 * @return string  Filtered (the_content) post excerpt.
 */
function get_custom_excerpt( $post, $limit, $read_more_text = 'Read More' )
{
  $excerpt = explode(' ', $post->post_content, $limit);
  if ( count($excerpt) >= $limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
  } else {
    $excerpt = implode(" ",$excerpt);
  }

  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);

  if( $read_more_text ) {
    $excerpt .= '<a class="read-more" href="'.get_permalink().'">'.$read_more_text.'</a>';
  }

  return apply_filters('the_content',$excerpt);
}

// Default excerpt custom length by number of words
function custom_excerpt_length( $length ) {
  return 55;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// Default excerpt read more link
function new_excerpt_more( $more ) {
  return '<a href="'. get_permalink() . '"> …more</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

/**
 * Utility function to clean single items out of nested array
 * @param unknown_type $atts
 * @return string
 */
function clean_meta( $customDataRaw, $dont_flatten = array() ) {
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

function cpt_select( $items, $values = array('slug'), $display = 'name' ) {

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


/**
 * Gets posts and adds all custom meta for that post to the post object. No matter how many results this is only 2 db queries.
 * @param  array  $args Standard get_posts args.
 * @param  bool  $flatten_meta (true) If meta value is a single result, make it the value. If it is an array, leave it as an array. (false) Add meta as it comes from WP with all values as array values.
 * @param array  $dont_flatten If $flatten_meta is true you can optionally manually define keys to not flatten. If left undefined it will flatten all keys if value is not multiple values.
 * @return array  An array of post objects
 */
function get_post_awesome( $args = array(), $flatten_meta = false, $dont_flatten = array() )
{
  global $wpdb;

  // Set the function to flatten and clean the meta.
  $clean_meta = function( $raw_meta ) use ( $dont_flatten ) {
    $customData = array();
      foreach( $raw_meta as $key => $data ) {
        $serialized = false;
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
  };

  // Get the posts
  $posts = get_posts( $args );

  // Return empty array if no posts are available
  if ( empty( $posts ) )
    return [];

  // Set vars
  $sql = [];
  $ids = [];
  $post_meta = [];

  // Extract post ids
  foreach ( $posts as $p )
    $ids[] = $p->ID;

  // Base db call for meta
  $sql[] = "SELECT post_id, meta_key, meta_value FROM {$wpdb->postmeta} WHERE post_id";

  // Set type of meta match
  if ( count( $ids ) > 1 ) {
    $ids = implode( ', ', $ids );
    $sql[] = "IN ({$ids})";
  } else {
    $sql[] = "= {$ids[0]}";
  }

  // Get the meta
  $meta = $wpdb->get_results( implode( ' ', $sql ) );

  // Format meta for post matching
  foreach ( $meta as $m ) {
    $post_meta[$m->post_id][$m->meta_key][] = $m->meta_value;
  }

  // Match post meta and add it to the post object
  foreach ( $posts as $key => $p )
    $posts[$key]->meta = ( $flatten_meta ? $clean_meta( $post_meta[$p->ID] ) : $post_meta[$p->ID] );


  // SCHWING... magic
  return $posts;
}

/**
 * Converts UTC to localized time based on time offset.
 * @param  int  $utc_time  UTC UNIX time string.
 * @param  mixed $offset (bool) true will get time offset set in the wp admin. (int) you can set the offset manually.
 * @param  mixed $time_zone (bool) false will not not add timezone abbreviation. (bool) true will add the timzone string from wp admin. (string) you can manually define the timezone string e.g. 'America/Detroit'.
 * @return array Local Time, Numeric offset, timezone abbreviation (conditonal)
 */
function io_time_to_local( $utc_time, $offset = true, $time_zone = false )
{
  // Get offset from wp settings
  if( $offset )
    $offset = ( $offset === true ? get_option('gmt_offset') : $offset );

  // Converts offset to seconds
  $offset_converted = (intval(abs($offset)) * 3600);

  // Fine local time
  if( $offset > 0 )
   $local_time =  $utc_time + $offset_converted;

   else
    $local_time =  $utc_time - $offset_converted;

  // Build output
  $local_time = [
      'time' => $local_time,
      'offset' => $offset
  ];

  // Time Zone
  if( $time_zone ) {
    $time_zone = ( $time_zone === true ? get_option('timezone_string') : $time_zone );

    /**
     * Gets the time zone abbreviation from the timezone string.
     * @param string Timezone string e.g. 'America/Detroit'
     */
    $time_zone_abbr = function( $timezone ) {
      $tz = new DateTimeZone( $timezone );

      $transitions = $tz->getTransitions();

      if( is_array($transitions) ) {
        foreach( $transitions as $k => $t ) {
          // look for current year
          if( substr( $t['time'], 0, 4)  == date('Y') ) {
              $trans = $t;
              break;
          }
        }
      }

      return ( !empty($trans) ? $trans['abbr'] : false );
    };


    $time_zone = $time_zone_abbr( $time_zone );

    // Logically add timezone
    if( $time_zone )
      $local_time['time_zone'] = $time_zone;
  }

  return $local_time;
}

$state_list = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois",'IN'=>"Indiana",'IA'=>"Iowa",'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland",'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma",'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");

function get_current_admin_post_type()
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

function get_current_admin_post_object()
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

class ioSitemap
{
	public function __construct()
	{
		$this->actions();
	}

  protected function actions()
  {
	  register_nav_menu('sitemap', 'Sitemap Menu');
	  add_shortcode('iositemap', [$this, 'shortcodeSitemap']);
  }

  public function shortcodeSitemap()
  {
		return wp_nav_menu(
	    [
	      'theme_location'  => 'sitemap',
	      'container'       => false,
	      'echo'            => false,
	      'menu_class'      => false,
	      'container_class' => false
	    ]
	  );
  }
}

/**
 * Menu modifactions to front-end standards
 */

// Map menu item class names
add_filter('nav_menu_css_class', function($classes, $item) {
  $origClasses = $classes;

  $classes = [
    'menu__item'
  ];

  if ($item->current) {
    $classes[] = 'menu__item-current';
  }

  if ($item->current_item_ancestor) {
    $classes[] = 'menu__item—current-item-ancestor';
  }

  if ($item->current_item_parent) {
    $classes[] = 'menu__item—current-item-parent';
  }

  if (in_array('menu-item-has-children', $origClasses)) {
    $classes[] = 'menu__item-has-children';
  }

  return $classes;
}, 10, 2 );

add_filter( 'nav_menu_link_attributes', function($atts, $item, $args){
  $atts['class'] = 'menu__link';

  return $atts;
}, 10, 3 );


// Set sub menu class name
class IODefaultWalker extends Walker_Nav_Menu
{
  /**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"menu menu--sub-menu\">\n";
	}
}
