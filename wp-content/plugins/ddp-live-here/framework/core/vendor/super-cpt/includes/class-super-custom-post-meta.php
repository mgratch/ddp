<?php

namespace ddp\live;

$scpt_known_custom_fields = array();

/**
* Easy as pie Custom post meta
*/
class Super_Custom_Post_Meta extends Super_CPT {


  /**
   * Holds our meta boxes which get added later by WordPress
   *
   * @var array
   */
  public $boxes;


  /**
   * Have we set the action yet to add our custom meta boxes?
   *
   * @var bool
   */
  public $registered_meta_boxes_action = false;


  /**
   * Have we set the action yet to add our datepicker JS and CSS?
   *
   * @var bool
   */
  public $registered_datepicker = false;


  /**
   * Have we set the action yet to add our datepicker JS and CSS?
   *
   * @var bool
   */
  public $registered_media = false;


  /**
   * Has the nonce field been printed yet?
   *
   * @var bool
   */
  public $printed_nonce = false;


  /**
   * The nonce key name to use to validate data source; this will pump in CPT slug via sprintf
   *
   * @var string
   */
  public $nonce_key = 'scpt_%s_custom_meta_nonce';


  /**
   * HTML tag with which to wrap individual field elements (and labels, where appropriate)
   *
   * @var string
   */
  public $field_wrapper = 'div';


  /**
   * Store field names to verify POST validity
   *
   * @var array
   */
  public $field_names = array();

  public $repeat_field_names = array();


  public $columns = array();


  public $registered_custom_columns;


  /**
   * The size the thumbnail should be in the column view. This can be set with the filter 'scpt_plugin_column_thumbnail_size'
   *
   * @var mixed
   */
  public $column_thumbnail_size;

  /**
   * Construct a new Super_Custom_Post_Meta object for the given post type
   *
   * @param string $post_type The post type these boxes will apply to
   * @author Matthew Boynes
   */
  public function __construct( $post_type ) {
    $this->type = $post_type;
  }

  /**
   * Add custom meta box
   *
   * @uses SCPT_Markup::labelify
   * @uses register_meta_boxes_action
   * @uses meta_html
   * @param array $attr The meta box attributes. See {@link http://codex.wordpress.org/Function_Reference/add_meta_box}
   * @return void
   * @author Matthew Boynes
   */
  public function add_meta_box( $attr = array() ) {
    global $scpt_known_custom_fields;


    if ( empty( $attr ) || !isset( $attr['fields'] ) || !isset( $attr['id'] ) ) return;

    if ( !isset( $attr['title'] ) )
      $attr['title'] = SCPT_Markup::labelify( $attr['id'] );

    $attr = array_merge( array(
      'callback' => array( $this, 'meta_html' ),
      'page' => $this->type,
      'context' => 'advanced',
      'priority' => 'default'
    ), $attr );

    # Fields can optionally be numerically indexed with the individual field arrays having the 'meta_key' array index set
    if ( !$this->is_assoc( $attr['fields'] ) ) {
      $new_fields = array();
      foreach ( $attr['fields'] as $field ) {
        $new_fields[ $field['meta_key'] ] = $field;
      }
      $attr['fields'] = $new_fields;
    }

    foreach ( $attr['fields'] as $meta_key => $field ) {
      $attr['fields'][ $meta_key ]['meta_key'] = $meta_key;

      $this->field_names[] = $meta_key;
      if ( !isset( $field['type'] ) )
        $attr['fields'][ $meta_key ]['type'] = $field['type'] = 'text';

      if ( isset( $field['column'] ) && true == $field['column'] ) {
        $this->add_to_columns(
          ( isset( $field['label'] ) ? array( $meta_key => $field['label'] ) : $meta_key )
        );
      }

      if ( ! isset( $field['default'] ) ) {
        $field['default'] = '';
      }

      if ( 'date' == $field['type'] ) $this->register_datepicker();
      elseif ( 'media' == $field['type'] ) $this->register_media();
      elseif ( 'wysiwyg' == $field['type'] ) $attr['fields'][ $meta_key ]['context'] = $attr['context'];
      else $this->register_media();

      if ( isset( $field['data'] ) )
        $scpt_known_custom_fields[ $this->type ][ $meta_key ] = array( 'data' => $field['data'] );
      elseif ( 'select' == $field['type'] && isset( $field['multiple'] ) )
        $scpt_known_custom_fields[ $this->type ][ $meta_key ] = 'multiple_select';
      else
        $scpt_known_custom_fields[ $this->type ][ $meta_key ] = $field['type'];
    }

    $this->boxes[] = $attr;

    $this->register_meta_boxes_action();
  }


