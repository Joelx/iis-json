<?php
/*
 *  Ergaenzung der Funktion "array_column()" für PHP Versionen < 5.5.0
 *  Ist dies notwendig ?  
 *  Wird hier benutzt, um Datensaetze nach bestimmer ID zu filtern. 
 *
 */
if (! function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( ! isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( ! isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}


/*
 *	Bauplan fuer alle Kindklassen dieses Plugins.
 *	Moeglicherweise unnoetig, 
 *	u.U werden jedoch noch weitere Objekttypen 
 *  in zukuenftigen Versionen unterstuetzt.
 */
abstract class Json_Data {
	private $json_urls = NULL;
	private $format = NULL;
	
	abstract protected function get_data();

	abstract protected function create_html($data);
	
}



class Studentische_Arbeiten extends Json_Data {
    
    private $id = NULL;
	private $task = NULL;
    
    function __construct($json_urls, $id, $task, $format, $advisor) {
        $this->id = $id;
        $this->json_urls = $json_urls;
		$this->task = $task;
		$this->format = $format;
		$this->advisor = $advisor;
    }
    /*
	 *	Erstellt Array aus der JSON-Zeichenkette
	 *	@return [mixed] array
	 */
    public function get_data() {
        
        if (!empty($this->json_urls)) {
            $data = json_decode(wp_remote_retrieve_body(wp_safe_remote_get($this->json_urls)), true);            
            //print_r($data);
        } else {
            echo "Keine URL";
            return; 
        }          
        
		// Falls ID als Parameter uebergeben wurde, filtere nach dieser.
		if ($this->id != '') {			
			$key = array_search($this->id, array_column($data, 'id'));
            if ($key === false) {
                $data = "Es wurde kein Eintrag mit der angegebenen ID gefunden.";
            } else {
				// Unsauber. Das Template File nimmt nur numerische Arrays entgegen.
				// Deshalb hier diese unschoene Umwandlung.
				$tmp = $data[$key];			
				$data = array();
				$data[0] = $tmp;
				unset($tmp);
			}
		}    
		
		// Falls Advisor als Parameter uebergeben wurde, filtere nach diesem Betreuer.
		if ($this->advisor != '') {
			$tmp = $data;
			$data = array();
			$i = 0;
			foreach($tmp as $array) {
				if (stripos($array['betreuer'], $this->advisor))	{
					$data[$i] = $array;
					$i++;
				}				
			}
			if (!$data) {
				echo "Keinen Eintrag zu angegebenem Betreuer gefunden";	
				return;
			}
		}    
		
        return $data;        
    }
	
	/*
	 *   Erstellt die HTML Ausgabe
	 *	 @return string
	 */
	public function create_html($data) {
		$output = '';
		// Faengt Fehler ab, falls unerwartete Dinge als ID uebergeben wurden
		if ( !is_array($data) ) {
			$output = "<p>Keinen Eintrag zur angegebenen Filterregel gefunden</p>";	
		}
		elseif (count(array_filter($data)) == 0) {
			$output = '<p>Es wurden keine studentischen Arbeiten gefunden.</p>';
		} else {
			// Baut entsprechend des optionalen Format Parameters die HTML Ausgabe zusammen
			$output .= '<div><h2>' . ucfirst($this->task) . '</h2>';
			switch($this->format) {
				case 'accordion': 
					$output .= build_wp_accordion($data, 0);
					break;
				default: 
					$output .= build_html_list($data);
					break;	
			}
			$output .= '</div>';
		}
		return $output;
	}
}






class Studentische_Arbeiten_Alle extends Json_Data {           
	
	function __construct($json_urls, $format) {
		$this->json_urls = $json_urls;
		$this->format = $format;
	}
		
    function get_data() {
		if (count($this->json_urls) > 1) {    
			$data = array();
			foreach ($this->json_urls as $key => $url) {
				$data[$key] = json_decode(wp_remote_retrieve_body(wp_safe_remote_get($url)), true); 
			}
		} else {
			$stud_arbeit = new Studentische_Arbeit($this->json_urls, '');
			$data = $stud_arbeit->get_data();
			// TODO: Object von Studentische_Arbeit erzeugen.
			// Ueberlegen welche create html aufgerufen werden soll
		}
		//print_r($data);
		return $data;
	}
	
	function create_html($data) {
		$output = '';
		$accordion_count = 0;
		
		if (count(array_filter($data)) == 0) {
			$output = '<p>Es wurden keine studentischen Arbeiten gefunden.</p>';
		} else {					
			foreach ($data as $heading => $arr) {
				$output .= '<div><h2>' . ucfirst($heading) . '</h2>';
				switch($this->format) {
					case 'accordion': 						
						$output .= build_wp_accordion($arr, $accordion_count);
						$accordion_count++;
						break;
					default: 
						$output .= build_html_list($arr);
						break;						
				}
				$output .= '</div>';
			}			
		}
		return $output;
	}
	
}