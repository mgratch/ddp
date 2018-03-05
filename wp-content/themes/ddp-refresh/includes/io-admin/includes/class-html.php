<?php
class ioHTML
{

  public static function formOpen( $action = '', $method = '', $attributes = [] )
  {
    $attributes = array_merge(
      array(

      ),
      $attributes
    );


    return '<form action="'.$action.'" method="'.$method.'" '.ioHTML::attributes( $attributes ).'>';
  }

  public static function formClose()
  {
    return '</form>';
  }

  public static function classes( $attributes )
  {
    $attributes = array_merge_recursive( ['class' => 'form-control'], $attributes );

    if( is_array( $attributes['class'] ) ) {
      $attributes['class'] = implode( ' ', $attributes['class'] );
    }

    return $attributes;
  }

  public static function input( $name, $value, $attributes = [] )
  {

    $attributes = ioHTML::classes( $attributes );

    $attr = array_merge(
      array(
        'name' => $name,
        'value' => ( !empty( $value ) ? $value : '' ),
        'type' => 'text'
      ),
      $attributes
    );

    return ioHTML::tag( 'input', $attr );
  }

  public static function parseAttributes( $attributes )
  {
    return array_diff_key( $attributes, [
        'default' => true,
        'select_placeholder' => true
      ]
    );
  }

  public static function select( $name, $options, $value = '', $attributes = [] )
  {
    $option_content = [];

    $attributes = array_merge( [
        'name'=> $name,
        'select_placeholder' => true
      ],
      $attributes
    );

    if( $attributes['select_placeholder'] && !empty( $attributes['select_placeholder'] ) && $attributes['select_placeholder'] !== true ) {
      $option_content[] = ioHTML::tag( 'option', ['data-default-select' => null], $attributes['select_placeholder'] );
    } elseif( $attributes['select_placeholder'] ) {
      $option_content[] = ioHTML::tag( 'option', ['data-default-select' => null], 'Choose One' );
    }

    $attributes = ioHTML::classes( $attributes );

    foreach( $options as $oValue => $oTitle ) {
      $oAttr = [
        'value' => $oValue
      ];

      if( $oValue == $value )
        $oAttr['selected'] = 'selected';

      if( empty( $value ) && !empty( $attributes['default'] ) ) {
        if( $oValue == $attributes['default'] )
          $oAttr['selected'] = 'selected';
      }

      $option_content[] =  ioHTML::tag( 'option', $oAttr, $oTitle );
    }

    return ioHTML::tag( 'select', ioHTML::parseAttributes( $attributes ), implode( "\r\n", $option_content ) );
  }

  public static function checkbox( $name, $value = '', $attributes = [] )
  {

    $attributes = array_merge( [
        'name'=> $name,
        'type' => 'checkbox',
        'value' => $value
      ],
      $attributes
    );

    $attributes = ioHTML::classes( $attributes );

    return ioHTML::tag( 'label', ['style' => 'margin-bottom:0;font-weight:500;l'], ioHTML::tag( 'input', ioHTML::parseAttributes( $attributes ) ) . '&nbsp;&nbsp;' .$attributes['label'] );
  }

  /**
   * Generate an HTML tag
   *
   * @uses attributes
   * @static
   * @param string $name The tag name, e.g. div, input, p, li, etc.
   * @param array $attr Optional. The HTML attributes as an associative array
   * @param mixed $text Optional. The HTML to go within the tag. If false, it's a self-closing tag (< />)
   * @return string
   * @author Matthew Boynes
   */
  public static function tag( $name, $attr = array(), $text = false ) {

    if ( $attr )
      $attr = ioHTML::attributes( $attr );
    else
      $attr = '';

    if ( false !== $text )
      $text = ">$text</$name>";
    else
      $text = ' />';

    return '<' . $name . $attr . $text;
  }

  /**
   * Takes an associative array and converts the key=>val pairs into HTML attributes
   *
   * @static
   * @param array $arr An associative array of HTML attributes, e.g. array( 'href'=>'http://google.com', 'class'=>'button' )
   * @return string
   * @author Matthew Boynes
   */
  public static function attributes( $arr ) {
    $ret = '';
    foreach ( $arr as $key => $val ) $ret .= ' ' . $key . '="' . $val . '"';
    return $ret;
  }
}