  /**
   * Add many custom meta boxes
   *
   * @uses add_meta_box
   * @see add_meta_box
   * @param array Arrays to be passed to add_meta_box; you can pass unlimited params to this method
   * @return void
   * @author Matthew Boynes
   */
  public function add_meta_boxes() {
    $boxes = func_get_args();
    foreach ( $boxes as $box ) $this->add_meta_box( $box );
  }


  /**
   * Hook our meta boxes into WordPress
   *
   * @uses register_meta_boxes
   * @see register_meta_boxes
   * @return void
   * @author Matthew Boynes
   */
  public function register_meta_boxes_action() {
    if ( !$this->registered_meta_boxes_action ) {
      add_action( 'add_meta_boxes_' . $this->type, array( $this, 'register_meta_boxes' ) );
      add_action( 'save_post', array( $this, 'save_meta' ) );
      $this->registered_meta_boxes_action = true;
    }
  }


  /**
   * Add meta boxes to WordPress
   *
   * @see registered_meta_boxes_action
   * @return void
   * @author Matthew Boynes
   */
  public function register_meta_boxes() {
    foreach ( $this->boxes as $box ) {
      add_meta_box(
        $box['id'],
        $box['title'],
        $box['callback'],
        $box['page'],
        $box['context'],
        $box['priority'],
        $box
      );
    }
  }


  /**
   * Outputs the HTML for the meta boxes to be used in the WP admin
   *
   * @param object $post the 'post' object
   * @param array $box array of arguments passed to this function
   * @return void
   * @author Matthew Boynes
   */
  public function meta_html( $post, $box ) {
    $box = $box['args'];

    $fields = $box['fields'];
    // Use nonce for verification
    if ( ! $this->printed_nonce ) {
      wp_nonce_field( plugin_basename( __FILE__ ), sprintf( $this->nonce_key, $this->type ) );
      $this->printed_nonce = true;
    }

    if( !empty( $box['box_description'] ) )
        echo '<div class="scpt-box-description">'.$box['box_description'].'</div>';

    $post_meta = get_post_custom( $post->ID );
    foreach ( $fields as $field ) {
      // array( 'meta_key' => 'event_date', 'name' => 'Event Date', 'type' => 'text' ),
      // array( 'meta_key' => 'active', 'name' => 'Active', 'type' => 'checkbox' )
      if( $field['type'] == 'repeat' ) {
        $this->repeat_field_names[] = $field['meta_key'];

        $repeat_meta = isset( $post_meta[$field['meta_key']] ) ? $post_meta[$field['meta_key']] : array();
        $count = ( count( $repeat_meta ) > 0 ? count( $repeat_meta ) : 1 );

        $container_title = isset( $field['label'] ) ? $field['label'] : SCPT_Markup::labelify( $field['meta_key'] );

        echo '<div class="scpt-repeat-group-container" data-scpt-repeat-group-container>';
        echo '<div class="scpt-repeat-group-container-title"><span>'.$container_title.'<span><span class="scpt-repeat-group-container-toggle" data-toggle-container><i class="scpt-icon-toggle-open"></i></span></div><div class="scpt-repeat-group-container-content" data-scpt-group-container-content>';

        for ( $i= 0; $i < $count; $i++ ) {

          echo '<div class="scpt-repeat-group" data-scpt-repeat-group><div class="scpt-repeat-group-head cf"><span data-group-title>'.( $i + 1).'</span><span class="scpt-repeat-group-toggle" data-toggle-group><i class="scpt-icon-toggle-open"></i></span><span class="scpt-repeat-controls"><i class="scpt-icon-up" data-scpt-up></i><i class="scpt-icon-down" data-scpt-down></i><i class="scpt-icon-minus" data-scpt-remove></i><i class="scpt-icon-plus" data-scpt-add></i></span></div><div class="scpt-repeat-group-content">';

          foreach ( $field['fields'] as $r_key => $r_field ) {
            $r_field['meta_key'] = $r_key;
            $r_field['name'] = $field['meta_key'].'['.$i.']'.'['.$r_key.']';
            $r_field['data-name-prefix'] = $field['meta_key'];
            $r_field['data-name'] = $r_key;
            $meta = !empty( $repeat_meta[$i] ) ? unserialize( $repeat_meta[$i] ) : array();
            $field_meta = array();
            foreach( $meta as $m_key => $p_meta )
              if( !is_array( $p_meta ) )
                $field_meta[$m_key] = array( $p_meta );
              else
                $field_meta[$m_key] = $p_meta;

            $this->add_field( $r_field, $field_meta );
          }

          echo '</div></div>';
        }

        echo '</div></div>';
      } else {
        $field['name'] = $field['meta_key'];
        $this->add_field( $field, $post_meta );
      }
    }
  }


