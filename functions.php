<?php


function get_bnm_curs(){
	$date_str = ($_SERVER['REQUEST_METHOD'] == 'POST')
		? $_POST['date']
		: 'NOW'
	;
	$date = new DateTime('NOW');
	$xml_source = __DIR__ . DIRECTORY_SEPARATOR . 'curs.xml';
	$xml_string = file_get_contents($xml_source);
	$xml = new SimpleXMLElement(trim($xml_string));

	$allow_code = ['EUR','USD','RUB','RON'];

	$curs = [];
	foreach($xml->Valute as $valute) {
		$code = (string) $valute?->CharCode;
		if(in_array($code, $allow_code)) {
			$id = (int) $valute['ID'];
			$name = (string) $valute?->Name;
			$value = (float) $valute?->Value;
			$nominal = (float) $valute?->Nominal;
			$curs[$id] = compact('code','name','value','nominal');
		}
	}
	return $curs;
}