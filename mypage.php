<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
	include_once("includes/php_includes/myPage/myPagePhpIncludes.php"); 	
?>
<?php
	if($user_ok != true){
		header("location: notallowed.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $userName;?></title>
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?>	   		
	</head>
	<body>
		<div id="wrapper"> 	
			<header id="header">
				<?php include_once("includes/php_includes/pageReturningSections/header.php"); ?>		
			</header>		
			<nav id="navigator">
				<?php include_once("includes/php_includes/pageReturningSections/navigator.php"); ?>
			</nav>	
			<main>
				<nav class="breadCrums">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><img src="images/main/breadcrumsArrows.png" class="navArrows"></li>
						<li><a href="mypage.php?id=<?php echo $breadCrumsMyPage; ?>&u=<?php echo $userName; ?>.php"><?php echo $breadCrumsMyPageHeader; ?></a></li>
					</ul>
				</nav>
			    <h1 class="pageHeader <?php echo $breadCrumsMyPage; ?>"><?php echo $myPageheader; ?></h1>					
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>		
						<div id="myProfile" style="display:<?php echo $profile;?>">
							<?php include_once("includes/php_includes/myPage/profile.php"); ?>
						</div>
						<div id="myNotifications" style="display:<?php echo $notifications;?>">
							<?php include_once("includes/php_includes/myPage/notifications.php"); ?>
						</div>						
						<div id="myMessages" style="display:<?php echo $messages;?>">
							<?php include_once("includes/php_includes/myPage/mymessages.php"); ?>
						</div>
						<div id="myFriends" style="display:<?php echo $friends;?>">
							<?php include_once("includes/php_includes/myPage/friends.php"); ?>
						</div>
						<div id="searches" style="display:<?php echo $searches;?>">
							<?php include_once("includes/php_includes/myPage/mysearches.php"); ?>
						</div>						
						<div id="myLists" style="display:<?php echo $lists;?>">
							<?php include_once("includes/php_includes/myPage/mylists.php"); ?>
						</div>
				</div>
			</main>	
		</div>
	</body>
</html>