  /**
   * Add a field to a meta box. Sorts out what kind of field it is, and calls the appropriate method to output it
   *
   * @uses parse_attributes
   * @uses get_external_data
   * @uses SCPT_Markup::labelify
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @return void
   * @author Matthew Boynes
   */
  public function add_field( $field, $post_meta ) {
    if ( !isset( $field['label'] ) ) $field['label'] = SCPT_Markup::labelify( $field['meta_key'] );

    if ( isset( $field['data'] ) ) $field['options'] = $this->get_external_data( $field['data'] );

    $html_attributes = apply_filters( 'scpt_plugin_meta_field_addt_html_attributes', $this->parse_attributes( $field ) );
    $field_callback = apply_filters( 'scpt_plugin_meta_field_callback', array( $this, "add_{$field['type']}_field" ), $field );

    echo '<', $this->field_wrapper, ' class="', $field['meta_key'], '-wrap scpt-field-wrap">', "\n";
    if ( ( is_array( $field_callback ) && method_exists( $field_callback[0], $field_callback[1] ) ) || ( !is_array( $field_callback ) && function_exists( $field_callback ) ) )
      call_user_func( $field_callback, $field, $post_meta, $html_attributes );
    else
      call_user_func( array( $this, "add_text_field" ), $field, $post_meta, $html_attributes );

    if( isset($field['field_description']) )
      echo '<div class="scpt-field-description">' . $field['field_description'] . '</div>';

    echo '</'. $this->field_wrapper . '>';
  }

  /*
   * =========================
   * =      Meta Fields      =
   * =========================
   */

  /**
   * Add a text field to a meta box
   *
   * @uses SCPT_Markup::tag
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author Matthew Boynes
   */
  public function add_text_field( $field, $post_meta, $html_attributes ) {
    if ( ! isset( $field['default'] ) ) {
        $field['default'] = '';
    }

    if ( false !== $field['label'] )
      echo SCPT_Markup::tag( 'label', array(
          'for' => 'scpt_meta_' . $field['meta_key'],
          'class' => 'scpt-meta-label scpt-meta-text label-' . $field['meta_key']
        ), $field['label'] );
    echo SCPT_Markup::tag( 'input', array_merge( array(
        'type' => $field['type'],
        'value' => ( isset( $post_meta[ $field['meta_key'] ] ) ? $post_meta[ $field['meta_key'] ][0] : $field['default'] ),
        'name' => $field['name'],
        'class' => 'scpt-field',
        'id' => 'scpt_meta_' . $field['meta_key']
      ), $html_attributes ) );
  }

  /**
   * Add a section title
   *
   * @uses SCPT_Markup::tag
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author TJ Miller
   */
  public function add_section_title_field( $field, $post_meta, $html_attributes ) {
    if ( ! isset( $field['default'] ) ) {
        $field['default'] = '';
    }

    echo SCPT_Markup::tag( 'div', array_merge( array(
        'class' => 'scpt-section-title'
      ), $html_attributes ), ucwords( $field['section_title']) );
  }



  /**
   * Add a button field to a meta box
   *
   * @uses SCPT_Markup::tag
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author TJ Miller
   */
  public function add_button_field( $field, $post_meta, $html_attributes ) {
    if ( ! isset( $field['default'] ) ) {
        $field['default'] = '';
    }

    if ( false !== $field['label'] )
      echo SCPT_Markup::tag( 'label', array(
          'for' => 'scpt_meta_' . $field['meta_key'],
          'class' => 'scpt-meta-label scpt-meta-text label-' . $field['meta_key']
        ), $field['label'] );

    echo '<button type="button" '.SCPT_Markup::attributes(array_merge( array( 'class' => 'button button-primary button-large' ), $html_attributes ) ).'>'.(!empty( $field['button_text'] ) ? $field['button_text'] : 'Button').'</button>';
  }


