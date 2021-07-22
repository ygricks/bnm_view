<?php

function connect() {
	$link = false;
	if($link===false) {
		$link = new mysqli("localhost", "root", "pass", "curs_db");	
		if ($link->connect_errno) {
			die("db connection fail: " . $link->connect_error . "\n");
		}
	}
	return $link;
}

function db_setUp() {
	# CREATE DATABASE curs_db CHARACTER SET utf8 COLLATE utf8_general_ci;
	$req = "CREATE TABLE IF NOT EXISTS `%s`(
		date DATE NOT NULL,
		code char(3) NOT NULL,
		name varchar(30) NOT NULL,
		value decimal(15, 4) NOT NULL,
		nominal decimal(15, 4) NOT NULL,
		PRIMARY KEY (date, code)
	)";
	$mysqli = connect();
	$mysqli->query(sprintf($req, 'curs'));
	$mysqli->query(sprintf($req, 'curt'));
	// # procedure
	$mysqli->query("DROP PROCEDURE IF EXISTS p");
	$mysqli->query("CREATE PROCEDURE p(day VARCHAR(10), code_list TEXT)
	BEGIN SELECT * FROM curs WHERE FIND_IN_SET(code, code_list)>0 AND date=DATE(day); END;");
	$mysqli->query("SET GLOBAL event_scheduler = ON");
	$mysqli->query("DROP EVENT IF EXISTS b");
	$mysqli->query("CREATE EVENT IF NOT EXISTS b ON SCHEDULE EVERY 23 DAY_HOUR DO INSERT INTO curt (date,code,name,value,nominal) SELECT  date,code,name,value,nominal FROM curs WHERE date=DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
}

function db_insert_curs($data) {
	$req = "INSERT INTO `curs`(date,code,name,value,nominal) VALUES ";
	$values = [];
	foreach($data as $valute) {
		$value = sprintf("('%s','%s','%s','%s', '%s')",
			$valute['date'],
			$valute['code'],
			$valute['name'],
			$valute['value'],
			$valute['nominal']
		);
		$values[] = $value;
	}
	if(count($values)) {
		$req .= implode(' , ', $values);
		$mysqli = connect();
		try{
			if(!$mysqli->query($req)) {
				throw new Exception('error inert!');
			}
		}catch( Exception $e ){
			$mysqli->rollback();
		}
		$mysqli->commit();
	}
}

function get_db_curs_proc($date, $allow_code) {
	$mysqli = connect();

	$request = sprintf("CALL p('%s','%s')", $date->format('Y-m-d'), implode(',',$allow_code));
	$result = $mysqli->query($request);

	$data = [];
	while($row = $result->fetch_assoc()) {
	    $data[] = $row;
	}

	return $data;
}