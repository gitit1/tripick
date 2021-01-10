<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
?>
<?php 
    //get data from DB	SELECT * FROM table WHERE NOT id = 4;
	$query = "SELECT * FROM users Where username != '" . $userName . "' ORDER BY username ASC";
    $result = mysqli_query($conn_users, $query);
    if(!$result) {
    	echo $query;
        die("DB query failed.");
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Partners</title>
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
						<li class="breadCrumsHighlight"><a href="partners.php">Partners</a></li>
					</ul>
				</nav>
			    <h1 class="pageHeader">Partners</h1>					
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>
			    	<div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">
						<div class="partnersPageBoxes">						
							<?php
								while($row = mysqli_fetch_assoc($result)){
									echo "<article class='partnersPagePartnerBox'>";
									echo "<a href='mypage.php?id=profile&u=" . $row["username"] . "'class='partnersPagepartnerLink' '>";
									//echo "<img src='images/countries/flags_small/" . $row["countryInitial"] . ".png' class='contriesPageCountryFlag' '>";
									echo "<h3>" . $row["username"] . "</h3></a>";
									//echo "<a href='partners.php?u=" . $row["username"] . "'>Send Message</a>";									
									echo "<a href='template_pm.php?u=" . $row["username"] . "&userName=$userName' onclick=\"popUpOpenIframe(500,400)\" class='iframe' >Send Message</a>";
									echo "</article>";
								}		
							?>															
						</div>							
					</div>																					    									    						    		
			    </div>						    	
				<div class="clear"></div>			    							        
			</main>	
			<!--
			<footer id="footer">
				<?php include_once("includes/php_includes/pageReturningSections/footer.php"); ?>	
			</footer>
			-->
		</div> <!--Wrapper-->
	</body>
</html>