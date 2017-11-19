<?php
	function getDB() {
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "testpw";
		$dbname = "samosadb";
		$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $dbConnection;
	}
?>