  /**
   * Add a textarea field to a meta box
   *
   * @uses SCPT_Markup::tag
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author Matthew Boynes
   */
  public function add_textarea_field( $field, $post_meta, $html_attributes ) {
    if ( ! isset( $field['default'] ) ) {
      $field['default'] = '';
    }

    if ( false !== $field['label'] )
      echo SCPT_Markup::tag( 'label', array(
          'for' => 'scpt_meta_' . $field['meta_key'],
          'class' => 'scpt-meta-label scpt-meta-textarea label-' . $field['meta_key']
        ), $field['label'] );
    echo SCPT_Markup::tag(
      'textarea',
      array_merge( array(
        'name' => $field['name'],
        'class' => 'scpt-field',
        'id' => 'scpt_meta_' . $field['meta_key']
      ), $html_attributes ),
      ( isset( $post_meta[ $field['meta_key'] ] ) ? $post_meta[ $field['meta_key'] ][0] : $field['default'] )
    );
  }


  /**
   * Add a wysiwyg field to a meta box
   *
   * @uses SCPT_Markup::tag
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author Matthew Boynes
   */
  public function add_wysiwyg_field( $field, $post_meta, $html_attributes ) {
    if ( ! isset( $field['default'] ) ) {
      $field['default'] = '';
    }

    // $this->editors[] = 'scpt_meta_' . $field['meta_key'];
    // return $this->add_textarea_field( $field, $post_meta, $html_attributes, true );
    $editor_settings = apply_filters( 'scpt_plugin_custom_meta_wysiwyg_settings', array(
      'teeny' => ( 'side' == $field['context'] ),
      'textarea_rows' => ( 'side' == $field['context'] ? '15' : '10' )
    ), $field );
    if ( 'side' == $field['context'] )
      add_filter( 'teeny_mce_before_init', array( $this, 'teeny_mce_before_init' ), 10, 2 );

    if ( false !== $field['label'] )
      echo SCPT_Markup::tag( 'label', array(
          'for' => 'scpt_meta_' . $field['meta_key'],
          'class' => 'scpt-meta-label scpt-meta-wysiwyg label-' . $field['meta_key']
        ), $field['label'] );
    wp_editor(
      ( isset( $post_meta[ $field['meta_key'] ] ) ? $post_meta[ $field['meta_key'] ][0] : $field['default'] ),
      $field['meta_key'],
      $editor_settings
    );
  }


  /**
   * Filter function for editors in sidebars. This prunes down the toolbars so it fits nicely. See teeny_mce_before_init WP filter
   *
   * @param array $mceInit Array of TinyMCE Editor settings, which we manipulate
   * @param string $editor_id
   * @return void
   * @author Matthew Boynes
   */
  public function teeny_mce_before_init( $mceInit, $editor_id ) {
    $mceInit['theme_advanced_buttons1'] = 'bold,italic,separator,link,unlink,separator,bullist,numlist,separator,wp_adv,fullscreen';
    $mceInit['theme_advanced_buttons2'] = 'formatselect,justifyleft,justifycenter,justifyright,undo,redo';
    return $mceInit;
  }

  /**
   * Add a checkbox field to a meta box whose values is either 1 or 0
   *
   * @uses SCPT_Markup::tag
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author Matthew Boynes
   */
  public function add_boolean_field( $field, $post_meta, $html_attributes ) {
    if ( ! isset( $field['default'] ) ) {
      $field['default'] = '';
    }

    $args = array_merge( array(
      'type' => 'checkbox',
      'value' => '1',
      'name' => $field['name'],
      'class' => 'scpt-field',
      'id' => 'scpt_meta_' . $field['meta_key']
    ), $html_attributes );
    if ( ( isset( $post_meta[ $field['meta_key'] ] ) && '1' == $post_meta[ $field['meta_key'] ][0] ) || ( ! isset( $post_meta[ $field['meta_key'] ] ) && 'checked' == $field['default'] ) )
      $args['checked'] = 'checked';
    echo
      SCPT_Markup::tag( 'input', array( 'type' => 'hidden', 'name' => $field['name'], 'value' => '0' ) ),
      SCPT_Markup::tag( 'label', array(
        'for' => $args['id'],
        'class' => 'scpt-meta-label choice scpt-meta-checkbox label-' . $field['meta_key']
      ), SCPT_Markup::tag( 'input', $args ) . ' ' . $field['label'] );
  }


