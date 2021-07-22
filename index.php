<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('db.php');
db_setUp();
require_once('functions.php');

$allow_code = ['EUR','USD','RUB','RON'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$allow_keys = array_fill_keys($allow_code, 0);
	$selected_code = array_intersect($allow_code, $_POST['code']);
	$selected_keys = array_fill_keys($selected_code, 1);
	$selected = array_merge($allow_keys, $selected_keys);

	$date = new DateTime($_POST['date']);
	$data = db_select_curs_by($date, $selected_code);
	if(!count($data)) {
		$data = get_bnm_curs($date);

		if($data) {
			db_insert_curs($data);
		}
		$data = db_select_curs_by($date, $selected_code);
	}
	$body = template('select_date', [
		'code' => $selected,
		'date' => $date
	]);
	$body .= template('show',[
		'header' => 'exchange rate for ' . $date->format('Y-m-d'),
		'data' => $data
	]);
	echo(template('layout',[
		'title' => $date->format('Y-m-d'),
		'body' => $body
	]));
} else {
	$allow_keys = array_fill_keys($allow_code, 1);
	$date = new DateTime('NOW');
	$body = template('select_date', [
		'code' => $allow_keys,
		'date' => $date
	]);
	echo(template('layout',[
		'title' => 'main page',
		'body' => $body
	]));
}

