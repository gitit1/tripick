<?php
	include_once("../php_includes/db.php");
?>
<?php
if (isset($_POST['type']) && isset($_POST['user'])){
	$user = $_POST['user'];
	$userName = $_POST['username'];
	$sql = "SELECT COUNT(id) FROM users WHERE username='$user' AND activated='1' LIMIT 1";
	$query = mysqli_query($conn_users, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($conn_users);
		echo "$user does not exist.";
		exit();
	}
	if($_POST['type'] == "friend"){
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND accepted='1' OR user2='$user' AND accepted='1'";
		$query = mysqli_query($conn_users, $sql);
		$friend_count = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM blockedusers WHERE blocker='$user' AND blockee='$userName' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$blockcount1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM blockedusers WHERE blocker='$userName' AND blockee='$user' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$blockcount2 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$userName' AND user2='$user' AND accepted='1' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$row_count1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND user2='$userName' AND accepted='1' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$row_count2 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$userName' AND user2='$user' AND accepted='0' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$row_count3 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND user2='$userName' AND accepted='0' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$row_count4 = mysqli_fetch_row($query);
	    if($friend_count[0] > 99){
            mysqli_close($conn_users);
	        echo "$user currently has the maximum number of friends, and cannot accept more.";
	        exit();
        } else if($blockcount1[0] > 0){
            mysqli_close($conn_users);
	        echo "$user has you blocked, we cannot proceed.";
	        exit();
        } else if($blockcount2[0] > 0){
            mysqli_close($conn_users);
	        echo "You must first unblock $user in order to friend with them.";
	        exit();
        } else if ($row_count1[0] > 0 || $row_count2[0] > 0) {
		    mysqli_close($conn_users);
	        echo "You are already friends with $user.";
	        exit();
	    } else if ($row_count3[0] > 0) {
		    mysqli_close($conn_users);
	        echo "You have a pending friend request already sent to $user.";
	        exit();
	    } else if ($row_count4[0] > 0) {
		    mysqli_close($conn_users);
	        echo "$user has requested to friend with you first. Check your friend requests.";
	        exit();
	    } else {
	        $sql = "INSERT INTO friends(user1, user2, datemade) VALUES('$userName','$user',now())";
		    $query = mysqli_query($conn_users, $sql);
			mysqli_close($conn_users);
	        echo "friend_request_sent";
	        exit();
		}
	} else if($_POST['type'] == "unfriend"){
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$userName' AND user2='$user' AND accepted='1' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$row_count1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND user2='$userName' AND accepted='1' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$row_count2 = mysqli_fetch_row($query);
	    if ($row_count1[0] > 0) {
	        $sql = "DELETE FROM friends WHERE user1='$userName' AND user2='$user' AND accepted='1' LIMIT 1";
			$query = mysqli_query($conn_users, $sql);
			mysqli_close($conn_users);
	        echo "unfriend_ok";
	        exit();
	    } else if ($row_count2[0] > 0) {
			$sql = "DELETE FROM friends WHERE user1='$user' AND user2='$userName' AND accepted='1' LIMIT 1";
			$query = mysqli_query($conn_users, $sql);
			mysqli_close($conn_users);
	        echo "unfriend_ok";
	        exit();
	    } else {
			mysqli_close($conn_users);
	        echo "No friendship could be found between your account and $user, therefore we cannot unfriend you.";
	        exit();
		}
	}
}
?>
<?php
if (isset($_POST['action']) && isset($_POST['reqid']) && isset($_POST['user1'])){
	$reqid = preg_replace('#[^0-9]#', '', $_POST['reqid']);
	$user = $_POST['user1'];
	$userName = $_POST['username'];
	$sql = "SELECT COUNT(id) FROM users WHERE username='$user' AND activated='1' LIMIT 1";
	$query = mysqli_query($conn_users, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($conn_users);
		echo "$user does not exist.";
		exit();
	}
	if($_POST['action'] == "accept"){
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$userName' AND user2='$user' AND accepted='1' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$row_count1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(id) FROM friends WHERE user1='$user' AND user2='$userName' AND accepted='1' LIMIT 1";
		$query = mysqli_query($conn_users, $sql);
		$row_count2 = mysqli_fetch_row($query);
	    if ($row_count1[0] > 0 || $row_count2[0] > 0) {
		    mysqli_close($conn_users);
	        echo "You are already friends with $user.";
	        exit();
	    } else {
			$sql = "UPDATE friends SET accepted='1' WHERE id='$reqid' AND user1='$user' AND user2='$userName' LIMIT 1";
			$query = mysqli_query($conn_users, $sql);
			mysqli_close($conn_users);
	        echo "accept_ok";
	        exit();
		}
	} else if($_POST['action'] == "reject"){
		mysqli_query($conn_users, "DELETE FROM friends WHERE id='$reqid' AND user1='$user' AND user2='$userName' AND accepted='0' LIMIT 1");
		mysqli_close($conn_users);
		echo "reject_ok";
		exit();
	}
}
?>