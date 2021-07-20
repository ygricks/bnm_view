<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$a = 200;
require_once('functions.php');
$data = get_bnm_curs();

echo('<pre>');
print_r($data);