  /**
   * Add multiple checkbox fields to a meta box, all with the same name
   *
   * @uses SCPT_Markup::tag
   * @uses add_boolean_field
   * @uses prune_options
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author Matthew Boynes
   */
  public function add_checkbox_field( $field, $post_meta, $html_attributes ) {
    # First see if this field has options. If not, we can do a boolean checkbox instead
    if ( ! isset( $field['options'] ) )
      return $this->add_boolean_field( $field, $post_meta, $html_attributes );

    if ( ! isset( $field['default'] ) ) {
      $field['default'] = '';
    }

    $field['name'] =  $field['name'] . '[]';

    $args = array_merge( array(
      'type' => 'checkbox',
      'class' => 'scpt-field choice',
      'id' => 'scpt_meta_' . $field['meta_key']
    ), $html_attributes, array( 'name' => $field['name']) );

    if ( false !== $field['label'] )
      echo SCPT_Markup::tag( 'label', array(
          'class' => 'scpt-meta-label scpt-meta-checkbox label-' . $field['meta_key']
        ), $field['label'] );
    echo '<span class="scpt-option">' . implode( "</span>\n<span class=\"scpt-option\">", $this->prune_options( $field['options'], $field['meta_key'], $post_meta, $args, 'input', $field['default'] ) ) . '</span>';
  }


  /**
   * Add multiple radio fields to a meta box, all with the same name
   *
   * @uses SCPT_Markup::tag
   * @uses add_boolean_field
   * @uses prune_options
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author Matthew Boynes
   */
  public function add_radio_field( $field, $post_meta, $html_attributes ) {
    # First see if this field has multiple options. If not, you're an idiot and we should do a checkbox instead
    if ( ! isset( $field['options'] ) || 1 == count( $field['options'] ) )
      return $this->add_checkbox_field( $field, $post_meta, $html_attributes );

    $args = array_merge( array(
      'type' => 'radio',
      'name' => $field['name'],
      'class' => 'scpt-field choice',
      'id' => 'scpt_meta_' . $field['meta_key']
    ), $html_attributes );

    if ( false !== $field['label'] )
      echo SCPT_Markup::tag( 'label', array(
          'class' => 'scpt-meta-label scpt-meta-radio label-' . $field['meta_key']
        ), $field['label'] );
    echo '<span class="scpt-option">' . implode( "</span>\n<span class=\"scpt-option\">", $this->prune_options( $field['options'], $field['meta_key'], $post_meta, $args, 'input', $field['default'] ) ) . '</span>';
  }


  /**
   * Add select field to a meta box
   *
   * @uses SCPT_Markup::tag
   * @uses add_boolean_field
   * @uses prune_options
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author Matthew Boynes
   */
  public function add_select_field( $field, $post_meta, $html_attributes ) {
    if ( ! isset( $field['default'] ) ) {
      $field['default'] = '';
    }

    $field['name'] = $field['name'] . ( isset( $html_attributes['multiple'] ) ? '[]' : '' );

    $options = implode( "\n", $this->prune_options( $field['options'], $field['meta_key'], $post_meta, array(), 'option', $field['default'] ) );
    if ( !isset( $html_attributes['multiple'] ) && !( isset( $field['prompt'] ) && false === $field['prompt'] ) )
      $options = '<option value="">' . ( isset( $field['prompt'] ) ? $field['prompt'] : 'Choose one' ) . '</option>' . $options;

    if ( false !== $field['label'] )
      echo SCPT_Markup::tag( 'label', array(
          'class' => 'scpt-meta-label scpt-meta-select label-' . $field['meta_key']
        ), $field['label'] );
    echo SCPT_Markup::tag( 'select', array_merge( array(
        'class' => 'scpt-field',
        'id' => 'scpt_meta_' . $field['meta_key']
      ), $html_attributes, array( 'name' => $field['name']) ), $options );
  }


