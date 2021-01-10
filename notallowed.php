<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Not Allowed</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); 
			if($mobile){
				header("location: index.php");
			}
		?>	
	</head>
	<body>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=857434504293839";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>		
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
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>			    	
					<div class="mapGeneralSettings mapOpacity mapFixedHeight">					
						<section class="searchSection">
							<?php include_once("includes/php_includes/searchBox/searchBox.php"); ?>													
						</section>																		    	
			    		<p class="header404">This page is for Registrared users only - please login or registrar</p>
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