<?php
session_start();
require 'db.php';

$uname = $_POST['uname'];
$phash = $_POST['psw'];

$sql = "SELECT name FROM Users WHERE name = '$uname' AND phash = '$phash'";
$db = getDB();

$stmt = $db->query($sql);
if ($stmt->rowCount() != 1) {
	// login failed
	echo "Login failed. <a href='index.html'>Return</a>";
} else {
	$row = $stmt->fetch();
	$_SESSION['username'] = $row->name;
	$_SESSION['success'] = true;
	header('location: index.html');
}
?>