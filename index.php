<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('db.php');
require_once('functions.php');

connect();
db_setUp();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$date = new DateTime($_POST['date']);
	$data = get_db_curs($date);
	if(!count($data)) {
		// $allow_code = ['EUR','USD','RUB','RON'];
		$data = get_bnm_curs($date);

		db_insert_curs($data);
		// echo '<h3>online xml</h3>';
		// print_r($data);

	}
	$body = template('show',[
		'header' => 'exchange rate for ' . $date->format('Y-m-d'),
		'data'=>$data
	]);
	echo(template('layout',[
		'title' => $date->format('Y-m-d'),
		'body' => $body
	]));
} else {
	$body = template('select_date');
	echo(template('layout',[
		'title' => 'main page',
		'body' => $body
	]));
}

