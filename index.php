<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
	$index = true;
	$noBtnMobile = True;
?>
<!DOCTYPE html>
<html>
	<head>		
		<title>TriPick</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php");?>
	</head>
	<body>
		<div id="wrapper">
			<?php include_once("includes/php_includes/pageReturningSections/messages.php"); ?>			
			<div style='display:none'><div id="actMsgAlert"><p><?php echo $actMsg ?></p></div></div>			 
			<header id="header">
				<?php include_once("includes/php_includes/pageReturningSections/header.php"); ?>						
			</header>		
			<nav id="navigator">
				<?php include_once("includes/php_includes/pageReturningSections/navigator.php"); ?>
			</nav>	
			<main>			
				<nav class="indexNav">
					<ul>
						<li>Choose the Country</li>
						<li><img src="images/main/arrows.png" class="navArrows"></li>
						<li>Pick a Partner</li>
						<li><img src="images/main/arrows.png" class="navArrows"></li>
						<li>Share your Trip</li>					
					</ul>				
				</nav>
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>		    						
					<div class="mapGeneralSettings mapColor mapFixedHeight">									
							<section class="searchSection">
								<?php include_once("includes/php_includes/searchBox/searchBox.php"); ?>													
							</section>
							<!--<span class="IndexPageactivityBtn"><a href="searchresults.php?query=noQuery">Search for Activity</a></span>	-->						
					</div>
					<div class="clear"></div>
				</div>
				<?php
				if ( ($mobile) && ($userMenuBeforeLogin != 'block') ){
					echo "<div class=\"mobileBtnsIndexAfterLogin\">";
					echo file_get_contents('includes/php_includes/pageReturningSections/mobilebtns.php');
					echo "</div>";																
				}elseif (!$mobile){
					include_once("includes/php_includes/pageReturningSections/footer.php"); 
				}else{
					echo '<div class="mobileBtnsIndexBeforeLogin">';
					echo '<div class="mapSmall mapSmallOpacity"></div>';
					echo '</div>';
				}	
				?>
							
			</main>
			<footer id="footer">
				
			</footer>			
		</div>	
	</body>
</html>	