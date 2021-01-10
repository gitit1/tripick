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
<?php 
    $continent = $_GET['continent'];
    //get data from DB
    if($continent == "Mobile"){
    	$query = "SELECT * FROM countriesTable WHERE LENGTH(countryName)<15 ORDER BY RAND() LIMIT 10";
		$result = mysqli_query($conn_countries, $query); 	
    }elseif($mobile){
    	$query = "SELECT * FROM countriesTable Where countryContinent = '$continent' AND LENGTH(countryName)<15 ORDER BY RAND() LIMIT 10";
    	$result = mysqli_query($conn_countries, $query);    	
    }else{
    	$query = "SELECT * FROM countriesTable Where countryContinent = '$continent' ORDER BY countryName ASC";
    	$result = mysqli_query($conn_countries, $query);     	
    }

    if(!$result) {
        die("DB query failed.");
    }
?>
<?php 
	$arr = array();
	$countryNote = '';
	$id = 0;
	while($row = mysqli_fetch_assoc($result)){
	$countryNote =  "<article class='contriesPageCountryBox contriesPageCountryBox_$id'>";
	$countryNote .=  "<a href='country.php?continent=" . $continent. "&country=" . $row["countryName"] . "'class='contriesPageCountryLink' '>";
	$countryNote .=  "<img src='images/countries/flags_small/" . $row["countryInitial"] . ".png' class='contriesPageCountryFlag' '>";
	$countryNote .=  "<h3>" . $row["countryName"] . "</h3></a>";
	$countryNote .=  "</article>";
	$id = $id + 1;
	array_push($arr,$countryNote);
	}	

?>
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
						<li><a href="continents.php">Continents</a></li>
						<li><img src="images/main/breadcrumsArrows.png" class="navArrows"></li>
						<li class="breadCrumsHighlight"><a href="countries.php?continent=<?php echo $continent; ?>"><?php echo $continent; ?></a></li>	
					</ul>
				</nav>
			    <h1 class="pageHeader countriesPageHdr"><?php if($mobile){echo "Countries";}else{echo $continent;} ?></h1>					
			    <div class="content">
				    <div class="content">
				    	<div class="userMenu">
							<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
				    	</div>
				    	<div class="mapGeneralSettings mapOpacity mapAutoHeight">
							<section class="searchSection searchSection_mobile">
								<?php include_once("includes/php_includes/searchBox/searchBox.php"); ?>													
							</section>
							<div class="countriesPageBoxes">
							<?php
								$offset = (int) (isset($_GET['offset']) ? $_GET['offset'] : 0);
								$limit = 12;
								
								$arrayIterator = new ArrayIterator($arr);
								$limitIterator = new LimitIterator($arrayIterator, $offset, $limit);
								
								$n = 0;
								foreach ($limitIterator as $node) {
								    $n++;
									echo $node;
								}
								$back = $offset - 12;
								$next = $offset + 12;
								if (  $back >= 0 ) {
									echo "<a href='countries.php?continent=$continent&offset=$back'>
											<img src='images/back.png' class='generalBackButton generalBackButton_createnewlist'>
										  </a>";
								}									
								if ( $next < (sizeof($arrayIterator))  ) {	
									echo "<a href='countries.php?continent=$continent&offset=$next'>
											<img src='images/next.png' class='generalNextButton generalNextButton_createnewlist'>
										  </a>";
								}					    
							?>					
							</div>									    									    						    		
				    	</div>			
			    	</div>			    	
					<div class="clear"></div>			    	
			    </div>						        
			</main>
			<div class="mobileBtnsCountries">
				<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");}else{/*include_once("includes/php_includes/pageReturningSections/footer.php");*/} ?>
			</div>		
		</div>
	</body>
</html>
<?php
	mysqli_free_result($result);
	mysqli_close($conn_countries);
?>	