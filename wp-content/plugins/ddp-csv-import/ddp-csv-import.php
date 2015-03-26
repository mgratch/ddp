<?php
/*
Plugin Name: DDP CSV Import
Plugin URI: 
Description: Custom plugin to handle CSV import and conversion to JSON for display in tables.
Author: Octane Design
Version: 1.0
Author URI: http://octanedesign.com
*/


$plugin_path = plugin_dir_path( __FILE__ );
$plugin_url = plugin_dir_url( __FILE__ );

function process_csv($atts){
	global $plugin_path, $plugin_url;

	require_once($plugin_path."inc/excel_reader2.php");
	//wp_enqueue_script( 'csv-json', $plugin_url.'js/csv-to-json.js');

	$usr = "downtowndetroit";

	extract( shortcode_atts( array(
		'file' => null

	), $atts ) );

	if($file !== null){
		$filename = str_replace("http://", "/usr/home/$usr/public_html/", $file);
		$data = new Spreadsheet_Excel_Reader($filename, false);
		$cells = $data->sheets[0]["cells"];
		array_shift($cells);

		// $odd = array();
		// $even = array();
		// foreach ($cells as $k => $v) {
		//     if ($k % 2 == 0) {
		//         $even[] = $v;
		//     }
		//     else {
		//         $odd[] = $v;
		//     }
		// }

		// print_r($even);

		$html = '';
		$html .= '<ul class="members-container">';
		foreach($cells as $k => $v){
			if( $v[2] == "") {
				$html .= '<li>'.$v[1].'</li>';
			} else {
				$html .= '<li><a href="'.$v[2].'" target="_blank">'.$v[1].'</a></li>';
			}
		}
		$html .= '</ul>';


		return $html;

	}


}

add_shortcode('import_csv', 'process_csv');

?>