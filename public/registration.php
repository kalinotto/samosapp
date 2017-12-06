<?php //connect to the db
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

$errors = array();

if(isset($_POST['register'])){ //when register button is pushed
	$db = getDB();

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_2 = $_POST['password2'];
	
	if (empty($username)){
		array_push($errors,"Username is required, facehead");	
	}
	if (empty($email)){
		array_push($errors,"Email is required, facehead");	
	}
	if (empty($password)){
		array_push($errors,"Password is required, facehead");	
	}
	if ($password_2 != $password){
		array_push($errors,"THEY ARENT THE SAME WHAT ARE YOU TRYING TO PULL");
	}
	//continue if no errors are raised by the dumb dumb users
	if (count($errors) == 0){
		//encrypt password before storing
		$phash = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO users (name, phash, email) VALUES ('$username', '$phash', '$email')";
		//echo "$sql";
		$stmt = $db->prepare($sql);
		//$stmt->bind_param('sss', $username, $password, $email);
		if ($stmt->execute() == TRUE ) {
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "Successful login.";
			$_SESSION['uid'] = $db->query("SELECT uid FROM users WHERE name = '$username'")->fetch()['uid'];
			header('location: index.php');
		}
	} else {
		// idk are these things??
		//$err = $errors->pop();
		echo "Error";
	}
}
?>