<?php
/**
 * Plugin Name:     Allow SVGs Beta
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Based on @lukecavanagh's diff provided April 13, 2017 https://core.trac.wordpress.org/ticket/24251
 * Author:          Trac contributors & Marc Gratch
 * Author URI:      YOUR SITE HERE
 * Text Domain:     allow-svgs-beta
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Allow_Svgs_Beta
 */

/**
 * Kses global for default allowable SVG tags.
 *
 * Can be override by using CUSTOM_TAGS constant.
 *
 * @global array $allowedsvgtags
 * @since 2.0.0
 */
$allowedsvgtags = array(
	'a'              => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'id'                => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'transform'         => array(),
		'href'              => array(),
		'xlink:href'        => array(),
		'xlink:title'       => array()
	),
	'circle'         => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'cx'                => array(),
		'cy'                => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'id'                => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'r'                 => array(),
		'requiredfeatures'  => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'transform'         => array()
	),
	'clippath'       => array( 'class' => array(), 'clippathunits' => array(), 'id' => array() ),
	'defs'           => array(),
	'style'          => array( 'type' => array() ),
	'desc'           => array(),
	'ellipse'        => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'cx'                => array(),
		'cy'                => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'id'                => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'requiredfeatures'  => array(),
		'rx'                => array(),
		'ry'                => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'transform'         => array()
	),
	'fegaussianblur' => array(
		'class'                       => array(),
		'color-interpolation-filters' => array(),
		'id'                          => array(),
		'requiredfeatures'            => array(),
		'stddeviation'                => array()
	),
	'filter'         => array(
		'class'                       => array(),
		'color-interpolation-filters' => array(),
		'filterres'                   => array(),
		'filterunits'                 => array(),
		'height'                      => array(),
		'id'                          => array(),
		'primitiveunits'              => array(),
		'requiredfeatures'            => array(),
		'width'                       => array(),
		'x'                           => array(),
		'xlink:href'                  => array(),
		'y'                           => array()
	),
	'foreignobject'  => array(
		'class'            => array(),
		'font-size'        => array(),
		'height'           => array(),
		'id'               => array(),
		'opacity'          => array(),
		'requiredfeatures' => array(),
		'style'            => array(),
		'transform'        => array(),
		'width'            => array(),
		'x'                => array(),
		'y'                => array()
	),
	'g'              => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'id'                => array(),
		'display'           => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'requiredfeatures'  => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'transform'         => array(),
		'font-family'       => array(),
		'font-size'         => array(),
		'font-style'        => array(),
		'font-weight'       => array(),
		'text-anchor'       => array()
	),
	'image'          => array(
		'class'            => array(),
		'clip-path'        => array(),
		'clip-rule'        => array(),
		'filter'           => array(),
		'height'           => array(),
		'id'               => array(),
		'mask'             => array(),
		'opacity'          => array(),
		'requiredfeatures' => array(),
		'style'            => array(),
		'systemlanguage'   => array(),
		'transform'        => array(),
		'width'            => array(),
		'x'                => array(),
		'xlink:href'       => array(),
		'xlink:title'      => array(),
		'y'                => array()
	),
	'line'           => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'id'                => array(),
		'marker-end'        => array(),
		'marker-mid'        => array(),
		'marker-start'      => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'requiredfeatures'  => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'transform'         => array(),
		'x1'                => array(),
		'x2'                => array(),
		'y1'                => array(),
		'y2'                => array()
	),
	'lineargradient' => array(
		'class'             => array(),
		'id'                => array(),
		'gradienttransform' => array(),
		'gradientunits'     => array(),
		'requiredfeatures'  => array(),
		'spreadmethod'      => array(),
		'systemlanguage'    => array(),
		'x1'                => array(),
		'x2'                => array(),
		'xlink:href'        => array(),
		'y1'                => array(),
		'y2'                => array()
	),
	'marker'         => array(
		'id'                  => array(),
		'class'               => array(),
		'markerheight'        => array(),
		'markerunits'         => array(),
		'markerwidth'         => array(),
		'orient'              => array(),
		'preserveaspectratio' => array(),
		'refx'                => array(),
		'refy'                => array(),
		'systemlanguage'      => array(),
		'viewbox'             => array()
	),
	'mask'           => array(
		'class'            => array(),
		'height'           => array(),
		'id'               => array(),
		'maskcontentunits' => array(),
		'maskunits'        => array(),
		'width'            => array(),
		'x'                => array(),
		'y'                => array()
	),
	'metadata'       => array( 'class' => array(), 'id' => array() ),
	'path'           => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'd'                 => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'id'                => array(),
		'marker-end'        => array(),
		'marker-mid'        => array(),
		'marker-start'      => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'requiredfeatures'  => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'transform'         => array()
	),
	'pattern'        => array(
		'class'               => array(),
		'height'              => array(),
		'id'                  => array(),
		'patterncontentunits' => array(),
		'patterntransform'    => array(),
		'patternunits'        => array(),
		'requiredfeatures'    => array(),
		'style'               => array(),
		'systemlanguage'      => array(),
		'viewbox'             => array(),
		'width'               => array(),
		'x'                   => array(),
		'xlink:href'          => array(),
		'y'                   => array()
	),
	'polygon'        => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'id'                => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'id'                => array(),
		'class'             => array(),
		'marker-end'        => array(),
		'marker-mid'        => array(),
		'marker-start'      => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'points'            => array(),
		'requiredfeatures'  => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'transform'         => array()
	),
	'polyline'       => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'id'                => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'marker-end'        => array(),
		'marker-mid'        => array(),
		'marker-start'      => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'points'            => array(),
		'requiredfeatures'  => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'transform'         => array()
	),
	'radialgradient' => array(
		'class'             => array(),
		'cx'                => array(),
		'cy'                => array(),
		'fx'                => array(),
		'fy'                => array(),
		'gradienttransform' => array(),
		'gradientunits'     => array(),
		'id'                => array(),
		'r'                 => array(),
		'requiredfeatures'  => array(),
		'spreadmethod'      => array(),
		'systemlanguage'    => array(),
		'xlink:href'        => array()
	),
	'rect'           => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'height'            => array(),
		'id'                => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'requiredfeatures'  => array(),
		'rx'                => array(),
		'ry'                => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'transform'         => array(),
		'width'             => array(),
		'x'                 => array(),
		'y'                 => array()
	),
	'stop'           => array(
		'class'            => array(),
		'id'               => array(),
		'offset'           => array(),
		'requiredfeatures' => array(),
		'stop-color'       => array(),
		'stop-opacity'     => array(),
		'style'            => array(),
		'systemlanguage'   => array()
	),
	'svg'            => array(
		'class'               => array(),
		'clip-path'           => array(),
		'clip-rule'           => array(),
		'filter'              => array(),
		'id'                  => array(),
		'height'              => array(),
		'mask'                => array(),
		'preserveaspectratio' => array(),
		'requiredfeatures'    => array(),
		'style'               => array(),
		'systemlanguage'      => array(),
		'viewbox'             => array(),
		'width'               => array(),
		'x'                   => array(),
		'xmlns'               => array(),
		'xmlns:se'            => array(),
		'xmlns:xlink'         => array(),
		'y'                   => array()
	),
	'switch'         => array(
		'class'            => array(),
		'id'               => array(),
		'requiredfeatures' => array(),
		'systemlanguage'   => array()
	),
	'symbol'         => array(
		'class'               => array(),
		'fill'                => array(),
		'fill-opacity'        => array(),
		'fill-rule'           => array(),
		'filter'              => array(),
		'font-family'         => array(),
		'font-size'           => array(),
		'font-style'          => array(),
		'font-weight'         => array(),
		'id'                  => array(),
		'opacity'             => array(),
		'preserveaspectratio' => array(),
		'requiredfeatures'    => array(),
		'stroke'              => array(),
		'stroke-dasharray'    => array(),
		'stroke-dashoffset'   => array(),
		'stroke-linecap'      => array(),
		'stroke-linejoin'     => array(),
		'stroke-miterlimit'   => array(),
		'stroke-opacity'      => array(),
		'stroke-width'        => array(),
		'style'               => array(),
		'systemlanguage'      => array(),
		'transform'           => array(),
		'viewbox'             => array()
	),
	'text'           => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'font-family'       => array(),
		'font-size'         => array(),
		'font-style'        => array(),
		'font-weight'       => array(),
		'id'                => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'requiredfeatures'  => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'text-anchor'       => array(),
		'transform'         => array(),
		'x'                 => array(),
		'xml:space'         => array(),
		'y'                 => array()
	),
	'textpath'       => array(
		'class'            => array(),
		'id'               => array(),
		'method'           => array(),
		'requiredfeatures' => array(),
		'spacing'          => array(),
		'startoffset'      => array(),
		'style'            => array(),
		'systemlanguage'   => array(),
		'transform'        => array(),
		'xlink:href'       => array()
	),
	'title'          => array(),
	'tspan'          => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'dx'                => array(),
		'dy'                => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'font-family'       => array(),
		'font-size'         => array(),
		'font-style'        => array(),
		'font-weight'       => array(),
		'id'                => array(),
		'mask'              => array(),
		'opacity'           => array(),
		'requiredfeatures'  => array(),
		'rotate'            => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'systemlanguage'    => array(),
		'text-anchor'       => array(),
		'textlength'        => array(),
		'transform'         => array(),
		'x'                 => array(),
		'xml:space'         => array(),
		'y'                 => array()
	),
	'use'            => array(
		'class'             => array(),
		'clip-path'         => array(),
		'clip-rule'         => array(),
		'fill'              => array(),
		'fill-opacity'      => array(),
		'fill-rule'         => array(),
		'filter'            => array(),
		'height'            => array(),
		'id'                => array(),
		'mask'              => array(),
		'stroke'            => array(),
		'stroke-dasharray'  => array(),
		'stroke-dashoffset' => array(),
		'stroke-linecap'    => array(),
		'stroke-linejoin'   => array(),
		'stroke-miterlimit' => array(),
		'stroke-opacity'    => array(),
		'stroke-width'      => array(),
		'style'             => array(),
		'transform'         => array(),
		'width'             => array(),
		'x'                 => array(),
		'xlink:href'        => array(),
		'y'                 => array()
	),
);

