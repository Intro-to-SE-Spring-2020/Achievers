<?php


require_once("header.php");
$selected = strtolower(strval($_REQUEST['selected']));

if($selected == "posttweet") {
	$username = strval($_REQUEST['username']);
	$tweet = strval($_REQUEST['tweet']);
	$tweetDate = strval($_REQUEST['tweetDate']);
	$tweetTime = strval($_REQUEST['tweetTime']);

	$userIdQuery = "select uid from users where username = '$username';";
	$userIdCheck = $conn->query($userIdQuery);
	$userIdResult = $userIdCheck->fetch_array();

	$userId = $userIdResult['uid'];

	$tweetQuery = "Insert into tweets (uid, body, date, time) values ('$userId', '$tweet', '$tweetDate', '$tweetTime');";
	$tweetCheck = $conn->query($tweetQuery);

	echo "Success";

}

if($selected == "showtweets"){
	$getTweetsQuery = "select U.username, T.date, T.time, T.body from tweets T, users U where T.uid = U.uid;";
	$getTweetsCheck = $conn->query($getTweetsQuery);

	echo "<table>";
	echo "<tr>";
	echo "<th>User</th>";
	echo "<th>Tweet</th>";
	echo "<th>Date</th>";
	echo "<th>Time</th>";
	echo "</tr>";

	while ($getTweetsResult = $getTweetsCheck->fetch_array()) {
		echo "<tr>" . "<td>" . $getTweetsResult['username'] . "</td>";
		echo "<td>" . $getTweetsResult['body'] . "</td>";
		echo "<td>" . $getTweetsResult['date'] . "</td>";
		echo "<td>" . $getTweetsResult['time'] . "</td>" . "</tr>";
	}
}

?>