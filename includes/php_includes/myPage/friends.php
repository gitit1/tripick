<div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">
	<div>

		  	<a id='myListsCreateNewListLink' href='#friendsSectionSeeReqBox' onclick="toggleElement('friendsSectionSeeReqBox'); markRead('Null','Null','<?php echo $userName; ?>','mark_as_read_friends');" >
				<img src="images/btn/friendsReq.png" alt="See Friends Requests" title="See Friends Requests"></a>
				<div class="newNotificationFriendSec"><p><?php echo $numrowsC; ?></p></div>

		  	<!--<h2 class="friendsSectionReqBoxHeader0">Friend Requests:</h2>
		  	<?php if($friend_requests == ''){echo "<h4 class='friendsSectionReqBoxHeader1'>You Dont have any new requests</h4>";
			}else{echo "<h4 class='friendsSectionReqBoxHeader2'>You Have <b>$numrows_friends</b> new requests</h4>";}?>	
		  	<a class='friendsSectionReqLink' href='#friendsSectionSeeReqBox' onclick="toggleElement('friendsSectionSeeReqBox'); markRead('Null','Null','<?php echo $userName; ?>','mark_as_read_friends');">
		  		<p>Click here to see your requests</p></a> -->
		  <div id="friendsSectionReqBox">
					<div id='friendsSectionSeeReqBox'>
						<span><?php echo $friend_requests; ?></span>
					</div>	  		
		  </div>
		  
		  <div id="friendsSectionMyFriendsBox">
		  	<!--<h2 class="friendsSectionMyFriendsBoxHeader0">My Friends:</h2>-->
		  	<h4 class='friendsSectionMyFriendsBoxHeader1'><span><?php echo $friend_count." friends"; ?></span></h4>
		  	<!--<div class="friendsSectionViewAll"><p> <?php echo $friends_view_all_link; ?></p></div>--> <!--!NOT IN USE!-->
		  	<!--<a class='friendsSectionMyFriendsLink' href='#friendsSectionSeeMyFriendsBox' onclick="toggleElement('friendsSectionSeeMyFriendsBox')">
		  		<p>Click here to see your friends list</p></a>-->
					<div id='friendsSectionSeeMyFriendsBox'>
						<?php if($friendsHTML != ''){
							echo "<span class='friendsSectionMyFriendsBox'>";
							echo $friendsHTML;
							echo "</span>";
						}
						?>
					</div>	  		
		  </div>
		  <div style="clear:left;"></div>		  		  
	</div>
</div>
<div class="mobileBtnsFriends">
<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");} ?>
</div>
<div class="clear"></div>