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
		$allow_code = ['EUR','USD','RUB','RON'];
		$data = get_bnm_curs($date, $allow_code);

		db_insert_curs($data);
		// echo '<h3>online xml</h3>';
		// print_r($data);

	}
	echo template('show',['data'=>$data]);
} else {
	$body = template('select_date');
	echo template('layout',[
		'title' => 'main page',
		'body' => $body
	]);
}

