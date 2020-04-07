/* This file is a JavaScript file that handles functions dealing with accounts corresponding to our website */

// Function to create an account
function accountCreate() {
	
	// Selection choice for php to handle
	var selected = "accountCreate";

	// Pulling user information from the site
	var username = document.getElementById('Username').value;
	var password = document.getElementById('Password').value;
	var email = document.getElementById('Email').value;
	var confirmPass = document.getElementById('ConfirmPass').value;

	// Simple password checking to make sure passwords are equal
	if (password != confirmPass) {
		document.getElementById('output').innerHTML = "Passwords do not match!";
	}

	else {
		// New request to send user information for account creation
		var createAccountRequest = new XMLHttpRequest();
		createAccountRequest.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200){
				document.getElementById('output').innerHTML = this.responseText;
			}
		};

		// Sending request for account creation
		createAccountRequest.open("GET", "../PHP/user.php?selected="+selected+"&username="+username+"&password="+password+"&confirmPass="+confirmPass+"&email="+email, true);
		createAccountRequest.send();

		// Interval function to check for successful account
		setInterval(function() {

		// If it succeeds then redirect to login
		if (createAccountRequest.responseText === "Account Created! Redirecting you to login! If not redirected automatically, <a href = login.html>click here</a>") {
			setTimeout(function() {
				window.location.assign("Login.html");
			}, 2000);

		}
		}, 50);
	}
}

// Function to login to an account
function accountLogin(){

	// Selection for php to handle
	var selected = "accountLogin";

	// Pulling the username and password from input on site
	var username = document.getElementById('Username').value;
	var password = document.getElementById('Password').value;

	// New request to send information to login
	var loginAccountRequest = new XMLHttpRequest();
	loginAccountRequest.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200){
			document.getElementById('output').innerHTML = this.responseText;
		}
	};

	// Sending request for account login
	loginAccountRequest.open("GET", "../PHP/user.php?selected="+selected+"&username="+username+"&password="+password, true);
	loginAccountRequest.send();

	// Interval to check for successful login
	setInterval(function() {

		// If it succeeds on logging in then redirect to home page
		if (xhttp.responseText === "Login Successful. Redirecting to you home page. If not redirected automatically, <a href='home.html'>Click Here</a>") {
			localStorage.setItem('username', username)
			setTimeout(function() {
				window.location.assign("Home.html");
			}, 2000);

		}
		}, 50);	

}

// Function to logout of an account
function accountLogout(){

	// Clears the local storage, effectively clearing the account and logging out
	localStorage.clear();
}

// Function to check the active user
function activeUser(){
	var username = localStorage.getItem('username');

	document.getElementById('theuser').innerHTML = username;
}