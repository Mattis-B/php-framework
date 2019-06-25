<?

function getJSON($file, &$var){
	if(file_exists($file)){
		$var = json_decode(file_get_contents($file),true);
	}
}
