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
    } else {
        // New request to send user information for account creation
        var createAccountRequest = new XMLHttpRequest();
        createAccountRequest.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('output').innerHTML = this.responseText;
            }
        };

        // Sending request for account creation
        createAccountRequest.open("GET", "../PHP/user.php?selected=" + selected + "&username=" + username + "&password=" + password + "&confirmPass=" + confirmPass + "&email=" + email, true);
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
function accountLogin() {

    // Selection for php to handle
    var selected = "accountLogin";

    // Pulling the username and password from input on site
    var username = document.getElementById('Username').value;
    var password = document.getElementById('Password').value;

    // New request to send information to login
    var loginAccountRequest = new XMLHttpRequest();
    loginAccountRequest.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('output').innerHTML = this.responseText;
        }
    };

    // Sending request for account login
    loginAccountRequest.open("GET", "../PHP/user.php?selected=" + selected + "&username=" + username + "&password=" + password, true);
    loginAccountRequest.send();

    // Interval to check for successful login
    setInterval(function() {

        // If it succeeds on logging in then redirect to home page
        if (loginAccountRequest.responseText === "Login Successful. Redirecting to you home page. If not redirected automatically, <a href='home.html'>Click Here</a>") {
            localStorage.setItem('username', username)
            setTimeout(function() {
                window.location.assign("Home.html");
            }, 2000);

        }
    }, 50);

}


function accountUserUpdate() {
    var selected = "updateAccount";
    var choice = "updateUsername";

    var username = localStorage.getItem('username');

    var newUsername = document.getElementById('newUsername').value;

    var userUpdateRequest = new XMLHttpRequest();
    userUpdateRequest.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != "Success") {
                document.getElementById('profileOutput').innerHTML = this.responseText;
            } else {
                alert("You will be logged out! Please sign in with your new username!");
                accountLogout();
                window.location.href = "Home.html";
            }
        }
    };

    userUpdateRequest.open("GET", "../PHP/user.php?selected=" + selected + "&choice=" + choice + "&username=" + username + "&newUsername=" + newUsername, true);
    userUpdateRequest.send();
}

function accountEmailUpdate() {
    var selected = "updateAccount";
    var choice = "updateEmail";

    var username = localStorage.getItem('username');

    var newEmail = document.getElementById('newEmail').value;

    var emailUpdateRequest = new XMLHttpRequest();
    emailUpdateRequest.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != "Success") {
                document.getElementById('profileOutput').innerHTML = this.responseText;
            } else {
                document.getElementById('profileOutput').setAttribute("style", "color:green;");
                document.getElementById('profileOutput').innerHTML = this.responseText;
            }
        }
    };

    emailUpdateRequest.open("GET", "../PHP/user.php?selected=" + selected + "&choice=" + choice + "&username=" + username + "&newEmail=" + newEmail, true);
    emailUpdateRequest.send();
}

function accountPassUpdate() {
    var selected = "updateAccount";
    var choice = "updatePassword";

    var username = localStorage.getItem('username');

    var newPass = document.getElementById('newPassword').value;
    var newConfirmPass = document.getElementById('newConfirmPass').value;

    var passUpdateRequest = new XMLHttpRequest();
    passUpdateRequest.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if (this.responseText != "Success") {
                document.getElementById('profileOutput').innerHTML = this.responseText;
            } else {

                document.getElementById('profileOutput').setAttribute("style", "color:green;");
                document.getElementById('profileOutput').innerHTML = this.responseText;
            }
        }
    };

    passUpdateRequest.open("GET", "../PHP/user.php?selected=" + selected + "&choice=" + choice + "&username=" + username + "&newPass=" + newPass + "&newConfirmPass=" + newConfirmPass, true);
    passUpdateRequest.send();
}


function showFollowing() {

    var selected = "showFollowing";

    var username = localStorage.getItem('username');

    var showFollowingRequest = new XMLHttpRequest();
    showFollowingRequest.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('followingBox').innerHTML = this.responseText;
        }
    };

    showFollowingRequest.open("GET", "../PHP/user.php?selected=" + selected + "&username=" + username, true);
    showFollowingRequest.send();
}

function showFollowers() {

    var selected = "showFollowers";

    var username = localStorage.getItem('username');

    var showFollowersRequest = new XMLHttpRequest();
    showFollowersRequest.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('followerBox').innerHTML = this.responseText;
        }
    };

    showFollowersRequest.open("GET", "../PHP/user.php?selected=" + selected + "&username=" + username, true);
    showFollowersRequest.send();
}

// Function to logout of an account
function accountLogout() {

    // Clears the local storage, effectively clearing the account and logging out
    localStorage.clear();

    window.location.href = "Login.html";
}

// Function to check the active user
function activeUser() {
    var username = localStorage.getItem('username');
    if (!username) {
        document.getElementById('userText').innerHTML = "Guest";
        document.getElementById('logoutText').innerHTML = "Sign In";
        document.getElementById('user').setAttribute("onclick", "window.location.href='Login.html';");
        document.getElementById('followers').setAttribute("onclick", "window.location.href='Login.html';");
        document.getElementById('settings').setAttribute("onclick", "window.location.href='Login.html';");
        document.getElementById('logout').setAttribute("onclick", "window.location.href='Login.html';");
        document.getElementById('signupLink').setAttribute("style", "display:block;");
        document.getElementById('loginLink').setAttribute("style", "display:block;");
    } else {
        document.getElementById('userText').innerHTML = username;
        document.getElementById('logoutText').innerHTML = "Sign Out";
        document.getElementById('user').setAttribute("onclick", "window.location.href='Account_Page.html';");
        document.getElementById('followers').setAttribute("onclick", "window.location.href='Account_Page.html#friends';");
        document.getElementById('settings').setAttribute("onclick", "window.location.href='Account_Settings.html';");
        document.getElementById('logout').setAttribute("onclick", "accountLogout();");
        document.getElementById('signupLink').setAttribute("style", "display:none;");
        document.getElementById('loginLink').setAttribute("style", "display:none;");
    }

}