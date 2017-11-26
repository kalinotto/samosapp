<?php
// DO NOT CHANGE
require 'db.php';

//we will be logging into phpMyadmin from this script

$name = $_GET['name'];
$location = $_GET['location'];
$start = $_GET['start'];
$end = $_GET['end'];

$lat = $_GET['lat'];
$lng = $_GET['lng'];

$query = 	"INSERT INTO markers (name, location, start, end, lat, lng) VALUES 
			('$name', '$location', '$start', '$end', '$lat', '$lng')";
$db = getDB();
$result = $db->query($query);

if(!$result){
	die('Invalid query fool: ' . mysql_error());
}

?>