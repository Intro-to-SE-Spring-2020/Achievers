<?php

require("header.php");

function tweetSanitization($tweetBody) {

	$stripTweet = trim($tweetBody);
	if($stripTweet == "") {
		$valid = "False";
	}

	else{
		$valid = "True";
	}

	return $valid;
}

function accountCreateSanitization($username, $password, $confirmPass, $email) {
		$stripUsername = trim($username);
		$stripPassword = trim($password);
		$stripEmail = trim($email);

		if($stripUsername == "" or $stripPassword == "" or $stripEmail == "") {
			$error = "All fields must be completed";
		}

		else{
			if(strlen($stripPassword) < 8 or strlen($stripPassword) > 16) {
				$error = "Passwords must be at least 8 and no larger than 16 characters!";
			}

			else{
				if($stripPassword != $confirmPass){
					$error = "The passwords do not match!";
				}

				else{
					if(!filter_var($stripEmail, FILTER_VALIDATE_EMAIL)){
						$error = "Invalid Email Address!";
					}

					else{
						$error = "Success";
					}
				}
			}
		}

	return $error;

}
?>