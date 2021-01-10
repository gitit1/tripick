<!--UPDATE `lists` SET `numOfViews`='numOfViews'+1 -->
<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
?>
<?php 
	$filter = true;
	include_once("includes/php_includes/pageReturningSections/getCityAndCountry.php"); 
?> <?php
if(isset($_GET["filter"])){
	$countryName = $_GET['countryName'];
	$cityName = $_GET['cityName'];
	
	if ( ($countryName != "Select Country") AND ($cityName != "Null") ){
		$query = "SELECT * FROM lists Where accepted = '1' AND country='$countryName' AND city='$cityName' ORDER BY numOfViews DESC";
		$rcmListsHdr = "Lists of $countryName - $cityName:";
	}elseif ( ($countryName != "Select Country") ) {
		$query = "SELECT * FROM lists Where accepted = '1' AND country='$countryName'ORDER BY numOfViews DESC";
		$rcmListsHdr = "Lists of $countryName:";
	}else{
		$query = "SELECT * FROM lists Where accepted = '1' ORDER BY numOfViews DESC";
		$rcmListsHdr = "Recommended Lists:";
	}
	
    $result = mysqli_query($conn_actlst, $query);
    if(!$result) {
        die("DB query failed.");
    }	
}else{
    $query = "SELECT * FROM lists Where accepted = '1' ORDER BY numOfViews DESC LIMIT 6";
    $result = mysqli_query($conn_actlst, $query);
    if(!$result) {
        die("DB query failed.");
    }
	$rcmListsHdr = "Recommended Lists:";	
}		
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Lists</title>
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); 
			if($mobile){
				header("location: index.php");
			}
		?>	
		<script>
		function filterListsQuery(){												
				var countryName = _("countryName").value;
				var cityName = _("cityName").value;
				if (cityName == "" || cityName.length == 0 || cityName == null){cityName= "Null";}	
							
				window.location.href = "lists.php?filter&countryName="+countryName+"&cityName="+cityName;
	       }	      		
		</script>					    			    		
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
						<li class="breadCrumsHighlight"><a href="lists.php">Lists</a></li>
					</ul>
				</nav>
			    <h1 class="pageHeader">Lists</h1>					
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>
			    	<div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">
			    		<div id="ListsPageFiltersInsideBox">			    			
			    			<h3 class="searchresultsPageFiltersLabel">Filters for Search:</h3>
								<form name="searchresultsPageForm" method="post" onsubmit="return false;">
									<label class="ListsPageFormCountrylabel">Country:<br>
								    	<select id="countryName" class="ListsPageFormCountrySelect chosen-select_filter countryBox" onchange="fetch_select(this.value);">
								      		<?php include("includes/php_includes/pageReturningSections/template_country_list.php"); ?>
								    	</select>
								    </label><br>
									<label class="ListsPageFormCitylabel">City:<br>
											<span id="try"><?php echo $try; ?></span>
									</label><br>									    
								    <button id="ListsPagesearchresultsSend" onclick="filterListsQuery()" class="searchresultsSend">Search</button>
								</form>				    							    			
			    		</div>
			    		<h4 class="rcmListsHdr"><?php echo $rcmListsHdr ?></h4>	
						<div id='myListsListsBoxesWrap'> <!--friendsSectionSeeMyFriendsBox-->
							<div id='ListsPageListsBoxes'>	
								<?php include_once("includes/php_includes/listsPhp/listsLstRst.php"); ?>
								<?php
									$offset = (int) (isset($_GET['offset']) ? $_GET['offset'] : 0);
									$limit = 6;
									
									$arrayIterator = new ArrayIterator($arr);
									$limitIterator = new LimitIterator($arrayIterator, $offset, $limit);
									
									$n = 0;
									foreach ($limitIterator as $node) {
									    $n++;
										echo $node;
									}
									$back = $offset - 6;
									$next = $offset + 6;
									if (  $back >= 0 ) {
										echo "<a href='lists.php?filter&countryName=$countryName&cityName=$cityName&offset=$back'>
												<img src='images/back.png' class='generalBackButton generalBackButton_listsPage'>
											  </a>";
									}									
									if ( $next < (sizeof($arrayIterator))  ) {	
										echo "<a href='lists.php?filter&countryName=$countryName&cityName=$cityName&offset=$next'>
												<img src='images/next.png' class='generalNextButton generalNextButton_listsPage'>
											  </a>";
									}					    
								?>									
							</div>			
						</div>
					</div>																					    									    						    		
			    </div>						    	
				<div class="clear"></div>			    							        
			</main>	
			<div class="mobileBtnsLists">
				<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");}else{/*include_once("includes/php_includes/pageReturningSections/footer.php");*/} ?>
			</div>	
		</div> <!--Wrapper-->
	</body>
</html>




