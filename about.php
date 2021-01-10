<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Contact Us</title>
			<script src="freecontactformvalidation.js"/>
			<link rel='shortcut icon' type='image/png' href='images/favicon.png'/>
			<link rel='stylesheet' href='includes/style/style.css'>
				<link rel="stylesheet" href="includes/select2/select2.css">
					<script>
	required.add('Full_Name','NOT_EMPTY','Full Name');
	required.add('Email_Address','EMAIL','Email Address');
	required.add('Your_Message','NOT_EMPTY','Your Message');
	required.add('AntiSpam','NOT_EMPTY','Anti-Spam Question');
					</script>
				</head>
				<body>
					<div id="wrapper">
						<header id="header">
							<a href="index.php"  id="logo"/>
							<!--Logo-->
							<article class="peoplePic"/>
							<div class="clear"/>				
						</header>
						<nav id="navigator">
							<article class="bigCircle"/>
							<article class="smallCircle"/>
							<article class="menuShape countriesNavLink">
								<a href="continents.php" class="menuButtons">Continents/Countries</a>
							</article>
							<article class="menuShape partnersNavLink">
								<a href="searches.php" class="menuButtons">Search Partners</a>
							</article>
							<article class="menuShape listsNavLink">
								<a href="lists.php" class="menuButtons">Lists</a>
							</article>
							<article class="menuShape activitiesNavLink">
								<a href="activities.php" class="menuButtons">Activities/Sights</a>
							</article>
							<div class="clear"/>	
						</nav>
						<main>
							<nav class="breadCrums">
								<ul>
									<li>
										<a href="index.php">Home</a>
									</li>
									<li>
										<img src="images/main/breadcrumsArrows.png" class="navArrows">
										</li>
										<li>
											<a href="signup.php">About</a>
										</li>
									</ul>
								</nav>
								<h1 class="pageHeader headerSignUp">About</h1>	
								<div class="content">		    	
									<div class="mapGeneralSettings mapOpacity mapFixedHeight">					
										<div class="aboutDesc">
											<p>This site was my final project for my information system degree. the site won as one of the best 10 projects.</p>
											<p>The idea behind this project is helping travelers finding partners for a shared whole trip or just some part of the trip</p>
											<p>You can also get informaition about the countries and what other travelars are recomending doing in thouse countries and best activities/sights</p>
											<div class="aboutFeatures">
												<h6>Features</h6>
												<div>
													<ul>
														<li>Search/Filter and Sort the DB</li>
														<li>Rating Data System</li>
														<li>Users System</li>
														<li>Ability to Send &amp; Recieve Messages Between Users</li>
														<li>Facebook API</li>
														<li>Email System</li>
													</ul>
												</div>
											</div>
											<div class="aboutTechnical">
												<h6>Technologies</h6>
												<div>
													<ul>
														<li>HTML 5</li>
														<li>Javascript</li>
														<li>Jquery</li>
														<li>CSS</li>
														<li>PHP</li>
														<li>MySQL</li>
													</ul>
												</div>
											</div>
										</div>
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