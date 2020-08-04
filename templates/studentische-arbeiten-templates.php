<?php

/*
 * Template File fuer  
 * Ausgabe Formate
 */

function build_html_list($arr, $ressources) {
	$output = '';
	$output .= '<ul class="list-wrap">';
	
	for ($i = 0; $i < count($arr); $i++) {
		$output .= '<li>';
			$output .= '<span class="list-caption">' . $arr[$i]['titel'] . ' [ID: ' . $arr[$i]['id'] . ']' . '</span>'; 
			$output .= '<ul class="list-body">';
				$output .= '<li><b>Themenbeschreibung: </b>' . $arr[$i]['beschreibung'] . '</li>';
				if(!empty($arr[$i]['aufgaben'])) {
					$aufgaben = explode("/", $arr[$i]['aufgaben']);
					$output .= '<ul>';
					foreach($aufgaben as $aufgabe) {
						$output .= '<li>' . $aufgabe . '</li>';
					}
					$output .= '</ul>';
				}
				$output .= '<li><b>Themengebiete: </b>' . $arr[$i]['kategorien'] . '</li>';
				$output .= '<li><b>Voraussetzungen: </b>' . $arr[$i]['voraussetzung'] . '</li>';
				$output .= '<li><b>Betreuer: </b>' . $arr[$i]['betreuer'] . '</li>';
				$output .= '<li><b>Hochschullehrer: </b>' . $arr[$i]['hs_lehrer'] . '</li>';
				if (array_key_exists('pdf', $arr[$i])) {
					if(!empty($arr[$i]['pdf'])) {
						if ($ressources == 'link') {
							$pdf_ressource = esc_url( $arr[$i]['pdf'] );
						} else {
							try {
								$pdf_ressource = "data:application/pdf;base64," . chunk_split(base64_encode(wp_remote_retrieve_body(wp_safe_remote_get(esc_url( $arr[$i]['pdf'] )))));
							} catch (Exception $e) {
								$pdf_ressource = esc_url( $arr[$i]['pdf'] );
							}							
						}
						$output .= '<li><b>PDF: </b>' . '<a class="mtli_attachment mtli_pdf" href="' . $pdf_ressource . '" download="Aushang.pdf">Aushang</a></li>';
					}	
				}
			$output .= '</ul>';
		$output .= '</li>';
}

	$output .= '</ul>';
	return $output;
}


function build_wp_accordion($arr, $accordion_count, $ressources) {
	$collapse_count = 0;
	
	$output = '';
	$output .= '[collapsibles]';
	
	for ($i = 0; $i < count($arr); $i++) {

		$output .= '[collapse title="' . $arr[$i]['titel'] . ' (ID: ' . $arr[$i]['id'] . ')' . '" ]';

		$output .= '<ul>';
			$output .= '<li><b>Themenbeschreibung: </b>' . $arr[$i]['beschreibung'] . '</li>';
			if(!empty($arr[$i]['aufgaben'])) {
					$aufgaben = explode("/", $arr[$i]['aufgaben']);
					$output .= '<ul>';
					foreach($aufgaben as $aufgabe) {
						$output .= '<li>' . $aufgabe . '</li>';
					}
					$output .= '</ul>';
				}
			$output .= '<li><b>Themengebiete: </b>' . $arr[$i]['kategorien'] . '</li>';
			$output .= '<li><b>Voraussetzungen: </b>' . $arr[$i]['voraussetzung'] . '</li>';
			$output .= '<li><b>Betreuer: </b>' . $arr[$i]['betreuer'] . '</li>';
			$output .= '<li><b>Hochschullehrer: </b>' . $arr[$i]['hs_lehrer'] . '</li>';
			if (array_key_exists('pdf', $arr[$i])) {
				if(!empty($arr[$i]['pdf'])) {
					if ($ressources == 'link') {
						$pdf_ressource = esc_url( $arr[$i]['pdf'] );
					} else {
						try {
							$pdf_ressource = "data:application/pdf;base64," . chunk_split(base64_encode(wp_remote_retrieve_body(wp_safe_remote_get(esc_url( $arr[$i]['pdf'] )))));
						} catch (Exception $e) {
							$pdf_ressource = esc_url( $arr[$i]['pdf'] );
						}							
					}
					$output .= '<li><b>PDF: </b>' . '<a class="mtli_attachment mtli_pdf" href="' . $pdf_ressource . '" download="Aushang.pdf">Aushang</a></li>';
				}	
			}
		$output .= '</ul>';
		$output .= '[/collapse]';
		
		$collapse_count++;

	}	
	$output .= '[/collapsibles]';
	
	return do_shortcode($output);
}

?>
