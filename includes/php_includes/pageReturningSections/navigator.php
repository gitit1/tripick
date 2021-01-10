<?php if (!$mobile){
echo '<article class="bigCircle"></article>';
echo '<article class="smallCircle"></article>';
echo '<article class="menuShape countriesNavLink"><a href="continents.php" class="menuButtons">Continents/Countries</a></article>';
echo '<article class="menuShape partnersNavLink"><a href="searches.php" class="menuButtons">Search Partners</a></article>';
echo '<article class="menuShape listsNavLink"><a href="lists.php" class="menuButtons">Lists</a></article>';
echo '<article class="menuShape activitiesNavLink"><a href="activities.php" class="menuButtons">Activities/Sights</a></article>';
echo '<div class="clear"></div>';
}elseif ( ($mobile) && ($userMenuBeforeLogin != 'block') && ($noBtnMobile != True) ){
	include_once("includes/php_includes/myPage/check_notification.php");
	if ($note != 0){$noteMbl = $note;};
	if ($message != 0){$msgMbl = $message;};
	if ($friendsNotes != 0){$frdMbl = $friendsNotes;};
	echo "<nav class='hamNav'>";
	  echo "<button onclick='toggleElement(\"showHamNav\")';></button>";
	  echo "<div id=\"showHamNav\">";
	    echo "<img class='hamNavProfileImg' src='images/main/userMenu/profile.png'>
	    		<a href=\"mypage.php?id=profile&u=$userName\" onclick=\"markRead('Null','Null','$userName','mark_as_read_note');\">
	    		Profile</a>";
	    echo "<img class='hamNavNoteImg' src=\"images/main/userMenu/notification.png\">
    			<a href=\"mypage.php?id=notifications&u=$userName\">Notifications</a>";
		echo "<div class=\"newNotificationMbl\" style=\"display:$noteNotes\"><p>$noteMbl</p></div>";				
	    echo "<img class='hamNavMsgImg' src=\"images/main/userMenu/messege.png\">
	    		<a href=\"mypage.php?id=messages&u=$userName\">Messages</a>";
		echo "<div class=\"newNotificationMsgMbl\" style=\"display:$msgNotes\"><p>$msgMbl</p></div>";				
	    echo "<img class='hamNavFrdImg' src=\"images/main/userMenu/friends.png\">
	    		<a href=\"mypage.php?id=friends&u=$userName\">Friends</a>";
		echo "<div class=\"newNotificationFriendMbl\" style=\"display:$newFriends\"><p>$frdMbl</p></div>";		
	  	echo "<img class='hamNavSrcImg' src=\"images/main/userMenu/search.png\">
	  			<a href=\"mypage.php?id=searches&u=$userName\">Searches</a>";
	  	//echo "<img class='hamNavLstImg' src=\"images/main/userMenu/lists.png\">
	  	//		<a href=\"mypage.php?id=lists&u=$userName\">Lists</a>";
		echo "<img class='hamNavLogOutImg' src=\"images/main/userMenu/logout.png\">
				<a href=\"includes/php_includes/login/logout.php\">Log Out</a>";
	  echo '</div>';
	echo '</nav>';
}
?>
