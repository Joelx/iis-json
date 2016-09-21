<style>
	.list-wrap {
		list-style-type: none;
	}

	.list-caption {
		font-size: 1.2em;
		font-weight: bold;	
	}
	
	.list-body {
		margin-bottom: 30px;
	}
</style>

<?php

/*
 * Template File fuer die einzelnen 
 * Ausgabe Formate
 */

function build_html_list($arr) {
	$output = '';
	$output .= '<ul class="list-wrap">';
	
	for ($i = 0; $i < count($arr); $i++) {
		$output .= '<li>';
			$output .= '<span class="list-caption">' . $arr[$i]['titel'] . ' [ID: ' . $arr[$i]['id'] . ']' . '</span>'; 
			$output .= '<ul class="list-body">';
				$output .= '<li><b>Themenbeschreibung: </b>' . $arr[$i]['beschreibung'] . '</li>';
				$output .= '<li><b>Themengebiete: </b>' . $arr[$i]['kategorie'] . '</li>';
				$output .= '<li><b>Voraussetzungen: </b>' . $arr[$i]['voraussetzung'] . '</li>';
				$output .= '<li><b>Betreuer: </b>' . $arr[$i]['betreuer'] . '</li>';
				$output .= '<li><b>Hochschullehrer: </b>' . $arr[$i]['hs_lehrer'] . '</li>';
			$output .= '</ul>';
		$output .= '</li>';
	}
	
/*	foreach ($arr as $key => $arr[$i]) {
		$output .= '<li>';
			$output .= '<span class="list-caption">' . $arr[$i]['titel'] . ' [ID: ' . $arr[$i]['id'] . ']' . '</span>'; 
			$output .= '<ul class="list-body">';
				$output .= '<li><b>Themenbeschreibung: </b>' . $arr[$i]['beschreibung'] . '</li>';
				$output .= '<li><b>Themengebiete: </b>' . $arr[$i]['kategorie'] . '</li>';
				$output .= '<li><b>Voraussetzungen: </b>' . $arr[$i]['voraussetzung'] . '</li>';
				$output .= '<li><b>Betreuer: </b>' . $arr[$i]['betreuer'] . '</li>';
				$output .= '<li><b>Hochschullehrer: </b>' . $arr[$i]['hs_lehrer'] . '</li>';
			$output .= '</ul>';
		$output .= '</li>';
	}*/
	$output .= '</ul>';
	return $output;
}


function build_wp_accordion($arr) {
 // TODO
	
}

?>