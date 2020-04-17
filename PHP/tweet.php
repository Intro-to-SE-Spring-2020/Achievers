<?php
/* This file handles any interactions that may have to deal with tweets on the database */

// Header file for mysql connection
require_once("header.php");
require_once("sanitization.php");

// Selection choice for different operations
$selected = strtolower(strval($_REQUEST['selected']));

if($selected == "posttweet") {
	// Pulling relevant data from JS Request
	$username = strval($_REQUEST['username']);
	$tweet = strval($_REQUEST['tweet']);
	$tweetDate = strval($_REQUEST['tweetDate']);
	$tweetTime = strval($_REQUEST['tweetTime']);

	// Validate the tweet's input
	$tweetValidation = tweetSanitization($tweet);

	if($tweetValidation === "True") {
		// Query to check the userid of the active user
		$userIdQuery = "SELECT uid from users where username = '$username';";
		$userIdCheck = $conn->query($userIdQuery);
		$userIdResult = $userIdCheck->fetch_array();

		$userId = $userIdResult['uid'];

		// Query for posting a tweet is parametrized as to prevent sql injection
		$tweetQuery = $conn->prepare("INSERT into tweets (uid, body, date, time) values ('$userId', ?, '$tweetDate', '$tweetTime');");
		$tweetQuery->bind_param("s", $tweet);
		$tweetQuery->execute();

		echo $tweetValidation;
	}

	else{
		echo $tweetValidation;
	}
}


if($selected == "showtweets"){
	// Pulling current active user from JS
	$username = trim(strval($_REQUEST['username']));

	// Query to pull tweets from the database
	$getTweetsQuery = "SELECT U.username, T.tid, T.date, T.time, T.body FROM tweets T, users U WHERE T.uid = U.uid ORDER BY T.tid DESC;";
	$getTweetsCheck = $conn->query($getTweetsQuery);

	  // If there are no tweets, stop the statement
	  if (!$getTweetsCheck)
	      die($conn->error);

	  			// Loop for printing results of database query
				while ($getTweetsResult = $getTweetsCheck->fetch_array()) {
					// Query to check for like count on the current tweet pulled from the database
					$initialLikesQuery = "SELECT COUNT(user_id) FROM liked WHERE tweet_id = '{$getTweetsResult['tid']}';";
					$initialLikesCheck = $conn->query($initialLikesQuery);
					$initialLikesResult = $initialLikesCheck->fetch_array();
					$initialLikes = $initialLikesResult[0];

					// Query to pull active user's id from the database
					$userIdQuery = "SELECT uid from users where username = '$username';";
					$userIdCheck = $conn->query($userIdQuery);
					$userIdResult = $userIdCheck->fetch_array();

					// Query to pull id of current tweet's poster's id from database
					$posterIdQuery = "SELECT uid from users where username = '{$getTweetsResult['username']}';";
					$posterIdCheck = $conn->query($posterIdQuery);
					$posterIdResult = $posterIdCheck->fetch_array();

					// Query to check if the active user is following the current tweet's poster
					$initialFollowQuery = "SELECT user_id from following where user_id = '$userIdResult[0]' and follower_id = '$posterIdResult[0]';";
					$initialFollowCheck = $conn->query($initialFollowQuery);
					$initialFollowResult = $initialFollowCheck->fetch_array();

					// If they are not following then the follow text is set to Follow
					if(!$initialFollowResult){
						$followText = "Follow";
					}

					// Else it is set to Unfollow
					else{
						$followText = "Unfollow";
					}

					// If the current tweet's poster is the active username then do not display the follow button
					if($getTweetsResult['username'] == $username){
						$followDisplay = 'display:none';
					}

					// Else display the follow button
					else{
						$followDisplay = 'display:block';
					}

					// Formation of the tweet to appear on the website and actual results sent to JS to post
					echo "<div class=\"c\">";
						// Upper class deals with the poster's username, follow button, and likes of tweet
						echo"<div class=\"upper\"><span id=\"tweetUser\">" . $getTweetsResult['username'] . " </span> <script>//followCheck();</script><span class=\"upper-right\"><span id=\"" . $getTweetsResult['tid'] . "likes\">" . $initialLikes . "</span> <button  id=\"like\" class=\"fa fa-thumbs-up\" onclick=\"likeTweet(" . $getTweetsResult['tid'] . ");\"></button></span></div>";

						// Middle class deals with the actual content of the tweet
						echo"<div class=\"middle\">" . $getTweetsResult['body'] . "</div>";

						// Lower class deals with the date and comments of the tweet
						echo"<div class=\"lower\"><button  id=\"follow\" onclick=\"followUser('" . $getTweetsResult['username'] . "');\" style =\"". $followDisplay . "\">" . $followText . "</button><span class=\"lower-right\">" . $getTweetsResult['date'] . "</div>";

					// End of formation
					echo"</div>";
				}
}