  /**
   * Add media field to a meta box
   *
   * @uses SCPT_Markup::tag
   * @param array $field The field information
   * @param array $post_meta The post meta from the database
   * @param array $html_attributes HTML attributes to be passed to element
   * @return void
   * @author Matthew Boynes
   */
  public function add_media_field( $field, $post_meta, $html_attributes ) {
    $value = ( isset( $post_meta[ $field['meta_key'] ][0] ) ? $post_meta[ $field['meta_key'] ][0] : '' );
    if ( $value ) {
      $attachment = get_post( $value );
      if ( strpos( $attachment->post_mime_type, 'image/' ) === 0 ) {
        $preview = sprintf( '%s<br />', __( 'Uploaded image:', 'super-cpt' ) );
        $preview_size = ( !empty( $html_attributes['preview_size'] ) ? $html_attributes['preview_size'] : 'full' );
        $preview .= '<div class="scpt-media-container">'.wp_get_attachment_image( $value, $preview_size, false, array( 'class' => 'scpt-thumbnail media-preview' ) ).'</div>';
      } else {
        $preview = sprintf( '%s', __( 'Uploaded file:', 'super-cpt' ) ) . '&nbsp;';
        $preview .= wp_get_attachment_link( $value, 'thumbnail', true, true, $attachment->post_title );
      }
      $preview .= sprintf( '<br /><a href="#" class="scpt-remove-thumbnail button button-primary button-medium">%s</a>', __( 'Remove', 'super-cpt' ) );
    } else {
      $preview = '';
    }

    $button_text = 'Set Media';

    if ( false !== $field['label'] )
      echo SCPT_Markup::tag( 'label', array(
          'class' => 'scpt-meta-label scpt-meta-select label-' . $field['name']
        ), $field['label'] );

    if( !empty( $field['label'] ) )
      $button_text = 'Set ' . $field['label'];

    if( !empty( $field['button_text'] ) )
      $button_text = $field['button_text'];

    echo SCPT_Markup::tag( 'div', array( 'class' => 'scpt-media-preview' ), $preview );
    echo SCPT_Markup::tag( 'p', '',
      SCPT_Markup::tag( 'a', array_merge( array(
      'href'  => '#',
      'class' => 'scpt-add-media button button-primary button-medium',
      'style' => ( $value ? 'display:none' : '' )
      ), $html_attributes ), sprintf( __( '%s', 'super-cpt' ), $button_text ) )
    );
    echo SCPT_Markup::tag( 'input', array(
      'type'  => 'hidden',
      'value' => $value,
      'name'  => $field['name'],
      'class' => 'scpt-media-id',
      'id'    => 'scpt_meta_' . $field['name']
    ) );
  }


  /**
   * Connect to another post type for one-to-one, one-to-many, or many-to-many relationships
   *
   * @todo Add in a QuickPress-like box to enter new objects
   * @param string $post_type The post type that we want to connect to
   * @return array An associative array of post_id => post_title
   * @author Matthew Boynes
   */
  public function get_external_data( $post_type ) {
    $posts_array = get_posts(
      apply_filters( 'scpt_plugin_meta_data_connect_' . $post_type, array(
          'numberposts' => -1,
          'orderby' => 'menu_order title',
          'order' => 'ASC',
          'post_type' => $post_type
      ) )
    );

    // The Loop, hah
    $ret = apply_filters( 'scpt_plugin_meta_data_loop', array(), $posts_array );
    if ( empty( $ret ) && !empty( $posts_array ) ) {
      foreach ( $posts_array as $post ) {
        $ret[ $post->ID ] = get_the_title( $post->ID );
      }
    }
    return $ret;
  }


