<?php //connect to the db


$mysql_hostname = "127.0.0.1"; //localhost
$mysql_username = "root"; //whatever username is on the phpMyadmin
$mysql_password = "pass"; //whatever the pass was 
$mysql_database = "users"; //whatever we called the userdb on phpmyadmin
$db = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_database) or die("shits whack");
//we will be logging into phpMyadmin from this script

$username = "";
$email = "";
$password = "";
$password_2 = "";

$errors = array();

if(isset($_POST['register'])){ //when register button is pushed

	$username = mysql_real_escape_string($_POST['username']);

	$email = mysql_real_escape_string($_POST['email']);

	$password = mysql_real_escape_string($_POST['password']);
	$password_2 = mysql_real_escape_string($_POST['password2']);

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
		$passwordenc = md5($password); //encrypt password before storing
		$sql = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$passwordenc')"
		mysqli_query($db,$sql);
	}
}



?>