if($selected == "showfollowingtweets"){
	// Pulling current active user from JS
	$username = trim(strval($_REQUEST['username']));

	$followingQuery = "SELECT U.uid FROM users U, following F WHERE U.uid = F.follower_id AND F.user_id = (SELECT U2.uid FROM users U2 WHERE U2.username = '$username');";
	$followingCheck = $conn->query($followingQuery);

	while($followingResult = $followingCheck->fetch_array()) {
		// Query to pull tweets from the database
		$getTweetsQuery = "SELECT U.username, T.tid, T.date, T.time, T.body FROM tweets T, users U WHERE T.uid = '$followingResult[0]' AND U.uid = '$followingResult[0]' ORDER BY T.tid DESC;";
		$getTweetsCheck = $conn->query($getTweetsQuery);

		  // If there are no tweets, stop the statement
		  if (!$getTweetsCheck)
		      die($conn->error);

		  			// Loop for printing results of database query
					while ($getTweetsResult = $getTweetsCheck->fetch_array()) {
						// Query to check for like count on the current tweet pulled from the database
						$initialLikesQuery = "SELECT COUNT(user_id) FROM liked WHERE tweet_id = '{$getTweetsResult['tid']}';";
						$initialLikesCheck = $conn->query($initialLikesQuery);
						$initialLikesResult = $initialLikesCheck->fetch_array();
						$initialLikes = $initialLikesResult[0];

						// Query to pull active user's id from the database
						$userIdQuery = "SELECT uid from users where username = '$username';";
						$userIdCheck = $conn->query($userIdQuery);
						$userIdResult = $userIdCheck->fetch_array();

						// Query to pull id of current tweet's poster's id from database
						$posterIdQuery = "SELECT uid from users where username = '{$getTweetsResult['username']}';";
						$posterIdCheck = $conn->query($posterIdQuery);
						$posterIdResult = $posterIdCheck->fetch_array();

						// Query to check if the active user is following the current tweet's poster
						$initialFollowQuery = "SELECT user_id from following where user_id = '$userIdResult[0]' and follower_id = '$posterIdResult[0]';";
						$initialFollowCheck = $conn->query($initialFollowQuery);
						$initialFollowResult = $initialFollowCheck->fetch_array();

						// If they are not following then the follow text is set to Follow
						if(!$initialFollowResult){
							$followText = "Follow";
						}

						// Else it is set to Unfollow
						else{
							$followText = "Unfollow";
						}

						// If the current tweet's poster is the active username then do not display the follow button
						if($getTweetsResult['username'] == $username){
							$followDisplay = 'display:none';
						}

						// Else display the follow button
						else{
							$followDisplay = 'display:block';
						}

						// Formation of the tweet to appear on the website and actual results sent to JS to post
						echo "<div class=\"c\">";
							// Upper class deals with the poster's username, follow button, and likes of tweet
							echo"<div class=\"upper\"><span id=\"tweetUser\">" . $getTweetsResult['username'] . " </span> <script>followCheck();</script><span class=\"upper-right\"><span id=\"" . $getTweetsResult['tid'] . "follow\">" . $initialLikes . "</span> <button  id=\"like\" class=\"fa fa-thumbs-up\" onclick=\"likeTweet(" . $getTweetsResult['tid'] . ");\"></button></span></div>";

							// Middle class deals with the actual content of the tweet
							echo"<div class=\"middle\">" . $getTweetsResult['body'] . "</div>";

							// Lower class deals with the date and comments of the tweet
							echo"<div class=\"lower\"><button  id=\"follow\" onclick=\"followUser('" . $getTweetsResult['username'] . "');\" style =\"". $followDisplay . "\">" . $followText . "</button><span class=\"lower-right\">" . $getTweetsResult['date'] . "</div>";

						// End of formation
						echo"</div>";
					}
	}

}

