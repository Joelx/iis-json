<?php

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




abstract class Json_Data {
	private $json_urls = NULL;
	private $format = NULL;
	
	abstract protected function get_data();

	abstract protected function create_html($data);
	
}



class Studentische_Arbeiten extends Json_Data {
    
    private $id = NULL;
	private $task = NULL;
    
    function __construct($json_urls, $id, $task, $format) {
        $this->id = $id;
        $this->json_urls = $json_urls;
		$this->task = $task;
		$this->format = $format;
    }
    
    public function get_data() {
        
        if (!empty($this->json_urls)) {
            $data = json_decode(wp_remote_retrieve_body(wp_safe_remote_get($this->json_urls)), true);            
            //print_r($data);
        } else {
            echo "Keine URL";
            return; // TODO: Überlegen, welcher Fehler das sein könnte
        }          
        
		
		if ($this->id != '') {			
			$key = array_search($this->id, array_column($data, 'id'));
            if ($key === false) {
                $data = "Es wurde kein Eintrag mit der angegebenen ID gefunden.";
            } else {
				$tmp = $data[$key];			// Unsauber - brauche numerisches Array fuer die Uebergabe an das Template
				$data = array();
				$data[0] = $tmp;
				unset($tmp);
			}
		}    
        return $data;        
    }
	
	public function create_html($data) {
		$output = '';
		if ( !is_array($data) ) {
			$output = "<p>Keinen Eintrag mit der angegebenen ID gefunden</p>";	
		}
		elseif (count(array_filter($data)) == 0) {
			$output = '<p>Es wurden keine studentischen Arbeiten gefunden.</p>';
		} else {
			$output .= '<div><h2>' . ucfirst($this->task) . '</h2>';
			switch($this->format) {
				case 'accordion': 
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
		
		if (count(array_filter($data)) == 0) {
			$output = '<p>Es wurden keine studentischen Arbeiten gefunden.</p>';
		} else {					
			foreach ($data as $heading => $arr) {
				$output .= '<div><h2>' . ucfirst($heading) . '</h2>';
				switch($this->format) {
					case 'accordion': 
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