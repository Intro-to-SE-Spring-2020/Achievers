function accountCreate() {
	var selected = "accountCreate";
	var username = document.getElementById('Username').value;
	var password = document.getElementById('Password').value;
	var email = document.getElementById('Email').value;
	var confirmPass = document.getElementById('ConfirmPass').value;

	if (password != confirmPass) {
		document.getElementById('output').innerHTML = "Passwords do not match!";
	}

	else {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200){
				document.getElementById('output').innerHTML = this.responseText;
			}
		};

		xhttp.open("GET", "user.php?selected="+selected+"&username="+username+"&password="+password+"&confirmPass="+confirmPass+"&email="+email, true);
		xhttp.send();

		setInterval(function() {
		if (xhttp.responseText === "Account Created! Redirecting you to login! If not redirected automatically, <a href = login.html>click here</a>") {
			setTimeout(function() {
				window.location.replace("Login.html");
			}, 2000);

		}
		}, 50);
	}
}

function accountLogin(){

	var selected = "accountLogin";
	var username = document.getElementById('Username').value;
	var password = document.getElementById('Password').value;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200){
			document.getElementById('output').innerHTML = this.responseText;
		}
	};

	xhttp.open("GET", "user.php?selected="+selected+"&username="+username+"&password="+password, true);
	xhttp.send();

	setInterval(function() {
		if (xhttp.responseText === "Login Successful. Redirecting to you home page. If not redirected automatically, <a href='home.html'>Click Here</a>") {
			setTimeout(function() {
				window.location.replace("Home.html");
			}, 2000);

		}
		}, 50);	

}