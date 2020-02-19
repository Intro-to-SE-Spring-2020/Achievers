<?php
// Header file for mysql connection
require_once('header.php');
$selected = strtolower(strval($_REQUEST['selected']));


if($selected == "accountcreate"){
	// Access the values for database entry
	$username = strval($_REQUEST['username']);
	$password = strval($_REQUEST['password']);
	$confirmPass = strval($_REQUEST['confirmPass']);
	$email = strval($_REQUEST['email']);

	// Username check to see if that user already exits
	$userQuery = "select * from users where username = '$username';";
	$userCheck = $conn->query($userQuery);
	$userResult = $userCheck->fetch_array();

	// If it does not exist then insert into users table in database
	if(!$userResult) {

		$query = "insert into users (username, password, email) values ('$username', '$password', '$email');";

		$result = $conn->query($query);
		if(!$result) {
			die($conn->error);
		}

		echo "Account Created! Redirecting you to login! If not redirected automatically, <a href = login.html>click here</a>";

	}

	// Else report that the user already exists
	else{

		echo "That username already exists! Please choose a different username or <a href = login.html>login</a>";

	}	
}

if($selected == "accountlogin"){


}


?>