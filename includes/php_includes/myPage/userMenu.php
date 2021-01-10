<?php
	include_once("includes/php_includes/myPage/check_notification.php");
	
	if($user_flag == "true"){
		$userMenuBeforeLogin = 'none';
		$userMenuAfterLogin = 'block';
	}else{
		$userMenuAfterLogin = 'none';
		$userMenuBeforeLogin = 'block';		
	}
?>
<?php
if($user_ok == true){
	$profile_pic = "";
	$profile_pic_btn = "";
	$avatar_form = "";
	$user = $userName;	
	$sql = "SELECT * FROM users WHERE username='$user' AND activated='1' LIMIT 1";
	$user_query = mysqli_query($conn_users, $sql);
	$row = mysqli_fetch_array($user_query, MYSQLI_ASSOC);
	$avatar = $row["avatar"];
	$gender = $row["gender"];
	$fbId = $row["fbId"];
	
	if($gender == "f"){
		$sex = "Female";
	}else{
		$sex = "Male";
	}
	if($avatar == ''){
		if ($fbId == 'Null'){
			if($sex == "Female"){
						$profile_pic = '<img src="images/avatardefaultFemale.png" alt="'. $user  .'">';
					}else{
						$profile_pic = '<img src="images/avatardefaultMale.png" alt="'. $user  .'">';
					}		
			}else{
				$profile_pic = '<img src="http://graph.facebook.com/' . $fbId . '/picture?type=large" alt="'. $user  .'">';
			}
	}else{
		$profile_pic = '<img src="users/'. $user  .'/'.$avatar.'" alt="'. $user  .'">';
	}
}
if($user_ok == true && $_GET['id'] != 'friends'){
	include_once("includes/php_includes/pageReturningSections/profilePic.php");
}
?>
<div id="userMenuBeforeLogin"  style="display:<?php echo $userMenuBeforeLogin;?>">
	<h2 class="userMenuHeader">User Menu</h2>
	<form id="userMenuBeforeLoginForm" onsubmit="return false;">
		<article>
			<label class='userMenuBeforeLoginFormLabelEmail'>Email Adress:</label><br>
				<input class='userMenuBeforeLoginFormInputEmail' type="text" id="email" onfocus="emptyElement('status')" maxlength="88">
			<label class='userMenuBeforeLoginFormLabelPass'>Password:</label><br>
				<input class='userMenuBeforeLoginFormInputPass' type="password" id="password" onfocus="emptyElement('status')" maxlength="100">
			 <input class='userMenuBeforeLoginFormLoginButton' type="button" id="loginbtn" value="Log In" onclick="login()">
			 <p id="status"></p>
			 <a href='forgotpassword.php'  onclick="popUpOpenIframe(350,200)"  class="userMenuforgotPassLink iframe" >(Forgot Your Password?)</a>					
		</article>
		<input class='userMenuBeforeLoginRegistrarButton' type="button" value="Registrar" onclick="javascript:location.href='signup.php'">
		<?php include_once("includes/Facebook_int/login.php"); ?>
	</form>
</div>
<div id="userMenuAfterLogin" style="display:<?php echo $userMenuAfterLogin;?>;">
	<div>
		<h2 class="userMenuHeader">User Menu</h2>
		<div class="alreadyLoginProfile">
			<h2 id="uName"><?php echo  $userName; ?></h2>
			<div id="profile_pic_box"><?php echo $profile_pic; ?></div>
		</div>
		<div class="alreadyLoginLinks">
			<article class='alreadyLoginLinksProfile'><img src="images/main/userMenu/profile.png"><a href="mypage.php?id=profile&u=<?php echo $userName ?>">Profile</a></article>
			<article class='alreadyLoginLinksMessages'><img src="images/main/userMenu/messege.png"><a href="mypage.php?id=messages&u=<?php echo $userName ?>">Messages</a></article>
			<article class='alreadyLoginLinksFriends'><img src="images/main/userMenu/friends.png"><a href="mypage.php?id=friends&u=<?php echo $userName ?>">Friends</a></article>
			<article class='alreadyLoginLinksSearches'><img src="images/main/userMenu/search.png"><a href="mypage.php?id=searches&u=<?php echo $userName ?>">Searches</a></article>
			<article class='alreadyLoginLinksLists'><img src="images/main/userMenu/lists.png"><a href="mypage.php?id=lists&u=<?php echo $userName ?>">Lists</a></article>
			<article class="logOutButton"><img src="images/main/userMenu/logout.png"><a href="includes/php_includes/login/logout.php">Log Out</a></article>
			<div class="newNotification" style="display:<?php echo $newFriends;?>"><p><?php if ($new_note != 0){echo $new_note;} ?></p></div>
			<div class="newNotificationFriend" style="display:<?php echo $newFriends;?>"><p><?php if ($friendsNotes != 0){echo $friendsNotes;} ?></p></div>
		</div>
		<div class="clear"></div>
	</div>
</div>