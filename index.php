<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('functions.php');

$date_str = ($_SERVER['REQUEST_METHOD'] == 'POST')
	? $_POST['date']
	: 'NOW'
;
$date = new DateTime('NOW');
$allow_code = ['EUR','USD','RUB','RON'];

$data = get_bnm_curs($date, $allow_code);

echo('<pre>');
print_r($data);