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

<style>
/* Test Style fuer RRZE Accordion */

.accordion {
    margin: 10px 0 20px 0;
}

.accordion .accordion-group {
    border: none;
    margin-bottom: 5px;
}

.accordion .accordion-group .accordion-heading {
    overflow: hidden;
}

.accordion .accordion-group .accordion-heading .accordion-toggle {
    border-left: 10px solid #6E7881;
    background: #dfe6ec;
    color: #036;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 16px;
    padding: 8px 35px 8px 10px;
    position: relative;
}
.accordion-heading .accordion-toggle {
    display: block;
    padding: 8px 15px;
}
.accordion-toggle {
    cursor: pointer;
}


.accordion .accordion-group .accordion-heading .accordion-toggle::before {

    position: absolute;
    top: 10px;
    right: 10px;

}
.fa-caret-down::before, #nav li.has-sub > a::before, #meta-nav li.has-sub > a::before, .accordion .accordion-group .accordion-heading .accordion-toggle::before {

    content: "\f0d7";

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