<?php

$mysql_hostname = "127.0.0.1"; //localhost
$mysql_username = "root"; //whatever username is on the phpMyadmin
$mysql_password = "pass"; //whatever the pass was 
$mysql_database = "users"; //whatever we called the userdb on phpmyadmin
$db = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
//we will be logging into phpMyadmin from this script


//will use php dom functions to output the markers table info as an XML file

//create xml file with a parent node
$doc = domxml_new_doc("1.0");
$node = $doc->create_element("markers");
$parnode = $doc->append_child($node);


//select all rows from table
$query = "SELECT * FROM markers WHERE 1";
$result = mysql_query($query);
if(!$result){
	die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

//create xml node for each row
while($row = @mysql_fetch_assoc($result)){
		//add row info as a node
		$node = $doc->create_element("marker");
		$newnode = $parnode->append_child($node);
	
		$newnode->set_attribute("id", $row['id']);
		$newnode->set_attribute("name", $row['name']);
		$newnode->set_attribute("location", $row['location']);
		$newnode->set_attribute("start", $row['start']);
		$newnode->set_attribute("end", $row['end']);
		$newnode->set_attribute("lat", $row['lat']);
		$newnode->set_attribute("lng", $row['lng']);

	
}

$xmlfile = $doc ->dump_mem();
echo $xmlfile;

?>