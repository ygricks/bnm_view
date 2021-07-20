<?php


function get_bnm_curs($date, $allow_code=['EUR']) {
	try {
		// # date format example ...&&date=20.07.2021
		// $bnm_url = 'https://www.bnm.md/en/official_exchange_rates?get_xml=1&date=%s';
		// $xml_source = sprintf($bnm_url, $date->format('d.m.Y'));

		# file test
		$xml_source = __DIR__ . DIRECTORY_SEPARATOR . 'curs.xml';

		$xml_string = file_get_contents($xml_source);
		$xml = new SimpleXMLElement(trim($xml_string));

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
		return [
			'date' => (string) $xml['Date'],
			'curs' => $curs
		];
	} catch (Exception $e) {
		return null;	
	}
}