<?php
header('Content-type: application/xml');
require 'db.php';
//will use php dom functions to output the markers table info as an XML file

//create xml file with a parent node
$doc = new DOMDocument('1.0');
$node = $doc->createElement("markers");
$parnode = $doc->appendChild($node);

//select all rows from table
$db = getDB();

if ($_GET['type'] == "map") {
	$sql = "SELECT * FROM markers WHERE start < CURRENT_TIME AND end > CURRENT_TIME";
} elseif ($_GET['type'] == "sched") {
	$sql = "SELECT * FROM markers WHERE DATEDIFF(start, CURRENT_DATE) = 0";
} elseif ($_GET['type'] == "created") {
	$uid = $_GET['uid'];
	$sql = "SELECT * FROM markers WHERE uid = $uid";
}
$result = $db->prepare($sql);
$result->setFetchMode(PDO::FETCH_ASSOC);
$result->execute();

if(!$result){
	die('Invalid query: ' . mysql_error());
}


//create xml node for each row
while($row = $result->fetch()){
		//add row info as a node
		
		$node = $doc->createElement("marker");
		$newnode = $parnode->appendChild($node);
		$newnode->setAttribute("id", $row['mid']);
		$newnode->setAttribute("name", $row['name']);
		$newnode->setAttribute("location", $row['location']);
		$newnode->setAttribute("start", $row['start']);
		$newnode->setAttribute("end", $row['end']);
		$newnode->setAttribute("lat", $row['lat']);
		$newnode->setAttribute("lng", $row['lng']);	
		$newnode->setAttribute("notes", $row['notes']);	
}
$xmlfile = $doc->saveXML();
echo $xmlfile;

?>