  /**
   * Prepare options for select elements, or prepare many checkbox or radio buttons
   *
   * @uses SCPT_Markup::tag
   * @param array $options The options as either an array of values or associative array of values => labels
   * @param string $meta_key The meta_key for this element
   * @param array $post_meta The stored post meta
   * @param array $default_args Optional. The default arguments to attach to this HTML element
   * @param string $tag Optional. The HTML tag we're creating
   * @return array of HTML elements
   * @author Matthew Boynes
   */
  public function prune_options( $options, $meta_key, $post_meta, $default_args = array(), $tag = 'option', $default = null ) {
    $has_values = $this->is_assoc( $options ) || !isset( $options[0] );

    # Allow developers to hook into this before the HTML is generated to override it
      $html = apply_filters( 'scpt_plugin_custom_meta_pre_' . $meta_key . '_options', array() );
    if ( !empty( $html ) ) return $html;

    foreach ( $options as $key => $option ) {
      $this_args = $default_args;
      $this_args['value'] = $has_values ? $key : $option;
      if ( isset( $this_args['id'] ) )
        $this_args['id'] .= "_$key";

      if ( 'input' == $tag ) {
        if ( ( isset( $post_meta[ $meta_key ] ) && in_array( $this_args['value'], $post_meta[ $meta_key ] ) ) || ( ! isset( $post_meta[ $meta_key ] ) && in_array( $this_args['value'], (array) $default ) ) )
          $this_args['checked'] = 'checked';
        $html[] = SCPT_Markup::tag( 'label', array(
          'for' => $this_args['id'],
          'class' => 'scpt-meta-label choice scpt-meta-' . $this_args['type'] . ' label-' . $meta_key
        ), SCPT_Markup::tag( 'input', $this_args ) . ' ' . $option );
      }
      else {
        if ( ( isset( $post_meta[ $meta_key ] ) && in_array( $this_args['value'], $post_meta[ $meta_key ] ) ) || ( ! isset( $post_meta[ $meta_key ] ) && in_array( $this_args['value'], (array) $default ) ) )
          $this_args['selected'] = 'selected';
        $html[] = SCPT_Markup::tag( 'option', $this_args, $option );
      }
    }
    return apply_filters( 'scpt_plugin_custom_meta_' . $meta_key . '_options', $html );
  }


  /**
   * Figure out which included field attributes are indended to be HTML attributes
   *
   * @param array $args The field arguments containing both the settings and the HTML attributes
   * @return array The array of will-be HTML attributes
   * @author Matthew Boynes
   */
  public function parse_attributes( $args ) {
    return array_diff_key( $args, array(
      'type' => true,
      'meta_key' => true,
      'label' => true,
      'options' => true,
      'data' => true,
      'prompt' => true,
      'column' => true,
      'default' => true,
      'desc' => true,
      'field_description' => true,
      'section_title' => true,
      'button_text' => true,
      'repeat' => true
    ) );
  }


  /**
   * Save values for custom meta boxes
   *
   * @param int $post_id
   * @return void
   * @author Matthew Boynes
   */
  public function save_meta( $post_id ) {
    # verify if this is an auto save routine.
    # If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

    # verify this came from the our screen and with proper authorization,
    # because save_post can be triggered at other times
    if ( !isset( $_POST[ sprintf( $this->nonce_key, $this->type ) ] ) || !wp_verify_nonce( $_POST[sprintf( $this->nonce_key, $this->type )], plugin_basename( __FILE__ ) ) )
      return;

    # Check permissions
    $post_type_object = get_post_type_object( $this->type );
    if ( !current_user_can( $post_type_object->cap->edit_post, $post_id ) )
      return;

    # We're authenticated: we need to find and save the data
    foreach ( $this->field_names as $field ) {

      // Set natural order for repeatable fields
      if( in_array( $field, $this->repeat_field_names ) ) {
        $reorder = array();
        foreach( $_POST[$field] as $r_post )
          $reorder[] = $r_post;

        $_POST[$field] = $reorder;
      }

      if( isset( $_POST[$field] ) ) {
        if ( is_array( $_POST[ $field ] ) ) {
          delete_post_meta( $post_id, $field );
          foreach ( $_POST[ $field ] as $meta_value )
            add_post_meta( $post_id, $field, apply_filters( "scpt_plugin_{$this->type}_meta_save_{$field}", $meta_value ) );
        }
        else
          update_post_meta( $post_id, $field, apply_filters( "scpt_plugin_{$this->type}_meta_save_{$field}", $_POST[ $field ] ) );
      }
    }
  }


  /**
   * Register our datepicker CSS & JS
   *
   * @return void
   * @author Matthew Boynes
   */
  public function register_datepicker() {
    if ( !$this->registered_datepicker ) {
      add_action( 'admin_print_styles-post-new.php', array( $this, 'add_datepicker_css' ) );
      add_action( 'admin_print_styles-post.php', array( $this, 'add_datepicker_css' ) );
      add_action( 'admin_print_scripts-post-new.php', array( $this, 'add_datepicker_js' ) );
      add_action( 'admin_print_scripts-post.php', array( $this, 'add_datepicker_js' ) );
      $this->registered_datepicker = true;
    }
  }