function add_svg_support( $mime_types ) {
	$mime_types['svg'] = 'image/svg+xml';

	return $mime_types;
}

add_filter( 'mime_types', 'add_svg_support' );

/**
 * Return a list of allowed xml tags and attributes for a given context.
 *
 * @params string $context The context for which to retrieve tags. Allowed values are
 *  svg
 *
 * @return array List of allowed xml tags and their allowed attributes.
 */
function wp_kses_allowed_xml( $context = '' ) {
	global $allowedsvgtags;

	if ( is_array( $context ) ) {
		return apply_filters( 'wp_kses_allowed_xml', $context, 'explicit' );
	}

	switch ( $context ) {
		case 'svg':
		case 'image/svg+xml':
			return apply_filters( 'wp_kses_allowed_xml', $allowedsvgtags, $context );
			break;
		default:
			return apply_filters( 'wp_kses_allowed_xml', array(), $context );
	}
}


function wp_validate_upload( $params, $type ) {
	if ( preg_match( '#\bxml\b#', $params['type'] ) ) {
		$content          = file_get_contents( $params['file'] );
		$filtered_content = wp_kses( $content, wp_kses_allowed_xml( $params['type'] ), array() );
		file_put_contents( $params['file'], $filtered_content );
	}

	return $params;
}

add_filter( 'wp_handle_upload', 'wp_validate_upload', 10, 2 );


