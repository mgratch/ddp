<?php
/*
Plugin Name: DDP Interactive Map
Plugin URI:
Description: Custom interactive map for DDP.
Author: Octane Design
Version: 1.0
Author URI: http://octanedesign.com
*/

$plugin_path = plugin_dir_path( __FILE__ );
$plugin_url = plugin_dir_url( __FILE__ );

function print_map($atts){
	global $plugin_path, $plugin_url;

	wp_enqueue_script('velocity');
	wp_enqueue_script('velocity-ui');


	extract( shortcode_atts( array(
		'width' => '800px',
		'height' => '650px',
		'zoom' => '16',
		'file' => null,
		'category' => 'all',
		'subcat' => null,
		'show_table' => null

	), $atts ) );


	$data = read_xls($file);
	if($data !== false){
		$html = '';


		if($show_table != null){
			$html .= '<ul class="tabs">';
			$html .= "<li class=\"tabs__tab js-tab\"><span class=\"tab__title\">Map</span></li>\n";
			$html .= "<li class=\"tabs__tab js-tab\"><span class=\"tab__title\">Data</span></li>\n";
			$html .= '</ul>';
		//	$html .= '<div class="tab-content">';
			$html .= '<div id="int-map" class="tab__content js-tab-content">';
		}
		$html .= '<div class="map-container"><div class="map-wrapper"><div id="map-canvas" style="width:'.$width.'; height:'.$height.';"></div></div>';
		if($category == 'all'){
			$html .= '<div class="info-overlay"><div class="links"><a href="#" class="active" id="Attractions">Attractions</a><a href="#" class="active" id="FoodBars">Food &amp; Bars</a><a href="#" class="active" id="Lighthouse">Project Lighthouse</a><a href="#" class="active" id="Shopping">Shopping</a></div>';
		}
		//$html .= '</div></div>';
		$html .= '</div>';


		$html .= '<script type="text/javascript">';

		$html .= 'var dataObj = {
			';

		if( $category == "Food &amp; Bars" ) {
			$category = 'Food & Bars';
		}

		foreach($data as $k => $array){
			if($category == 'all'){
				$html .= get_location($k, $array);
			}else if($subcat != null){
				if(in_array($category, $array) && in_array($subcat, $array)){
					$html .= get_location($k, $array);
				}
			}else if(in_array($category, $array)){
				$html .= get_location($k, $array);
			}

		}



		$html .= '}';

		$html .= '
		jQuery(document).ready(function($){
		    google.maps.event.addDomListener(window, "load", initialize("'.$plugin_url.'",'.$zoom.'));
		});

	    </script>';
		$html .= '</div>';
	    if($show_table != null){

			$html .= '<div id="data" class="tab__content js-tab-content">';

			$html .= '<table class="map-table">';
			$html .= '<thead><tr>';
			$html .= '<td class="name">Name</td>';
			$html .= '<td class="category">Category</td>';
			$html .= '<td class="street-address">Street Address</td>';
			$html .= '<td class="phone">Phone</td>';
			$html .= '<td class="map">Map</td>';
			$html .= '</tr></thead>';

			foreach($data as $k => $array){
				if($category == 'all'){
					$html .= get_row($array);
				}else if($subcat != null){
					if(in_array($category, $array) && in_array($subcat, $array)){
						$html .= get_row($array);
					}
				}else if(in_array($category, $array)){
					$html .= get_row($array);
				}

			}

			$html .= '</table>';
			$html .= '</div>';
			//$html .= '</div>';
	    }

	    return $html;
	}else{
		print "<!-- map failed to load: data false -->";
	}

}

function read_xls($file){
	global $plugin_path, $plugin_url;

	if($file != null){
		///usr/home/downtowndetroit/public_html/downtowndetroit.org
		//$usr = "constructor";
		$usr = "downtowndetroit";
		wp_enqueue_script( 'gmap', '//maps.googleapis.com/maps/api/js?key='.$_ENV['GOOGLE_MAPS_API_KEY'], null, null, true);
		wp_enqueue_script('gmap-infobox', 'http://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.9/src/infobox.js', null, null, true);
		wp_enqueue_script( 'gmap-custom', $plugin_url.'js/ddp-map.js', null, null, true);

		wp_enqueue_style( 'gmap-custom-css', $plugin_url.'css/ddp-interactive-map.css');
		require_once($plugin_path."inc/excel_reader2.php");
		//print $plugin_path."/xls/data.xls";


//switch with below for dev		$filename = str_replace("http://", "/usr/home/$usr/public_html/", $file);
		$upload_dir = wp_upload_dir();
		// var_dump($upload_dir['basedir']);
		$filename =  $upload_dir['basedir'].$file;


		$data = new Spreadsheet_Excel_Reader($filename, false);
		$cells = $data->sheets[0]["cells"];
		array_shift($cells);
		return $cells;
	}else{
		return false;
	}
	//print_r($cells);
}

function get_location($k, $array){
	$loc = '';
	$loc .= '"location'.$k.'":';

	$loc .= '{
		';

		$loc .= '"address":"'.$array[4].'<br />'.$array[5].', '.$array[6].' '.$array[7].'",
		';

		$loc .= '"lat":"'.$array[11].'",
		';

		$loc .= '"lon":"'.$array[12].'",
		';

		$loc .= '"name":"'.$array[3].'",
		';

		$loc .= '"category":"'.$array[1].'",
		';

		$loc .= '"subcat":"'.$array[2].'",
		';

		$loc .= '"slug":"'.str_replace(array(" & ", " "), "", $array[1]).'",
		';

		$loc .= '"phone":"'.$array[8].'",
		';

		$loc .= '"url":"'.$array[10].'"
		';

	$loc .= '},
	';

	return $loc;
}

function get_row($array){
	$html = '';
	$html .= '<tr>';
	$html .= '<td>';
	if(strlen($array[10]) > 0){
		$url = str_replace("http://", "", $array[10]);
		$html .= '<a href="http://'.$url.'" target="_blank">';
	}
	$html .= $array[3];
	if(strlen($array[10]) > 0){
		$html .= '</a>';
	}
	$html .= '</td>';
	$html .= '<td>'.$array[1].'</td>';
	$html .= '<td>'.$array[4].'</td>';
	$html .= '<td>'.$array[8].'</td>';

	$address = $array[4].'%20'.$array[5].'%20'.$array[6].'%20'.$array[7];
	$html .= '<td><a href="http://maps.google.com/maps?q='.$address.'" target="_blank">Map</a></td>';
	$html .= '</tr>';
	return $html;
}

add_shortcode('interactive-map', 'print_map');

?>