  /**
   * Register our media JS
   *
   * @return void
   * @author Matthew Boynes
   */
  public function register_media() {
    if ( !$this->registered_media ) {
      add_action( 'admin_print_scripts-post-new.php', array( $this, 'add_media_js' ) );
      add_action( 'admin_print_scripts-post.php', array( $this, 'add_media_js' ) );
      $this->registered_media = true;
    }
  }


  /**
   * Add the datepicker CSS to the doc head
   *
   * @return void
   * @author Matthew Boynes
   */
  public function add_datepicker_css() {
    wp_enqueue_style( 'smoothness', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/themes/smoothness/jquery-ui.css' );
  }


  /**
   * Add the datepicker JS to the doc head
   *
   * @return void
   * @author Matthew Boynes
   */
  public function add_datepicker_js() {
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_script( 'supercpt.js' );
  }


  public function add_media_js() {
    global $post;
    wp_enqueue_media( array( 'post' => $post ) );
    wp_enqueue_script( 'supercpt.js' );
  }


  /**
   * A handy dandy helper function for determining if an array is associative or not
   *
   * @param array $arr
   * @return bool
   * @author Matthew Boynes
   */
  public function is_assoc( $arr ) {
    return ( is_array( $arr ) && count( array_filter( array_keys( $arr ), 'is_string' ) ) == count( $arr ) );
  }

  protected function register_custom_columns( $columns = array() ) {
    if ( !$this->registered_custom_columns ) {
      add_action( 'manage_' . $this->type . '_posts_custom_column' , array( $this, 'custom_column' ), 10, 2 );
      add_filter( 'manage_edit-' . $this->type . '_columns', array( $this, 'edit_columns' ) );
      $this->column_thumbnail_size = apply_filters( 'scpt_plugin_column_thumbnail_size', array( 60, 60 ), $this->type );
      $this->registered_custom_columns = true;
    }
  }

  public function add_to_columns( $column ) {
    if ( is_array( $column ) ) {
      $this->columns = $this->columns + $column;
    } elseif ( '_thumbnail_id' == $column ) {
      $this->columns[ $column ] = 'Thumbnail';
    } else {
      $this->columns[ $column ] = SCPT_Markup::labelify( $column );
    }
    $this->register_custom_columns();
  }

  public function custom_column( $column, $post_id ) {
    if ( isset( $this->columns[ $column ] ) ) {
      if ( ! in_array( $column, $this->field_names ) ) {
        if ( taxonomy_exists( $column ) ) {
          $terms = get_the_term_list( $post_id , $column , '' , ', ' , '' );
          if ( is_string( $terms ) )
            echo $terms;
          return;
        }
      }
      add_filter( 'scpt_plugin_formatted_meta', array( $this, 'format_meta_for_list' ), 10, 2 );
      the_scpt_formatted_meta( $column );
    }
  }

  public function data_column( $post ) {
    if ( $post instanceof WP_Post )
      return '<a href="' . get_edit_post_link( $post->ID ) . '">' . esc_html( get_the_title( $post->ID ) ) . '</a>';
  }

  public function format_meta_for_list( $data, $key ) {
    $field_info = get_known_field_info( $key, $this->type );
    if ( false == $field_info ) {
      switch ( $key ) {
        case '_thumbnail_id' :
          return wp_get_attachment_image( $data, $this->column_thumbnail_size, true );
      }
    } elseif ( is_array( $field_info ) ) {
      # This is a cpt relationship
      if ( is_array( $data ) ) {
        return implode( '<br />', array_map( array( $this, 'data_column' ), $data ) );
      }
    } else {
      switch ( $field_info ) {
        case 'date' :
          return $data ? date( 'Y-m-d', $data ) : '';
        case 'boolean' :
          return true === $data ? '&#10004;' : '';
        case 'media' :
          return $data ? wp_get_attachment_image( $data, $this->column_thumbnail_size, true ) : '';
      }
    }
    return $data;
  }

  public function edit_columns( $columns ) {
    unset( $columns['cb'], $columns['title'] );
    return array(
      "cb" => '<input type="checkbox" />',
      "title" => 'Title'
    ) + $this->columns + $columns;
  }


}


?>