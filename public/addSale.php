<?php

$mysql_hostname = "127.0.0.1"; //localhost
$mysql_username = "root"; //whatever username is on the phpMyadmin
$mysql_password = "pass"; //whatever the pass was 
$mysql_database = "users"; //whatever we called the userdb on phpmyadmin
$db = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
//we will be logging into phpMyadmin from this script

$name = $_GET['name'];
$location = $_GET['location'];
$start = $_GET['start'];
$end = $_GET['end'];

$lat = $_GET['lat'];
$lng = $_GET['lng'];

$query = sprintf("INSERT INTO markers " .
				"(id, name, location, start, end, lat, lng) " .
				" VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s');",
				mysqli_real_escape_string($name);
				mysqli_real_escape_string($location);
				mysqli_real_escape_string($start);
				mysqli_real_escape_string($end);
				mysqli_real_escape_string($lat);
				mysqli_real_escape_string($lng);
$result = mysql_query($query);

if(!$result){
	die('Invalid query fool: ' . mysql_error());
}

?>