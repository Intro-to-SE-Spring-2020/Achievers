function postTweet(){
	var timestamp = new Date();
	var tweetDate = timestamp.toLocaleDateString();
	var tweetTime = timestamp.toLocaleTimeString();

	var username = localStorage.getItem('username');
	var tweet = document.getElementById('tweetBody').value;
	var selected = "postTweet";

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200){
			console.log("What are you looking at?");
		}
	};

	xhttp.open("GET", "tweet.php?selected="+selected+"&username="+username+"&tweet="+tweet+"&tweetDate="+tweetDate+"&tweetTime="+tweetTime, true);
	xhttp.send();

}

function showTweets(){

	var selected = "showTweets";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			console.log("Hey look at the users posts! Not the console!");
			document.getElementById('tweetBox').innerHTML = this.responseText;
		}
	};

	xhttp.open("GET", "tweet.php?selected="+selected, true);
	xhttp.send();

}

function clearFields(){
	document.getElementById('tweetBody').value = '';
}