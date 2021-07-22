<?php

function get_bnm_curs($date) {
	try {
		# date format example ...&&date=20.07.2021
		$bnm_url = 'https://www.bnm.md/en/official_exchange_rates?get_xml=1&date=%s';
		$xml_source = sprintf($bnm_url, $date->format('d.m.Y'));

		@$xml_string = file_get_contents($xml_source);
		$xml = new SimpleXMLElement(trim($xml_string));

		$date = $date->format('Y-m-d');
		$curs = [];
		foreach($xml->Valute as $valute) {
			$code = (string) $valute?->CharCode;
			$name = (string) $valute?->Name;
			$value = (float) $valute?->Value;
			$nominal = (float) $valute?->Nominal;
			$curs[] = compact('code', 'name', 'value', 'nominal', 'date');
		}
		return $curs;
	} catch (Exception $e) {
		return null;
	}
}

function template($template, $values=[]) {
	ob_start();
	extract($values);
	require_once('template' . DIRECTORY_SEPARATOR . $template . '.php');
	return ob_get_clean();
}
