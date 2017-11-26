<?php
require 'db.php';

if(isset($_GET['login'])) {
	$uname = $_GET['uname'];
	$phash = $_GET['pword'];

	$sql = "SELECT name FROM Users WHERE name = ? AND phash = ?;";
	$sql = bind_param("ss", $uname, $phash);

	$db = getDB();
	
	$stmt = $db->query($sql);
	if ($stmt->num_rows != 1) {
		// login failed
	} else {
		$row = $stmt->fetch_object();
		$_SESSION['username'] = $row->name;
	}
}