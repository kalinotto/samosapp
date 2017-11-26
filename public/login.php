<?php
require 'db.php';

if(isset($_GET['uname']) && isset($_GET['psw'])) {
	$uname = $_GET['uname'];
	$phash = $_GET['psw'];

	$sql = "SELECT name FROM Users WHERE name = '$uname' AND phash = '$phash'";
	echo "$sql";
	$db = getDB();

	$stmt = $db->query($sql);
	if ($stmt->rowCount() != 1) {
		// login failed
		echo "Login failed.";
	} else {
		$row = $stmt->fetch();
		$_SESSION['username'] = $row->name;
		$_SESSION['success'] = "Successful login.";
		header('location: index.html');
	}
}
?>