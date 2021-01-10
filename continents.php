<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
 	$noBtnMobile = False; 
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Countries</title>
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?>	    
	</head>
	<body>
		<?php include_once("includes/php_includes/pageReturningSections/messages.php"); ?>		
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
						<li class="breadCrumsHighlight"><a href="continents.php">Continents</a></li>				
					</ul>				
				</nav>			
				<h1 class="pageHeader countinentsPgHdr">Continents</h1>	
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>
			    	<div class="mapGeneralSettings mapOpacity mapFixedHeight">
						<section class="searchSection">
							<?php include_once("includes/php_includes/searchBox/searchBox.php"); ?>													
						</section>
						<div class="northAmerica continentDiv"><a href="countries.php?continent=North America" class="northAmericaLink continentLinks">North America</a></div>
						<div class="southAmerica continentDiv"><a href="countries.php?continent=South America" class="southAmericaLink continentLinks">South America</a></div>
						<div class="africa continentDiv"><a href="countries.php?continent=Africa" class="africaLink continentLinks">Africa</a></div>
						<div class="asia continentDiv"><a href="countries.php?continent=Asia" class="asiaLink continentLinks">Asia</a></div>
						<div class="europe continentDiv"><a href="countries.php?continent=Europe" class="europeLink continentLinks">Europe</a></div>	
						<div class="australia continentDiv"><a href="countries.php?continent=Australia" class="australiaLink continentLinks">Australia</a></div>							    									    		
			    	</div>			    	
					<div class="clear"></div>			    	
			    </div>
			<div class="mobileBtnsCountinents">
				<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");}else{/*include_once("includes/php_includes/pageReturningSections/footer.php");*/} ?>
			</div>							    					        
			</main>

		</div>
	</body>
</html>