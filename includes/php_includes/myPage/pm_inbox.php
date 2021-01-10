<?php
// Initialize any variables that the page might echo
$u = "";
$mail = "";
// Make sure the _GET username is set, and sanitize it

if(isset($_GET["u"])){
	$u = $_GET['u'];
} else {
    header("location: index.php");
    exit();	
}

 
$page = $_GET["id"];
 if ($page)
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
if($u == $userName && $user_ok == true){$isOwner = "yes";}
if($isOwner != "yes"){header("location: index.php");exit();}
// Get list of parent pm's not deleted
$sql = "SELECT * FROM pm WHERE 
(receiver='$u' AND parent='x' AND rdelete='0') 
OR 
(sender='$u' AND sdelete='0' AND parent='x' AND hasreplies='1') 
ORDER BY senttime DESC";
$query = mysqli_query($conn_users, $sql);
$statusnumrows = mysqli_num_rows($query);
// Gather data about parent pm's
if($statusnumrows > 0){
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$pmid = $row["id"];
		//div naming
		$pmid2 = 'pm_'.$pmid;
		$wrap = 'pm_wrap_'.$pmid;
		$wrap2 = 'pm_wrap2_'.$pmid;;
		//button naming
		$btid2 = 'bt_'.$pmid;
		//textarea naming
		$rt = 'replytext_'.$pmid;
		//button naming
		$rb = 'replyBtn_'.$pmid;
		$receiver = $row["receiver"];
		$sender = $row["sender"];
		$subject = $row["subject"];
		$message = $row["message"];
		$time = date_format(new DateTime($row["senttime"]), 'd/m/Y H:i:s');
		$rread = $row["rread"];
		$sread = $row["sread"];
		$avatar_pm = $row["avatar"];
		$fbPm = $row["fbId"]; 
		if ($avatar_pm == ""){
			if ($fbPm != 'Null')
			{
				$img_src_pm = "http://graph.facebook.com/$fbPm/picture?type=normal";
			}elseif ($row["gender"] == 'f')
				{
					$img_src_pm  = 'images/avatardefaultFemale.png';							
				}else{
					$img_src_pm  = 'images/avatardefaultMale.png';
				}			
		}elseif($sender == $userName){
			if($fbPm != 'Null'){
				$img_src_pm = "http://graph.facebook.com/$fbPm/picture?type=normal";
			}else{
				$img_src_pm = "users/$receiver/$avatar_pm";
			}			  
		}else{
			if($fbPm != 'Null'){
				$img_src_pm = "http://graph.facebook.com/$fbPm/picture?type=normal";
			}else{
				$img_src_pm = "users/$sender/$avatar_pm";
			}						  
		}

		// Start to build our list of parent pm's
		$mail .= '<div id="'.$wrap.'" class="pm_wrap">';
		$mail .= '<div class="pm_header"><label>Subject:</label><span>'.$subject.'</span><br /><br />';
		// Add button for mark as read
		$mail .= '<button class="notificatioSectionMsgMarkAsReadBtn" onclick="markRead(\''.$pmid.'\',\''.$sender.'\',\''.$userName.'\',\'mark_as_read\')" class="generalBtn btnImgMarkAsRead">
				  	<img src="images/btn/markAsRead.png" alt="Mark As Read" title="Mark As Read"/></button>';
		// Add Delete button
		$mail .= '<button class="notificatioSectionMsgDeleteMsgBtn" id="'.$btid2.'" onclick="deletePm(\''.$pmid.'\',\''.$wrap.'\',\''.$wrap2.'\',\''.$sender.'\',\''.$userName.'\',\'delete_pm\')"  class="generalBtn btnImgDelete">
					<img src="images/btn/delete.png" alt="Delete" title="Delete"/></button></div>';
		$mail .= '<div id="'.$pmid2.'">';//start expanding area
		$mail .= '<div class="pm_post">
				  <label class="notificatioSectionMsgFromLabel">From: </label>
				  <span class="notificatioSectionMsgFromSpan">'.$sender.'</span><br />
				  <label class="notificatioSectionMsgTimeLabel">Recieved at:</label>
				  <span class="notificatioSectionMsgTimeSpan"> '.$time.'</span><br />
				  <label class="notificatioSectionMsgMsgLabel">Message:</label>
				  <span class="notificatioSectionMsgMsgSpan">'.$message.'<span></div>';
		$mail .= '<div class="notificatioSectionMsgImg"><img src='.$img_src_pm.'></div>';
		
		// Gather up any replies to the parent pm's
		$pm_replies = "";
		$query_replies = mysqli_query($conn_users, "SELECT sender, message, senttime FROM pm WHERE parent='$pmid' ORDER BY senttime ASC");
		$replynumrows = mysqli_num_rows($query_replies);
    	if($replynumrows > 0){
			while ($row2 = mysqli_fetch_array($query_replies, MYSQLI_ASSOC)) {
				$rsender = $row2["sender"];
				$reply = $row2["message"];
				$time2 = date_format(new DateTime($row2["senttime"]), 'd/m/Y H:i:s');
				$mail .= '<div class ="pm_post pm_post2"><label class="notificatioSectionMsgReplyLabel">Reply From:</label>
						  <span class="notificatioSectionMsgReplySpan"> '.$rsender.'</span>
						  <label class="notificatioSectionMsgReplyTimeLabel">Recieved at:</label>
						  <span class="notificatioSectionMsgReplyTimeSpan"> '.$time2.'</span>
						  <label class="notificatioSectionMsgReplyMsgLabel">Message:</label>
						  <span class="notificatioSectionMsgReplyMsgSpan">'.$reply.'</span></div>';
			}
		}
		// Each parent and child is now listed
		$mail .= '</div>';
		// Add reply textbox
		$mail .= '</div>';
		$mail .= '<div  id="'.$wrap2.'" class="pm_wrap1">
					<div id="notificatioSectionTextAreaBox">
						<button class="notificatioSectionTextAreaBtn" id="'.$rb.'" onclick="replyToPm('.$pmid.',\''.$u.'\',\''.$rt.'\',\''.$rb.'\',\''.$sender.'\')">Reply</button>									
						<textarea class="notificatioSectionTextArea" id="'.$rt.'" placeholder="Reply..." onclick="this.value=\'\'"></textarea><br />';
		$mail .= '<div style="clear:left;"></div>';
		$mail .= '</div></div>';
	}
}
?>
