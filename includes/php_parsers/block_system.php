<?php
	include_once("../php_includes/db.php");
?><?php
if (isset($_POST['type']) && isset($_POST['blockee'])){
	$blockee = $_POST['blockee'];
	$userName = $_POST['username'];	
	$sql = "SELECT COUNT(id) FROM users WHERE username='$blockee' AND activated='1' LIMIT 1";
	$query = mysqli_query($conn_users, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($conn_users);
		echo "$blockee does not exist.";
		exit();
	}
	$sql = "SELECT id FROM blockedusers WHERE blocker='$userName' AND blockee='$blockee' LIMIT 1";
	$query = mysqli_query($conn_users, $sql);
	$numrows = mysqli_num_rows($query);
	if($_POST['type'] == "block"){
	    if ($numrows > 0) {
			mysqli_close($conn_users);
	        echo "You already have this member blocked.";
	        exit();
	    } else {
			$sql = "INSERT INTO blockedusers(blocker, blockee, blockdate) VALUES('$userName','$blockee',now())";
			$query = mysqli_query($conn_users, $sql);
			mysqli_close($conn_users);
	        echo "blocked_ok";
	        exit();
		}
	} else if($_POST['type'] == "unblock"){
	    if ($numrows == 0) {
		    mysqli_close($conn_users);
	        echo "You do not have this user blocked, therefore we cannot unblock them.";
	        exit();
	    } else {
			$sql = "DELETE FROM blockedusers WHERE blocker='$userName' AND blockee='$blockee' LIMIT 1";
			$query = mysqli_query($conn_users, $sql);
			mysqli_close($conn_users);
	        echo "unblocked_ok";
	        exit();
		}
	}
}
?>