if($selected == "showbesttweets"){
	// Pulling current active user from JS
	$username = trim(strval($_REQUEST['username']));

	// Query to pull tweets from the database
	$getTweetsQuery = "SELECT U.username, T.tid, T.date, T.time, T.body FROM tweets T, users U WHERE T.uid = U.uid ORDER BY (SELECT COUNT(L.user_id) FROM liked L WHERE T.tid = L.tweet_id) DESC;";
	$getTweetsCheck = $conn->query($getTweetsQuery);

	  // If there are no tweets, stop the statement
	  if (!$getTweetsCheck)
	      die($conn->error);

	  			// Loop for printing results of database query
				while ($getTweetsResult = $getTweetsCheck->fetch_array()) {
					// Query to check for like count on the current tweet pulled from the database
					$initialLikesQuery = "SELECT COUNT(user_id) FROM liked WHERE tweet_id = '{$getTweetsResult['tid']}';";
					$initialLikesCheck = $conn->query($initialLikesQuery);
					$initialLikesResult = $initialLikesCheck->fetch_array();
					$initialLikes = $initialLikesResult[0];

					// Query to pull active user's id from the database
					$userIdQuery = "SELECT uid from users where username = '$username';";
					$userIdCheck = $conn->query($userIdQuery);
					$userIdResult = $userIdCheck->fetch_array();

					// Query to pull id of current tweet's poster's id from database
					$posterIdQuery = "SELECT uid from users where username = '{$getTweetsResult['username']}';";
					$posterIdCheck = $conn->query($posterIdQuery);
					$posterIdResult = $posterIdCheck->fetch_array();

					// Query to check if the active user is following the current tweet's poster
					$initialFollowQuery = "SELECT user_id from following where user_id = '$userIdResult[0]' and follower_id = '$posterIdResult[0]';";
					$initialFollowCheck = $conn->query($initialFollowQuery);
					$initialFollowResult = $initialFollowCheck->fetch_array();

					// If they are not following then the follow text is set to Follow
					if(!$initialFollowResult){
						$followText = "Follow";
					}

					// Else it is set to Unfollow
					else{
						$followText = "Unfollow";
					}

					// If the current tweet's poster is the active username then do not display the follow button
					if($getTweetsResult['username'] == $username){
						$followDisplay = 'display:none';
					}

					// Else display the follow button
					else{
						$followDisplay = 'display:block';
					}

					// Formation of the tweet to appear on the website and actual results sent to JS to post
					echo "<div class=\"c\">";
						// Upper class deals with the poster's username, follow button, and likes of tweet
						echo"<div class=\"upper\"><span id=\"tweetUser2\">" . $getTweetsResult['username'] . " </span> <script>followCheck();</script><span class=\"upper-right\"><span id=\"" . $getTweetsResult['tid'] . "best\">" . $initialLikes . "</span> <button  id=\"like\" class=\"fa fa-thumbs-up\" onclick=\"likeTweet(" . $getTweetsResult['tid'] . ");\"></button></span></div>";

						// Middle class deals with the actual content of the tweet
						echo"<div class=\"middle\">" . $getTweetsResult['body'] . "</div>";

						// Lower class deals with the date and comments of the tweet
						echo"<div class=\"lower\"><button  id=\"follow\" onclick=\"followUser('" . $getTweetsResult['username'] . "');\" style =\"". $followDisplay . "\">" . $followText . "</button><span class=\"lower-right\">" . $getTweetsResult['date'] . "</div>";

					// End of formation
					echo"</div>";
				}
}

