<?php
// DO NOT CHANGE
require 'db.php';
echo "CALLED ADD SALE";
//we will be logging into phpMyadmin from this script

$uid = $_GET['uid'];
$name = $_GET['name'];
$location = $_GET['location'];
$start = str_replace("T", " ", $_GET['start']);
$end = str_replace("T", " ", $_GET['end']);
$notes = $_GET['notes'];

$lat = $_GET['lat'];
$lng = $_GET['lng'];

$query = 	"INSERT INTO markers (uid, name, location, start, end, lat, lng, notes) VALUES 
			('$uid', '$name', '$location', '$start', '$end', '$lat', '$lng', '$notes')";
$db = getDB();
$result = $db->query($query);

if(!$result){
	die('Invalid query fool: ' . mysql_error());
}

?>