<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
	$noBtnMobile = False; 
?>
<?php	
	$continent = $_GET['continent'];
	$country = $_GET['country'];	
    //get data from DB	
    $queryCountry = "SELECT * FROM countriesTable Where countryName = '" . $country . "'";
	
    $resultCountry = mysqli_query($conn_countries, $queryCountry);
    if(!$resultCountry) {
        die("DB query failed.");
    }
  /*  if(!$resultCity) {
        die("DB query failed.");
    }
	*/
	while($row = mysqli_fetch_assoc($resultCountry)){
		$flag = $row["countryInitial"];
		$summary = $row["countrySummary"];
		$details = $row["countryDeatails"];
		$pic =  $row["countryInitial"];
		$map = 	$row["googleMapLink"];	
	}
	$queryCity = "SELECT * FROM citiesTable Where countryInitial = '" . $flag . "' ORDER BY cityName ASC";
	$resultCity = mysqli_query($conn_countries, $queryCity);		                         	
?>	
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $country; ?></title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?> 
		<script type='text/javascript' src='includes/js/countryScript.js'></script>
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
						<li><a href="continents.php">Continent</a></li>
						<li><img src="images/main/breadcrumsArrows.png" class="navArrows"></li>
						<li><a href="countries.php?continent=<?php echo $continent; ?>"><?php echo $continent; ?></a></li>
						<li><img src="images/main/breadcrumsArrows.png" class="navArrows"></li>
						<li class="breadCrumsHighlight"><a href="javascript:window.location.href=window.location.href"><?php echo $country; ?></a></li>		
					</ul>				
				</nav>	
				<h1 class="pageHeader countryPageHdr"><?php echo $country; ?></h1>
			    <div class="content" id="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>
			    	<div class="mapGeneralSettings mapOpacity mapAutoHeight mapWithoutBorder">
							<section class="searchSection searchSection_mobile searchSection_mobile_coutryPage">
								<?php include_once("includes/php_includes/searchBox/searchBox.php"); ?>					
							</section>
						<div class='countryPageCountryBox'> 
							<div class='countryFirstInfo'> <!--countryFirstInfo-->
								<div>								
									<?php
										echo "<span class='countryPageCountryFlag'><img src='images/country/flags_big/" . $flag . ".png'></span>";
										if (!$mobile){
										echo "<span class='countryPageCountrySummary'><p>" . $summary . 
										"<a href='#' id='countryPageCountryReadMoreLink'>   Learn More...</a></p></span>";
										}
									?>
								</div>									
								<div id="countryPageReadMore"> <!--countryPageReadMore-->
									<?php
										echo "<span class='countryPageCountryDetails'><p>" . $details . 
										"<a href='#' id='countryPageCountryReadLessLink'>   Close.</a></p></span>";
									?>
									

									<div class="countryPageReadMoreButtons">
										<a href="#inline_content_cities" class='inline'>Cities</a>
										<a href="<?php echo $map; ?>" class='iframe'>Find On Map</a>																		
										<section class="countryPageLightBoxCitiesLink">											
												<div style='display:none'>									
														<div class="countryPageLightBoxCitiesDivWrapper" id='inline_content_cities'>
															<div class="countryPageLightBoxCitiesDivL">															
																<?php
																	$rows = array();
																	echo "<ul>";														
																    while ($row1 = mysqli_fetch_assoc($resultCity)){
																    	$rows[] = $row1;
																		$cityName = preg_replace('#[^a-z ]#i', '', $row1['cityName']);
																        echo "<li><a href='#' value='cityId" . $row1['ID'] . "' class='getCityId' onclick=\"document.getElementById('countryPageLightBoxCitiesDivHeader').style.display='none'\">$cityName</a></li>";																		
															    	}
																?>
															</div>
															<div class="countryPageLightBoxCitiesDivR">
																<?php
																foreach($rows as $row2){
																	$cityName = preg_replace('#[^a-z ]#i', '', $row2['cityName']);
																	$cityDtl = $row2['cityDetails'];
																	$cityId = $row2['ID'];
																	$cityIn = $row2['countryInitial'];
														    		echo "<div id='cityId$cityId' class='countryPagecityBoxDisable'>";
														    		echo "<span><h1>$cityName</h1></span>";
														    		echo "<span><p>$cityDtl</p></span>";
														    		if ($row2['pic'] != ""){
														    		echo "<span><img src='images/country/citiesPics/" . $row2['countryInitial'] . "_" . $row2['pic']  .    "_1.png' class='citiesImages'></span>";
														    		echo "<span><img src='images/country/citiesPics/" . $row2['countryInitial'] . "_" . $row2['pic']  .    "_2.png' class='citiesImages'></span>";
														    		echo "<span><img src='images/country/citiesPics/" . $row2['countryInitial'] . "_" . $row2['pic']  .    "_3.png' class='citiesImages'></span>";
														    		}
														    		echo "</div>";
																}														
																?>
																<p id="countryPageLightBoxCitiesDivHeader">Choose a City From the list</p>
																<div class="clear"></div>	
															</div>																													
														</div>		                   															
													</div>																					
										</section>																																							
									</div>	<!--/countryPageReadMoreButtons-->
										<article class='countryPageCountryThumbPics'>
										<?php								
												echo "<span><a href='images/country/countryPics/" . $pic . "_1.jpg' class='group1 highslide'><img src='images/country/countryPics/" . $pic . "_1_thumb.png' title='Click to enlarge'></a></span>";
												echo "<span><a href='images/country/countryPics/" . $pic . "_2.jpg' class='group1 highslide'><img src='images/country/countryPics/" . $pic . "_2_thumb.png' title='Click to enlarge'></a></span>";	
												echo "<span><a href='images/country/countryPics/" . $pic . "_3.jpg' class='group1 highslide'><img src='images/country/countryPics/" . $pic . "_3_thumb.png' title='Click to enlarge'></a></span>";									
										?>
										</article>																
								</div> <!--/countryPageReadMore-->
							</div> 	<!--/countryFirstInfo-->
							<div class="countryPageButtons">
									<input type="button" value="Activity" class="countryPageButton" id="countryPageButtonsFirst" onclick="window.location.href='searchactivity.php?cnt=<?php echo $continent; ?>&cty=<?php echo $country; ?>'"/>
									<label class="countryPageButtonLabal">Search a partner for an Activity</label>
									<input type="button" value="Build a Trip" class="countryPageButton" id="countryPageButtonsSecond" onclick="window.location.href='searchbuild.php?cnt=<?php echo $continent; ?>&cty=<?php echo $country; ?>'"/>
									<label class="countryPageButtonLabal">Search a partner to build a trip</label>
									<input type="button" value="Lists" class="countryPageButton" id="countryPageButtonsThird" 
									onclick="window.location.href='lists.php?filter&countryName=<?php echo $country; ?>&cityName=Null'"/>
									<label class="countryPageButtonLabal">See suggested lists for this country</label>
									<div class="clear"></div>						
							</div>													
						</div>	<!--/countryPageCountryBox-->
						<div class="clear"></div>		    		
			  		</div> <!--/map-->
			    </div>	 <!--/content	-->				        
			</main>
			<div class="mobileBtnsCountry">
				<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");}else{/*include_once("includes/php_includes/pageReturningSections/footer.php");*/} ?>
			</div>					
			<div class="clear"></div>	
		</div>
	</body>
</html>
<?php
	mysqli_free_result($resultCountry);
	mysqli_free_result($resultCity);
	mysqli_close($conn_countries);
?>	