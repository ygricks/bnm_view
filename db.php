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
	$req = "CREATE TABLE IF NOT EXISTS `curs`(
		date DATE NOT NULL,
		code char(3) NOT NULL,
		name varchar(30) NOT NULL,
		value decimal(15, 4) NOT NULL,
		nominal decimal(15, 4) NOT NULL,
		PRIMARY KEY (date, code)
	)";
	$mysqli = connect();
	return $mysqli->query($req);
}

function db_insert_curs($data) {
	// insert curs
}