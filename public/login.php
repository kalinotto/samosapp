<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

$uname = $_POST['uname'];
$password = $_POST['psw'];

$sql = "SELECT uid, phash FROM users WHERE name = '$uname'";
$db = getDB();

$stmt = $db->query($sql);
$row = $stmt->fetch();

if (password_verify($password, $row['phash'])) {
	$_SESSION['username'] = $uname;
	$_SESSION['success'] = true;
	$_SESSION['uid'] = $row['uid']; 
	header('location: index.php');
} else {
	echo "Login failed. <a href='index.php'>Return</a>";
}
?>