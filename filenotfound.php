<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>404 - File Not Found</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); 
			if($mobile){
				header("location: index.php");
			}
		?>	
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
				<nav class="indexNav"></nav>		
			    <div class="content">
			    	<div class="userMenu" style="visibility:hidden"></div>			    	
					<div class="mapGeneralSettings mapOpacity mapFixedHeight">																							    	
			    		<p class="header404">404 - Page Not Found<br><a href="index.php">Return to Index</a></p><br>
			    	</div>
				</div>				
			</main>
			<!--
			<footer>
				<?php include_once("includes/php_includes/pageReturningSections/footer.php"); ?>			
			</footer>
			-->
		</div>	
	</body>
</html>	