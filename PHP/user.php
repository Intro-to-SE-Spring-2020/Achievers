<?php
/* PHP file that handles any interactions that may have to deal with the users on the database */

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

	// Checking for username and password
	$username = strval($_REQUEST['username']);
	$password = strval($_REQUEST['password']);

	// Username checking to see if username exists
	$userCheckQuery = "select username from users where username = '$username';";
	$userCheck = $conn->query($userCheckQuery);
	$userResult = $userCheck->fetch_array();

	if($userResult[0] == $username) {
		// Password checking to see if the password is correct
		$passCheckQuery = "select password from users where username = '$username';";
		$passCheck = $conn->query($passCheckQuery);
		$passCheckResult = $passCheck->fetch_array();

		// Successful login, echoes response for JS to login account
		if($passCheckResult[0] == $password) {
			echo "Login Successful. Redirecting to you home page. If not redirected automatically, <a href='home.html'>Click Here</a>";
		}

		// Incorrect password message (To keep ambiguity and for security, we make error message the same)
		else{
			echo "Incorrect user/pass combo!";
		}
	}

	// Incorrect user message
	else{
		echo "Incorrect user/pass combo!";
	}

}

if($selected == "followuser"){

	// Pulls the values to use for database entry
	$username = strval($_REQUEST['username']);
	$following = strval($_REQUEST['following']);

	// Find the userid for the current active user
	$userIdQuery = "SELECT uid from users where username = '$username';";
	$userIdCheck = $conn->query($userIdQuery);
	$userIdResult = $userIdCheck->fetch_array();

	// Find the userid for the desired user to follow
	$followIdQuery = "SELECT uid from users where username = '$following';";
	$followIdCheck = $conn->query($followIdQuery);
	$followIdResult = $followIdCheck->fetch_array();

	// Check to see if you are already folloing them
	$followStatusQuery = "SELECT user_id from following where user_id = '$userIdResult[0]' and follower_id = '$followIdResult[0]';";
	$followStatusCheck = $conn->query($followStatusQuery);
	$followStatusResult = $followStatusCheck->fetch_array();

	// If you are not already following them then add to the following table of database
	if(!$followStatusResult){
		$followAddQuery = "INSERT into following (user_id, follower_id) values ('$userIdResult[0]', '$followIdResult[0]');";
		$followAddCheck = $conn->query($followAddQuery);
	}

	// If you are already following them then delete from the following table of database
	else{
		$followRemoveQuery = "DELETE from following where user_id = '$userIdResult[0]' and follower_id = '$followIdResult[0]';";
		$followRemoveCheck = $conn->query($followRemoveQuery);
	}

}


?>
