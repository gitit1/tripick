<?php
	include_once("../php_includes/db.php");
?>
<?php
// New PM
if (isset($_POST['action']) && $_POST['action'] == "new_pm"){
	// Make sure post data is not empty
	if(strlen($_POST['data']) < 1){
		mysqli_close($conn_users);
	    echo "data_empty";
	    exit();
	}
	// Make sure post data is not empty
	if(strlen($_POST['data2']) < 1){
		mysqli_close($conn_users);
	    echo "data_empty";
	    exit();
	}	
	

	$fuser = $_POST['fuser'];
	$tuser = $_POST['tuser'];
	$data = htmlentities($_POST['data']);
	$data = mysqli_real_escape_string($conn_users, $data);
	$data2 = htmlentities($_POST['data2']);
	$data2 = mysqli_real_escape_string($conn_users, $data2);
		
	$sql_pic = "SELECT * FROM users WHERE username='$fuser' AND activated='1' LIMIT 1";
	$query_pic = mysqli_query($conn_users, $sql_pic);
	while ($row_pic = mysqli_fetch_assoc($query_pic)){
		$avt = $row_pic["avatar"];
		$gender = $row_pic["gender"];
		$fbId = $row_pic["fbId"];	
	}		
	$defaultP = "x";
	$sql = "INSERT INTO pm(receiver, sender, senttime, subject, message, parent,avatar,gender,fbId) 
			VALUES('$tuser','$fuser',now(),'$data2','$data','$defaultP','$avt','$gender','$fbId')";
	$query = mysqli_query($conn_users, $sql);
	mysqli_close($conn_users);
	echo "pm_sent";
	exit();
}
?><?php
// Reply To PM
if (isset($_POST['action']) && $_POST['action'] == "pm_reply"){
	// Make sure data is not empty
	if(strlen($_POST['data']) < 1){
		mysqli_close($conn_users);
	    echo "data_empty";
	    exit();
	}
	// Clean the posted variables
	$osid = preg_replace('#[^0-9]#', '', $_POST['pmid']);
	$account_name = $_POST['user'];
	$osender = $_POST['osender'];
	$data = htmlentities($_POST['data']);
	$data = mysqli_real_escape_string($conn_users, $data);
	// Make sure account name exists (the profile being posted on)
	$sql = "SELECT COUNT(id) FROM users WHERE username='$account_name' AND activated='1' LIMIT 1";
	$query = mysqli_query($conn_users, $sql);
	$row = mysqli_fetch_row($query);
	if($row[0] < 1){
		mysqli_close($conn_users);
		echo "account_no_exist";
		exit();
	}
	// Insert the pm reply post into the database now
	$x = "x";
	$sql = "INSERT INTO pm(receiver, sender, senttime, subject, message, parent)
	        VALUES('$x','$account_name',now(),'$x','$data','$osid')";
	$query = mysqli_query($conn_users, $sql);	
	$id = mysqli_insert_id($conn_users);
	
	if ($userName != $osender){
		$query2 = mysqli_query($conn_users, "UPDATE pm SET hasreplies='1', rread='1', sread='0' WHERE id='$osid' LIMIT 1");
	} else {
		$query2 = mysqli_query($conn_users, "UPDATE pm SET hasreplies='1', rread='0', sread='1' WHERE id='$osid' LIMIT 1");
	}
	mysqli_close($conn_users);
	echo "reply_ok|$id";
	exit();
}
?><?php
// Delete PM
if (isset($_POST['action']) && $_POST['action'] == "delete_pm"){
	if(!isset($_POST['pmid']) || $_POST['pmid'] == ""){
		mysqli_close($conn_users);
		echo "id_missing";
		exit();
	}
	$userName = $_POST['username'];
	$pmid = preg_replace('#[^0-9]#', '', $_POST['pmid']);
	if(!isset($_POST['originator']) || $_POST['originator'] == ""){
		mysqli_close($conn_users);
		echo "originator_missing";
		exit();
	}
	$originator = $_POST['originator'];
	// see who is deleting
	if ($originator == $userName) {
		$updatedelete = mysqli_query($conn_users, "UPDATE pm SET sdelete='1' WHERE id='$pmid' LIMIT 1");
		}
	if ($originator != $userName) {
		$updatedelete = mysqli_query($conn_users, "UPDATE pm SET rdelete='1' WHERE id='$pmid' LIMIT 1");
		}
	mysqli_close($conn_users);
	echo "delete_ok";
	exit();
}
?><?php
// Delete PM-note
if (isset($_POST['action']) && $_POST['action'] == "delete_pm_note"){
	if(!isset($_POST['pmid']) || $_POST['pmid'] == ""){
		mysqli_close($conn_users);
		echo "id_missing";
		exit();
	}
	$userName = $_POST['username'];
	$noteid = preg_replace('#[^0-9]#', '', $_POST['pmid']);

	$updatedelete = mysqli_query($conn_users, "UPDATE notifications SET `delete`='1' WHERE id='$noteid' LIMIT 1");

	mysqli_close($conn_users);
	echo "delete_ok_note";
	exit();
}
?><?php
// Mark As Read
if (isset($_POST['action']) && $_POST['action'] == "mark_as_read"){
	if(!isset($_POST['pmid']) || $_POST['pmid'] == ""){
		mysqli_close($conn_users);
		echo "id_missing";
		exit();
	}
	$userName = $_POST['username'];
	$pmid = preg_replace('#[^0-9]#', '', $_POST['pmid']);
	if(!isset($_POST['originator']) || $_POST['originator'] == ""){
		mysqli_close($conn_users);
		echo "originator_missing";
		exit();
	}
	$originator = $_POST['originator'];
	// see who is marking as read
	if ($originator == $userName) {
		$updatedelete = mysqli_query($conn_users, "UPDATE pm SET sread='1' WHERE id='$pmid' LIMIT 1");
		}
	if ($originator != $userName) {
		$updatedelete = mysqli_query($conn_users, "UPDATE pm SET rread='1' WHERE id='$pmid' LIMIT 1");
		}
	mysqli_close($conn_users);
	echo "read_ok_msg";
	exit();
}
?>
<?php
// Mark As Read - Notes
if (isset($_POST['action']) && $_POST['action'] == "mark_as_read_note"){

	$userName = $_POST['username'];

	$updatedelete = mysqli_query($conn_users, "UPDATE notifications SET did_read='1' WHERE username='$userName'");

	mysqli_close($conn_users);
	echo "read_ok_note";
	exit();
}
// Mark As Read - friends
if (isset($_POST['action']) && $_POST['action'] == "mark_as_read_friends"){

	$userName = $_POST['username'];

	$updatefriends = mysqli_query($conn_users, "UPDATE friends SET mark_read='1' WHERE user2='$userName'");

	mysqli_close($conn_users);
	echo "read_ok_friends";
	exit();
}
?>