if($selected == "showusertweets"){
	// Pulling current active user from JS
	$username = trim(strval($_REQUEST['username']));

	// Query to pull tweets from the database
	$getTweetsQuery = "SELECT U.username, T.tid, T.date, T.time, T.body FROM tweets T, users U WHERE T.uid = U.uid AND U.username = '$username' ORDER BY T.tid DESC;";
	$getTweetsCheck = $conn->query($getTweetsQuery);

	  // If there are no tweets, stop the statement
	  if (!$getTweetsCheck)
	      die($conn->error);

	  			// Loop for printing results of database query
				while ($getTweetsResult = $getTweetsCheck->fetch_array()) {
					// Query to check for like count on the current tweet pulled from the database
					$initialLikesQuery = "SELECT COUNT(user_id) FROM liked WHERE tweet_id = '{$getTweetsResult['tid']}';";
					$initialLikesCheck = $conn->query($initialLikesQuery);
					$initialLikesResult = $initialLikesCheck->fetch_array();
					$initialLikes = $initialLikesResult[0];

					// Query to pull active user's id from the database
					$userIdQuery = "SELECT uid from users where username = '$username';";
					$userIdCheck = $conn->query($userIdQuery);
					$userIdResult = $userIdCheck->fetch_array();

					// Query to pull id of current tweet's poster's id from database
					$posterIdQuery = "SELECT uid from users where username = '{$getTweetsResult['username']}';";
					$posterIdCheck = $conn->query($posterIdQuery);
					$posterIdResult = $posterIdCheck->fetch_array();

					// Query to check if the active user is following the current tweet's poster
					$initialFollowQuery = "SELECT user_id from following where user_id = '$userIdResult[0]' and follower_id = '$posterIdResult[0]';";
					$initialFollowCheck = $conn->query($initialFollowQuery);
					$initialFollowResult = $initialFollowCheck->fetch_array();

					// If they are not following then the follow text is set to Follow
					if(!$initialFollowResult){
						$followText = "Follow";
					}

					// Else it is set to Unfollow
					else{
						$followText = "Unfollow";
					}

					// If the current tweet's poster is the active username then do not display the follow button
					if($getTweetsResult['username'] == $username){
						$followDisplay = 'display:none';
					}

					// Else display the follow button
					else{
						$followDisplay = 'display:block';
					}

					// Formation of the tweet to appear on the website and actual results sent to JS to post
					echo "<div class=\"c\">";
						// Upper class deals with the poster's username, follow button, and likes of tweet
						echo"<div class=\"upper\"><span id=\"tweetUser\">" . $getTweetsResult['username'] . " </span><button  id=\"follow\" onclick=\"followUser('" . $getTweetsResult['username'] . "');\" style =\"". $followDisplay . "\">" . $followText . "</button> <script>followCheck();</script><span class=\"upper-right\"><span id=\"" . $getTweetsResult['tid'] . "best\">" . $initialLikes . "</span> <button  id=\"like\" class=\"fa fa-thumbs-up\" onclick=\"likeTweet(" . $getTweetsResult['tid'] . ");\"></button></span></div>";

						// Middle class deals with the actual content of the tweet
						echo"<div class=\"middle\">" . $getTweetsResult['body'] . "</div>";

						// Lower class deals with the date and comments of the tweet
						echo"<div class=\"lower\"><span class=\"lower-right\">" . $getTweetsResult['date'] . "</div>";

					// End of formation
					echo"</div>";
				}
}

if($selected == "liketweet"){

	// Pulling relevant data from JS (tweet id and current active user)
	$tweetId = strval($_REQUEST['tid']);
	$username = strval($_REQUEST['username']);

	// Query to check the current active user's id
	$userIdQuery = "select uid from users where username = '$username';";
	$userIdCheck = $conn->query($userIdQuery);
	$userIdResult = $userIdCheck->fetch_array();

	$userId = $userIdResult['uid'];

	// Query to pull the tweet's poster's id
	$posterIdQuery = "select uid from tweets where tid = '$tweetId';";
	$posterIdCheck = $conn->query($posterIdQuery);
	$posterIdResult = $posterIdCheck->fetch_array();

	$posterId = $posterIdResult['uid'];

	// If the poster id is the same as the current active user's then pull active like count, but do not add or remove a like
	if($posterId == $userId){

		// Query to pull the current like count from database
		$likeQuery = "SELECT COUNT(user_id) FROM liked WHERE tweet_id = '$tweetId';";
		$likeCheck = $conn->query($likeQuery);
		$likeResult = $likeCheck->fetch_array();

		$likeNum = $likeResult[0];

		// Echo out message that user will see
		echo "This is your tweet with " . $likeNum . " likes";
	}

	// Else update the like count
	else{

		// Query to check if the user has liked this tweet or not
		$likeStatusQuery = "SELECT user_id FROM liked WHERE user_id = '$userId' AND tweet_id = '$tweetId';";
		$likeStatusCheck = $conn->query($likeStatusQuery);
		$likeStatusResult = $likeStatusCheck->fetch_array();

		// If the user has not liked the tweet then add to the liked table and pull updated like count
		if(!$likeStatusResult) {
			$likeAddQuery = "INSERT INTO liked(tweet_id, user_id) values ('$tweetId', '$userId');";
			$likeAddResult = $conn->query($likeAddQuery);

			// Query to pull updated like count
			$likeQuery = "SELECT COUNT(user_id) FROM liked WHERE tweet_id = '$tweetId';";
			$likeCheck = $conn->query($likeQuery);
			$likeResult = $likeCheck->fetch_array();

			$likeNum = $likeResult[0];

			// Echo out updated like count
			echo $likeNum;
		}

		// Else remove from liked table and update the like count
		else{

			// Query to remove the entry from table
			$likeRemoveQuery = "DELETE FROM liked WHERE user_id = '$userId' AND tweet_id = '$tweetId';";
			$likeRemoveResult = $conn->query($likeRemoveQuery);

			// Query to pull updated like count
			$likeQuery = "SELECT COUNT(user_id) FROM liked WHERE tweet_id = '$tweetId';";
			$likeCheck = $conn->query($likeQuery);
			$likeResult = $likeCheck->fetch_array();

			$likeNum = $likeResult[0];

			// Echo out updated like count
			echo $likeNum;
		}
	}

}

?>
