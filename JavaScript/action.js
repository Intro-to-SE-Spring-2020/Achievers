/* This file handles interactions between the user and the site */

// Function that handles posting of a tweet
function postTweet(){

	// Selection choice for the php to handle what action 
	var selected = 'postTweet';

	// Creating a timestamp for tweets
	var timestamp = new Date();
	var tweetDate = timestamp;
	var tweetTime = timestamp.toLocaleTimeString();

	// Pulling the username for the active user and tweet body from the site
	var username = localStorage.getItem('username');
	var tweet = document.getElementById('tweetBody').value;

	// Request to send information to tweet
	var postTweetRequest = new XMLHttpRequest();
	postTweetRequest.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200){
			showTweets();
		}
	};

	// Sending information to php file
	postTweetRequest.open("GET", "../PHP/tweet.php?selected="+selected+"&username="+username+"&tweet="+tweet+"&tweetDate="+tweetDate+"&tweetTime="+tweetTime, true);
	postTweetRequest.send();

}

// Function that handles displaying tweets
function showTweets(){

	// Selection choice for the php to handle 
	var selected = "showTweets";

	// Pulling the username for the active user from the site
	var username = localStorage.getItem('username');

	// Request to send information to show tweets
	var showTweetsRequest = new XMLHttpRequest();
	showTweetsRequest.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			console.log("Hey look at the users posts! Not the console!");
			document.getElementById('tweetBox').innerHTML = this.responseText;
		}
	};

	// Sending request to the php file
	showTweetsRequest.open("GET", "../PHP/tweet.php?selected="+selected+"&username="+username, true);
	showTweetsRequest.send();

}

// Function that handles liking tweets
function likeTweet(tweet_id){

	// Selection choice for php to handle
	var selected = "likeTweet";

	// Pulling tweet id and username for active username from site
	var tid = tweet_id;
	var username = localStorage.getItem('username');

	// Request to send information for liking tweets
	var likeTweetRequest = new XMLHttpRequest();
	likeTweetRequest.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			document.getElementById(tid+'likes').innerHTML = this.responseText;
		}
	};

	// Sending request to the php file
	likeTweetRequest.open("GET", "../PHP/tweet.php?selected="+selected+"&tid="+tid+"&username="+username, true);
	likeTweetRequest.send();

}

// Function that handles following a user
function followUser(following){

	// Selection choice for php to handle
	var selected = "followUser";

	// Pulling username for active user and follower username
	var username = localStorage.getItem('username');
	var following = following;

	// Request to send information for following a user
	var followUserRequest = new XMLHttpRequest();
	followUserRequest.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			// Using the show tweets function allows the follower button to be updated according for all entries (Efficiency for site)
			showTweets();
		}
	};

	// Sending request to php file
	followUserRequest.open("GET", "../PHP/user.php?selected="+selected+"&following="+following+"&username="+username, true);
	followUserRequest.send();
}

// Function that clears the field for the text box
function clearFields(){
	document.getElementById('tweetBody').value = '';
}