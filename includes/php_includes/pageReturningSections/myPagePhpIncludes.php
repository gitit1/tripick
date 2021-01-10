<?php
if ($_GET['id'] == "profile"){
	$profile = 'block';
	$notifications = 'none';
	$messages = 'none';
	$friends = 'none';
	$searches = 'none'; 
	$lists = 'none';
	$notifications = 'none';
	$myPageheader = '';
	$breadCrumsMyPage = "profile";
	$breadCrumsMyPageHeader = "Profile";
	// Initialize any variables that the page might echo
	$u = "";
	$sex = "";
	$userlevel = "";
	$profile_pic1 = "";
	$profile_pic_btn = "";
	$avatar_form = "";
	$country = "";
	$joindate = "";
	$lastsession = "";
	// Make sure the _GET username is set, and sanitize it
	if(isset($_GET["u"])){
		$u = $_GET['u'];
	} else {
	    header("location: http://www.tripick.net/index.php?actMsg='error'");
	    exit();	
	}
	// Select the member from the users table
	$sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
	$user_query = mysqli_query($conn_users, $sql);
	// Now make sure that user exists in the table
	$numrows = mysqli_num_rows($user_query);
	if($numrows < 1){
		echo "That user does not exist or is not yet activated, press back";
	    exit();	
	}
	// Check to see if the viewer is the account owner
	$isOwner = "no";
	if($u == $userName && $user_ok == true && $_GET['id'] != 'friends'){
		$isOwner = "yes";
		$friendBtn = "none";
	}else{
		$friendBtn = "block";
	}
	// Fetch the user row from the query above
	while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
		$profile_id = $row["id"];
		$genderProfile = $row["gender"];
		$country = $row["country"];
		$userlevel = $row["userlevel"];
		$avatar_profile = $row["avatar"];
		$about = $row["about"];
		$birthday = $row["birthday"];
		$email = $row["email"];
		$firstname = $row["firstname"];
		$lastname = $row["lastname"];
		$fbProfile  = $row["fbId"];
		if($genderProfile == "f"){
			$sexProfile = "Female";
		}else{
			$sexProfile  = "Male";
		}
		
		if ($avatar_profile == ""){
			if ($fbProfile == 'Null'){
				if($genderProfile== "f")
					{
						$profile_pic1 = '<img src="images/avatardefaultFemale.png" alt="'.$u1.'">';
					}else{
						$profile_pic1 = '<img src="images/avatardefaultMale.png" alt="'.$u1.'">';
					}		
				}else{
					$profile_pic1  = "<a href=\"http://graph.facebook.com/$fbProfile/picture?type=normal\" class='group1'><img src=\"http://graph.facebook.com/$fbProfile/picture?type=normal\" alt=\"'.$u1.'\"></a>";
				}
		}else{
			$profile_pic1 = '<img src="users/'.$u.'/'.$avatar_profile.'" alt="'.$u.'">';
		}
	}

	$isFriend = false;
	$ownerBlockViewer = false;
	$viewerBlockOwner = false;
	if($u != $userName && $user_ok == true){
		$friend_check = "SELECT id FROM friends WHERE user1='$userName' AND user2='$u' AND accepted='1' OR user1='$u' AND user2='$userName' AND accepted='1' LIMIT 1";
		if(mysqli_num_rows(mysqli_query($conn_users, $friend_check)) > 0){
	        $isFriend = true;
	    }
		$block_check1 = "SELECT id FROM blockedusers WHERE blocker='$u' AND blockee='$userName' LIMIT 1";
		if(mysqli_num_rows(mysqli_query($conn_users, $block_check1)) > 0){
	        $ownerBlockViewer = true;
	    }
		$block_check2 = "SELECT id FROM blockedusers WHERE blocker='$userName' AND blockee='$u' LIMIT 1";
		if(mysqli_num_rows(mysqli_query($conn_users, $block_check2)) > 0){
	        $viewerBlockOwner = true;
	    }
	}

	$friend_button = '<button disabled>Request As Friend</button>';
	$block_button = '<button disabled>Block User</button>';
	// LOGIC FOR FRIEND BUTTON
	if($isFriend == true){
		$friend_button = '<button onclick="friendToggle(\'unfriend\',\''.$u.'\',\'friendBtn\',\''.$userName.'\')" class="generalBtn btnImgUnfriend">
							<img src="images/btn/unfriend.png" alt="Unfriend" title="Unfriend"/>
						  </button>';
	}else if($user_ok == true && $u != $userName && $ownerBlockViewer == false){
		$friend_button = '<button onclick="friendToggle(\'friend\',\''.$u.'\',\'friendBtn\',\''.$userName.'\')"  class="generalBtn btnImgAddfriend">
						  	<img src="images/btn/addFriend.png" alt="Request As Friend" title="Request As Friend"/>
						  </button>';
	}
	// LOGIC FOR BLOCK BUTTON
	if($viewerBlockOwner == true){
		$block_button = '<button onclick="blockToggle(\'unblock\',\''.$u.'\',\'blockBtn\',\''.$userName.'\')"  class="generalBtn btnImgUnblockUser">
						 	<img src="images/btn/unblockUser.png" alt="Unblock User" title="Unblock User"/>
						 </button>';
	} else if($user_ok == true && $u != $userName){
		$block_button = '<button onclick="blockToggle(\'block\',\''.$u.'\',\'blockBtn\',\''.$userName.'\')"  class="generalBtn btnImgBlockUser">
						 	<img src="images/btn/blockUser.png" alt="Block User" title="Block User"/>
						 </button>';
	}
	

}
?>	
<?php//*************************************************************************************************************//?>		
<?php
if ($_GET['id'] == "notifications"){
	$profile = 'none';
	$notifications = 'block';
	$messages = 'none';
	$friends = 'none';
	$searches = 'none'; 	
	$lists = 'none';
	$myPageheader = 'Notifications';
	$breadCrumsMyPage = 'messages';
	$breadCrumsMyPageHeader = "Notifications";
	// If the page requestor is not logged in, usher them away
	if($user_ok != true || $userName == ""){
		header("location: http://www.tripick.net?actMsg='error'");
	    exit();
	}
	 
	$notification_list = "";
	$sql = "SELECT * FROM notifications WHERE username = '$userName' AND `delete`='0' ORDER BY date_time DESC";
	$query = mysqli_query($conn_users, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows > 1){
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$noteid = $row["id"];
			$wrap_note = 'note_wrap_'.$noteid;
			$initiator = $row["initiator"];
			$app = $row["app"];
			$note = $row["note"];
			$date_time= date_format(new DateTime($row["date_time"]), 'd/m/Y H:i:s');
			$avatar_note = $row["avatar"];
			$fbNote = $row["fbId"];
			$gender_note = $row["gender"]; 
			if ($avatar_note == ""){
				if ($fbNote == 'Null'){
					if($gender_note == "f")
						{
							$img_src = 'images/avatardefaultFemale.png';
						}else{
							$img_src = 'images/avatardefaultMale.png';
						}		
					}else{
						$img_src = "http://graph.facebook.com/' . $fbNote . '/picture?type=normal";
					}
			}else{
				$img_src = "users/$initiator/$avatar_note";
			}					

				$notification_list .= "<div id='$wrap_note' class='notificatioSectionOneNoteBox'><img src='$img_src' class='notificatioSectionOneNoteBoxImg'><label class='notificatioSectionNoteLabelInit'>Initiator:</label><a href='mypage.php?id=profile&u=$initiator'>$initiator</a>";										
				$notification_list .= "<br><label class='notificatioSectionNoteLabelTo'>To: <span>$app</span></label>";
				$notification_list .= "<br><label class='notificatioSectionNoteLabelContent'>Content: </label><span class='notificatioSectionNoteLabelContentSpan'>$note</span>";
				//$notification_list .= '<button class="notificatioSectionNoteMarkAsReadBtn" onclick="markRead(\''.$noteid.'\',\'Null\',\''.$userName.'\',\'mark_as_read_note\')">Mark As Read</button>';		
				$notification_list .= '<button class="notificatioSectionNoteDeleteMsgBtn generalBtn" onclick="deletePm(\''.$noteid.'\',\''.$wrap_note.'\',\'Null\',\''.$userName.'\',\''.$userName.'\',\'delete_pm_note\')">
									   <img src="images/btn/delete.png" alt="Delete" title="Delete" class="btnImgDelete"/></button>';				
				$notification_list .= '</div>';
			}
	}
		//$mail .= '<button class="notificatioSectionMsgDeleteMsgBtn" id="'.$btid2.'" onclick="deletePm(\''.$pmid.'\',\''.$wrap.'\',\''.$wrap2.'\',\''.$sender.'\',\''.$userName.'\')">Delete</button></div>';



	mysqli_query($conn_users, "UPDATE users SET notescheck=now() WHERE username='$userName' LIMIT 1");	
}
?>
<?php//*************************************************************************************************************//?>	
<?php	
if ($_GET['id'] == "messages"){
	$profile = 'none';
	$notifications = 'none';
	$messages = 'block';
	$friends = 'none';
	$searches = 'none'; 	
	$lists = 'none';
	$myPageheader = 'Messages';
	$breadCrumsMyPage = 'messages';
	$breadCrumsMyPageHeader = "Messages";
	// If the page requestor is not logged in, usher them away
	if($user_ok != true || $userName == ""){
		header("location: http://www.tripick.net?actMsg='error'");
	    exit();
	}
	
	include_once("includes/php_includes/myPage/pm_inbox.php"); 
}	
?>
<?php//*************************************************************************************************************//?>
<?php		
if ($_GET['id'] == "friends"){
		$profile = 'none';
		$notifications = 'none';
		$messages = 'none';
		$friends = 'block';
		$searches = 'none'; 		
		$lists = 'none';		
		$myPageheader = 'My Friends';
		$breadCrumsMyPage = "friends";
		$breadCrumsMyPageHeader = "My Frineds";
		
	 if ($_GET['id'] != 'friends'){
	 	$friendBtn = "none";
	}else{
		$friendBtn = "block";
	}
	$u = $_GET['u'];
	$friend_requests = "";
	$sql = "SELECT * FROM friends WHERE user2='$u' AND accepted='0' ORDER BY datemade ASC";
	$query = mysqli_query($conn_users, $sql);
	$numrows_friends = mysqli_num_rows($query);
	if($numrows_friends < 1){
		$friend_requests = '';
	} else {
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$reqID = $row["id"];
			$user1 = $row["user1"];
			$datemade = date_format(new DateTime($row["datemade"]), 'd/m/Y H:i:s');			
			$thumbquery = mysqli_query($conn_users, "SELECT * FROM users WHERE username='$user1' LIMIT 1");
			$thumbrow = mysqli_fetch_array($thumbquery);
			$user1avatar = $thumbrow["avatar"];
			$user1gender = $thumbrow["gender"];
			$user1fbId = $thumbrow["fbId"];
	
			if($thumbrow["avatar"] == ""){
				if ($thumbrow["fbId"] == 'Null'){				
					if($thumbrow["gender"] == "f"){				
						$user1pic = "<img src='images/avatardefaultFemale.png' alt='$user1'  class='user_pic friendReqAvatar'>";
					}else{
						$user1pic  = "<img src='images/avatardefaultMale.png' alt='$user1' class='user_pic friendReqAvatar'>";
					}
				}else{
					$user1pic = "<img src='http://graph.facebook.com/$user1fbId/picture?type=normal' alt='$user1'  class='user_pic friendReqAvatar'>";
				}
			}else{
				$user1pic = "<img src='users/$user1/$user1avatar' alt='$user1' class='user_pic friendReqAvatar'>";
			}			
			
			
			
			
			$friend_requests .= '<div id="friendreq_'.$reqID.'" class="friendrequests">';
			$friend_requests .= '<div>'.$user1pic.'</div>';
			$friend_requests .= '<div class="user_info friendReqBoxDiv" id="user_info_'.$reqID.'">
								 <label class="friendReqBoxDateLabel">Recieved At:</label>
								 <span class="friendReqBoxDateSpan">'.$datemade.'</span> 
								 <label class="friendReqBoxFromLabel">From:</label><span class="friendReqBoxFromDate">
								 <a href="mypage.php?id=profile.php?u='.$user1.'">'.$user1.'</a></span>';
			$friend_requests .= '<a  class="friendReqBoxAcpBtn" onclick="friendReqHandler(\'accept\',\''.$reqID.'\',\''.$user1.'\',\'user_info_'.$reqID.'\',\''.$userName.'\')">
									<img src="images/btn/acceptFriend.png" alt="Accept Friendship" title="Accept Friendship" class="generalBtn btnImgAccept" /></a>';
			$friend_requests .= '<a  class="friendReqBoxRgtBtn"  onclick="friendReqHandler(\'reject\',\''.$reqID.'\',\''.$user1.'\',\'user_info_'.$reqID.'\',\''.$userName.'\')">
									<img src="images/btn/rejectFriend.png" alt="Reject Friendship" title="Reject Friendship" class="generalBtn btnImgReject" /></a>';
			$friend_requests .= '</div>';
			$friend_requests .= '</div>';
		}
	}

	$friendsHTML = '';
	$friends_view_all_link = '';
	$sql = "SELECT COUNT(id) FROM friends WHERE user1='$u' AND accepted='1' OR user2='$u' AND accepted='1'";
	$query = mysqli_query($conn_users, $sql);
	$query_count = mysqli_fetch_row($query);
	$friend_count = $query_count[0];
	if($friend_count < 1){
		$friendsHTML = "";
	} else {
		$max = 30;
		$all_friends = array();
		$sql = "SELECT user1 FROM friends WHERE user2='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
		$query = mysqli_query($conn_users, $sql);
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			array_push($all_friends, $row["user1"]);
		}
		$sql = "SELECT user2 FROM friends WHERE user1='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
		$query = mysqli_query($conn_users, $sql);
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			array_push($all_friends, $row["user2"]);
		}
		$friendArrayCount = count($all_friends);
		if($friendArrayCount > $max){
			array_splice($all_friends, $max);
		}
		if($friend_count > $max){
			$friends_view_all_link = '<a href="view_friends.php?u='.$u.'">view all</a>';
		}
		$orLogic = '';
		foreach($all_friends as $key => $user){
				$orLogic .= "username='$user' OR ";
		}
		$orLogic = chop($orLogic, "OR ");
		$sql = "SELECT * FROM users WHERE $orLogic";
		$query = mysqli_query($conn_users, $sql);
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$friend_username = $row["username"];
			$friend_avatar = $row["avatar"];
			$friend_fbId =  $row["fbId"];
			$friend_gender = $row["gender"];
			
			if($friend_avatar == ""){
				if ($friend_fbId == 'Null'){				
					if($friend_gender == "f"){				
						$friend_pic = 'images/avatardefaultFemale.png';
					}else{
						$friend_pic  = 'images/avatardefaultMale.png';
					}
				}else{
					$friend_pic = "http://graph.facebook.com/$friend_fbId/picture?type=normal";
				}
			}else{
				$friend_pic = "users/$friend_username/$friend_avatar";
			}
		
			
			$friendsHTML .= '<a href="mypage.php?id=profile&u='.$friend_username.'"><img class="mypageFriendsSectionAvatar" src="'.$friend_pic.'" alt="'.$friend_username.'" title="'.$friend_username.'"></a>';
		}
		$orLogic = '';
		foreach($all_friends as $key => $user){
				$orLogic .= "username='$user' OR ";
		}
		$orLogic = chop($orLogic, "OR ");
		$sql = "SELECT username, avatar FROM users WHERE $orLogic";
		$query = mysqli_query($conn_users, $sql);
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$friend_username = $row["username"];
			$friend_avatar = $row["avatar"];
			if($friend_avatar != ""){
				$friend_pic = 'users/'.$friend_username.'/'.$friend_avatar.'';
			} else {
				$friend_pic = 'images/avatardefault.jpg';
			}
		}
	}

}
?>
<?php//*************************************************************************************************************//?>
<?php
if ($_GET['id'] == "lists"){
		$profile = 'none';
		$notifications = 'none';
		$messages = 'none';
		$friends = 'none';
		$searches = 'none';		
		$lists = 'block';
		$myPageheader = 'My Lists';
		$breadCrumsMyPage = "lists";
		$breadCrumsMyPageHeader = "Lists";		
	}
?>
<?php//*************************************************************************************************************//?>
<?php
if ($_GET['id'] == "searches"){
		$profile = 'none';
		$notifications = 'none';		
		$messages = 'none';
		$friends = 'none';
		$searches = 'block';
		$lists = 'none';
		$myPageheader = 'My Searches';
		$breadCrumsMyPage = "searches";
		$breadCrumsMyPageHeader = "Searches";	
	}
?>