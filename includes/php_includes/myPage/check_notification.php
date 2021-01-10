<?php 
//check new Notification
if($user_ok == true) {
	//$sqlNotify = "SELECT notescheck FROM users WHERE username='$userName' LIMIT 1";
	//$queryNotify = mysqli_query($conn_users, $sqlNotify);
	//$row = mysqli_fetch_row($queryNotify);
	//$notescheck = $row[0];
	//$sqlNotify  = "SELECT id FROM notifications WHERE username='$userName' AND date_time > '$notescheck' LIMIT 1";
	$sqlNotify  = "SELECT id FROM notifications WHERE username='$userName' AND did_read='0' AND `delete`='0'";
	$queryNotify = mysqli_query($conn_users, $sqlNotify);
	$numrows = mysqli_num_rows($queryNotify);
    if ($numrows != 0) {
    	$note = $numrows;
		$noteNotes = 'block';	
	} 
	else {
		$note = 0;
		$noteNotes = 'none';
	}

}		

//check new Messegaes
	$sqlMessage = "SELECT id FROM pm WHERE
				   (receiver='$userName' AND parent='x' AND rdelete='0' AND rread='0')
				   OR
				   (SENDER='$userName' AND sdelete='0' AND parent='x' AND hasreplies='1' AND sread='0')";
	$queryMessage = mysqli_query($conn_users, $sqlMessage);
	$numrows = mysqli_num_rows($queryMessage);
    if ($numrows > 0) {
    		$message = $numrows;
    		$msgNotes = 'block';
	}else{
			$message = 0;
			$msgNotes = 'none';
	}
	
	
//check new Friends
	$sqlMessage = "SELECT id FROM friends WHERE user2='$userName' AND accepted='0' AND mark_read='0'";
	$sqlMessageC = "SELECT id FROM friends WHERE user2='$userName' AND accepted='0'";
	$queryMessage = mysqli_query($conn_users, $sqlMessage);
	$queryMessageC = mysqli_query($conn_users, $sqlMessageC);
	$numrows = mysqli_num_rows($queryMessage);
	$numrowsC = mysqli_num_rows($queryMessageC);
    if ($numrows > 0) {
    		$friendsNotes = $numrows;
			$newFriends = 'block';	
	}else{
			$friendsNotes = 0;
			$newFriends = 'none';
	}	
	
	

?>