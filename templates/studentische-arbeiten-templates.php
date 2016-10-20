<?php

/*
 * Template File fuer  
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
				if (array_key_exists('pdf', $arr[$i])) {
					if(isset($arr[$i]['pdf'])) {
						$output .= '<li><b>PDF: </b>' . '<a class="mtli_attachment mtli_pdf" href="' .$arr[$i]['pdf'] . '">Aushang</a></li>';
					}	
				}
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


function build_wp_accordion($arr, $accordion_count) {
	$collapse_count = 0;
	
	$output = '';
	$output .= '<div id="accordion-' . $accordion_count . '" class="accordion">';
	
	for ($i = 0; $i < count($arr); $i++) {
		$output .= '<div class="accordion-group">';
		
		$output .= '<div class="accordion-heading">';
		$output .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-' . $accordion_count . '" href="#collapse_' . $collapse_count . '">';
		$output .= $arr[$i]['titel'] . ' [ID: ' . $arr[$i]['id'] . '</a>';
		$output .= '</div> <!-- /.accordion-heading -->';
		$output .= '<div id="collapse_' . $collapse_count . '" class="accordion-body" style="display: none;">';
		$output .= '<ul>';
			$output .= '<li><b>Themenbeschreibung: </b>' . $arr[$i]['beschreibung'] . '</li>';
			$output .= '<li><b>Themengebiete: </b>' . $arr[$i]['kategorie'] . '</li>';
			$output .= '<li><b>Voraussetzungen: </b>' . $arr[$i]['voraussetzung'] . '</li>';
			$output .= '<li><b>Betreuer: </b>' . $arr[$i]['betreuer'] . '</li>';
			$output .= '<li><b>Hochschullehrer: </b>' . $arr[$i]['hs_lehrer'] . '</li>';
			if (array_key_exists('pdf', $arr[$i])) {
					if(isset($arr[$i]['pdf'])) {
						$output .= '<li><b>PDF: </b>' . '<a class="mtli_attachment mtli_pdf" href="' .$arr[$i]['pdf'] . '">Aushang</a></li>';
					}	
			}
		$output .= '</ul>';

		$output .= '<div class="accordion-inner clearfix">';
		
		
		
		$output .= '</div> <!-- /.accordion-inner -->';
		$output .= '</div> <!-- /.accordion-body -->';
		
		$output .= '</div> <!-- /.accordion-group -->';	
		
		$collapse_count++;

	}
	
	
	$output .= '</div> <!-- /.accordion -->';
	
	return $output;
}

?>