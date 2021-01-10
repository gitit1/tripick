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
	$activityType = $_GET['activityType'];
	if ( ($activityType != "Null") && ($countryName != "Null") && (($cityName != "Select City") And ($cityName != "Null")) ){
		$query = "SELECT * FROM activities where countryName='$countryName' AND cityName='$cityName' AND activityType='$activityType' ORDER BY activityName ASC";
		$rcmListsHdr = "$activityType in $countryName - $cityName:";
	
	}elseif ( ($activityType != "Null") && ($countryName != "Null") ){
		$query = "SELECT * FROM activities where countryName='$countryName' AND activityType='$activityType' ORDER BY activityName ASC";	
		$rcmListsHdr = "$activityType in $countryName:";
	
	}elseif ( ($activityType != "Null") && ($countryName == "Null") ){
		$query = "SELECT * FROM activities where activityType='$activityType' ORDER BY activityName ASC";
		$rcmListsHdr = "$activityType:";	
	
	}elseif ( ($activityType == "Null") && ($countryName != "Null") && (($cityName != "Select City") And ($cityName != "Null")) ){
		$query = "SELECT * FROM activities where countryName='$countryName' AND cityName='$cityName' ORDER BY activityName ASC";
		$rcmListsHdr = "Activities from $countryName - $cityName: ";
	
	}elseif ( ($activityType == "Null") && ($countryName != "Null") ){
		$query = "SELECT * FROM activities where countryName='$countryName' ORDER BY activityName ASC";
		$rcmListsHdr = "Activities from $countryName: ";
	
	}else{
		$query = "SELECT * FROM activities ORDER BY activityName ASC";
		$rcmListsHdr = "Activities:";
	}
	
    $result = mysqli_query($conn_actlst, $query);
    
}else{
    $query = "SELECT * FROM activities ORDER BY RAND() LIMIT 12";
    $result = mysqli_query($conn_actlst, $query);
	$rcmListsHdr = "Recommended Activities:";	
}
if(!$result) {
    die("DB query failed.");
}		
?>
<?php
	$arr = array();
	$actNote = '';
	$id = 0;
	while($row = mysqli_fetch_assoc($result)){
		$actId = $row["id"];
		$cntName = $row["countryName"];
		$ctyName = $row["cityName"];
		$logo = $row["logo"];
		$actName = $row["activityNameShort"];
		$actType = $row["activityType"];
		
		$actNote = "<article class='activityBox'>";
		$actNote .= "<img src='images/activities/logos/$logo' class='activityBoxLogo'>";
		$actNote .= "<label class='activityBoxCntName'>$cntName - $ctyName</label>";
		$actNote .= "<label class='activityBoxActName'>$actName</label>";
		$actNote .= "<label class='activityBoxActType'>$actType</label>";									
		$actNote .= "<div class='actPageBtnFull'><a href='$listId'>
						<a href='activitiesPopUp.php?actId=$actId' onclick=\"popUpOpenIframeSwthR(650,600)\" class=\"iframe actPageActLink\">
						<img src='images/lists/seeMoreList.png' alt='See Activity Details' title='See Activity Details'>
						</a></div>"; 
		$actNote .= "</article>";
		$id = $id + 1;
		array_push($arr,$actNote);		
	}
		
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Activities</title>
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); 
			if($mobile){
				header("location: index.php");
			}
		?>	 	    		
		<script>
		function filterActQuery(){												
				var countryName = _("countryName").value;				
				var cityName = _("cityName").value;
				var activityType = _("activityType").value;
				if (cityName == "" || cityName.length == 0 || cityName == null){cityName= "Null";}
				if (activityType == "" || activityType.length == 0 || activityType == null || activityType == "Activities/Sights"){activityType = "Null";}			
				if (countryName == "" || countryName.length == 0 || countryName == null || countryName == "Select Country"){countryName = "Null";}							
				window.location.href = "activities.php?filter&countryName="+countryName+"&cityName="+cityName+"&activityType="+activityType;
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
						<li class="breadCrumsHighlight"><a href="activities.php">Activities</a></li>
					</ul>
				</nav>
			    <h1 class="pageHeader">Activities & Sights</h1>					
			    <div class="content">
				    <div class="content">
				    	<div class="userMenu">
							<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
				    	</div>
				    	<div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">
							<!--<section class="searchSection">
								<?php include_once("includes/php_includes/searchBox/searchBox.php"); ?>													
							</section>-->
			    		<div id="actPageFiltersInsideBox">			    			
				    			<h3 class="actPageFiltersLabel">Filters for Search:</h3>
									<form name="actPageForm" method="post" onsubmit="return false;">
										<label class="actPageFormCountrylabel">Country:<br>
									    	<select id="countryName" class="actPageFormCountrySelect chosen-select_filter countryBox" onchange="fetch_select(this.value);">
									      		<?php include("includes/php_includes/pageReturningSections/template_country_list.php"); ?>
									    	</select>
									    </label><br>
										<label class="actPageFormCitylabel">City:<br>
												<span id="try"><?php echo $try; ?></span>
										</label><br>									    
										<label class="actPageFormActivityTypelabel">(*)Activity Type:<br>
											<select id="activityType" placeholder="Activities/Sights" class="chosen-select_filter countryBox">
												<?php include("includes/php_includes/pageReturningSections/template_activities_list.php"); ?>
											</select>
										</label><br>									    									    
									    <button id="actPagesearchresultsSend" onclick="filterActQuery()" class="searchresultsSend">Search</button>
									</form>				    							    			
				    		</div>
				    		<h4 class="rcmListsHdr"><?php echo $rcmListsHdr ?></h4>	
							<div id='myListsListsBoxesWrap'> <!--friendsSectionSeeMyFriendsBox-->
								<div id='actPageListsBoxes'>	
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
											echo "<a href='activities.php?filter&countryName=$countryName&cityName=$cityName&activityType=$activityType&offset=$back'>
													<img src='images/back.png' class='generalBackButton generalBackButton_actPage'>
												  </a>";
										}									
										if ( $next < (sizeof($arrayIterator))  ) {	
											echo "<a href='activities.php?filter&countryName=$countryName&cityName=$cityName&activityType=$activityType&&offset=$next'>
													<img src='images/next.png' class='generalNextButton generalNextButton_actPage'>
												  </a>";
										}					    
									?>
								</div>				
							</div>									    									    						    		
				    	</div>			
			    	</div>			    	
					<div class="clear"></div>			    	
			    </div>
			<div class="mobileBtnsActivities">
				<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");}else{/*include_once("includes/php_includes/pageReturningSections/footer.php");*/} ?>
			</div>				    						        
			</main>	

		</div>
	</body>
</html>

<?php
	mysqli_free_result($result);
	mysqli_close($conn_actlst);
?>	