<?php //check login status_activity
	include_once("includes/php_includes/check_login_status.php");
?>
<?php	if($user_ok != true){
		header("location: notallowed.php");
	}
?>
<?php 
	$filter = true;
	include_once("includes/php_includes/pageReturningSections/getCityAndCountry.php");
?> 
<?php
if ($_GET['query'] == "newQuery"){		


	$userName = $_GET['userName'];
	$countryName = $_GET['countryName'];
	$cityName = $_GET['cityName'];
	$fromDate = $_GET['fromDate'];
	$toDate = $_GET['toDate'];
	$partnerGender = $_GET['partnerGender'];
	$partnerMinAge = $_GET['partnerMinAge'];
	$partnerMaxAge = $_GET['partnerMaxAge'];
	$partnerCountry = $_GET['partnerCountry'];
		
	$today = date("Y-m-d");

 	$sql1 = "SELECT * FROM users WHERE username='$userName' LIMIT 1";
	$user_query = mysqli_query($conn_users, $sql1);
	
	$row1 = mysqli_fetch_array($user_query, MYSQLI_ASSOC);
	$userAge = $row1["birthday"];
	$userGender = $row1["gender"];
	$userCountry = $row1["country"];

	$dob = strtotime(str_replace("/","-",$userAge));       
	$tdate = time();
	$Uage =  date('Y', $tdate) - date('Y', $dob);
 
	if($partnerGender == 'f'){
		$genderQuery = "( ( (partnerGender = 'f') OR (partnerGender = 'b') ) AND (userGender  = 'f') ) AND"; //gender = 1		
	}else if($partnerGender == 'm'){
		$genderQuery = "( ( (partnerGender = 'm') OR (partnerGender = 'b') ) AND  (userGender = 'm') ) AND"; //gender = 1				
	}else{							
		$genderQuery = "( (partnerGender = 'b') OR (partnerGender = 'f') OR (partnerGender = 'm') ) AND"; //gender = 1
	}
		
	$regularQuery = "SELECT * FROM buildTripSearch Where 
					countryName = '" . $countryName . "' AND
					cityName = '" . $cityName . "' AND  ";

	$ageQuery = "( (userAge BETWEEN " . $partnerMinAge . "  AND " . $partnerMaxAge . ") 
				 AND (". $Uage ." BETWEEN partnerMinAge AND partnerMaxAge) )"; 	
		
	$dateQuery00 = "(fromDate = '" . $today . " ' AND toDate ='" . $today. "') AND ";
	$dateQuery01 = "(fromDate = '" . $today . " ' AND toDate ='" . $toDate . "') AND ";
	$dateQuery10 = "(fromDate = '" . $fromDate . " ' AND toDate ='" . $today . "') AND ";
	$dateQuery11 = "(fromDate = '" . $fromDate . " ' AND toDate ='" . $toDate . "') AND ";
	//$genderQuery = "( ( (partnerGender = '" . $partnerGender . "') AND (userGender = '" . $partnerGender . "') )OR (partnerGender = 'b') ) AND"; //gender = 1
	$countryQuery = "(userCountry = '" . $partnerCountry . "') AND "; //partner country  = 1 //  //$userCountry == 'Choose Country'
	$endQuery = $ageQuery." AND (userName != '" . $userName. "') ORDER BY userName ASC";	
	$queryNum = 'None';
	
	if ( ($fromDate == $today) && ($toDate == $today) && ($partnerGender == "b")  && ($partnerCountry == "Null") ){ //0 0 0 0 - 1
	   	$query = $regularQuery . $dateQuery00 . $endQuery;
	   	$queryNum = '1';
	}
	
	elseif( ($fromDate == $today) && ($toDate == $today) && ($partnerGender == "b")  && ($partnerCountry != "Null") ){ //0 0 0 1 - 2
	   	$query = $regularQuery . $dateQuery00 . $countryQuery  . $endQuery;
	   	$queryNum = '2';
	}
	
	elseif( ($fromDate == $today) && ($toDate == $today) && ($partnerGender != "b")  && ($partnerCountry != "Null") ){ //0 0 1 0 - 3
	   	$query = $regularQuery . $dateQuery00 . $genderQuery. $endQuery;
		$queryNum = '3';
	}
	
	elseif ( ($fromDate == $today) && ($toDate == $today) && ($partnerGender != "b")  && ($partnerCountry != "Null") ){ //0 0 1 1 - 4
	   	$query = $regularQuery . $dateQuery00 . $genderQuery . $countryQuery . $endQuery;
		$queryNum = '4';
	}
	
	elseif ( ($fromDate == $today) && ($toDate != $today) && ($partnerGender == "b")  && ($partnerCountry == "Null") ){ //0 1 0 0 - 5
	   	$query = $regularQuery . $dateQuery01. $endQuery;
		$queryNum = '5';
	}
	
	elseif ( ($fromDate == $today) && ($toDate != $today) && ($partnerGender == "b")  && ($partnerCountry != "Null") ){ //0 1 0 1 - 6
	   	$query = $regularQuery . $dateQuery01. $countryQuery . $endQuery;
		$queryNum = '6';
	}
	
	elseif ( ($fromDate == $today) && ($toDate != $today) && ($partnerGender != "b")  && ($partnerCountry == "Null") ){ //0 1 1 0 - 7
	   	$query = $regularQuery . $dateQuery01. $genderQuery . $endQuery;
		$queryNum = '7';
	}
	
	elseif ( ($fromDate == $today) && ($toDate != $today) && ($partnerGender != "b")  && ($partnerCountry != "Null") ){ //0 1 1 1 - 8
	   	$query = $regularQuery . $dateQuery01. $countryQuery . $genderQuery . $endQuery;
		$queryNum = '8';
	}	
	
	elseif ( ($fromDate != $today) && ($toDate == $today) && ($partnerGender == "b")  && ($partnerCountry == "Null") ){ //1 0 0 0 - 9
	   	$query = $regularQuery . $dateQuery10. $endQuery;
	   	$queryNum = '9';
	}	
	
	elseif ( ($fromDate != $today) && ($toDate == $today) && ($partnerGender == "b")  && ($partnerCountry != "Null") ){ //1 0 0 1 - 10
	   	$query = $regularQuery . $dateQuery10. $countryQuery . $endQuery;
		$queryNum = '10';
	}
	
	elseif ( ($fromDate != $today) && ($toDate == $today) && ($partnerGender != "b")  && ($partnerCountry == "Null") ){ //1 0 1 0 - 11
	   	$query = $regularQuery . $dateQuery10. $genderQuery . $endQuery;
		$queryNum = '11';
	}	
	
	elseif ( ($fromDate != $today) && ($toDate == $today) && ($partnerGender != "b")  && ($partnerCountry != "Null") ){ //1 0 1 1 - 12
	   	$query = $regularQuery . $dateQuery10. $countryQuery . $genderQuery . $endQuery;
		$queryNum = '12';
	}	
	
	elseif ( ($fromDate != $today) && ($toDate != $today) && ($partnerGender == "b")  && ($partnerCountry == "Null") ){ //1 1 0 0 - 13
	   	$query = $regularQuery . $dateQuery11. $endQuery;
		$queryNum = '13';
	}	
	
	elseif ( ($fromDate != $today) && ($toDate != $today) && ($partnerGender == "b")  && ($partnerCountry != "Null") ){ //1 1 0 1 - 14
	   	$query = $regularQuery . $dateQuery11. $countryQuery . $endQuery;
		$queryNum = '14';
	}	
	
	elseif ( ($fromDate != $today) && ($toDate != $today) && ($partnerGender != "b")  && ($partnerCountry == "Null") ){ //1 1 1 0 - 15
	   	$query = $regularQuery . $dateQuery11. $genderQuery . $endQuery;
		$queryNum = '15';
	}	
	
	elseif ( ($fromDate != $today) && ($toDate != $today) && ($partnerGender != "b")  && ($partnerCountry != "Null") ){ //1 1 1 1 - 16
	   	$query = $regularQuery . $dateQuery11 . $countryQuery . $genderQuery . $endQuery;
		$queryNum = '16';
	}			
				
    $result = mysqli_query($conn_query, $query);
	if ($mobile){
		 $rstH = "";
	}else{
		 $rstH = " for $countryName - $cityName";
	}   
    
    if(!$result) {  	
        die("DB query failed.");
    }
}
elseif ($_GET['query'] == "noQuery"){
	$query = "SELECT * FROM buildTripSearch where userName !='$userName'"	;
	$result = mysqli_query($conn_query, $query);
	$rstH = "";
}	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Search for Partner</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?>
		<script>

		function sendQuery(){												
				var userName = _("userName").value;
				var countryName = _("countryName").value;
				var cityName = _("cityName").value;
				var fromDate = _("fromDate").value;
				if (!fromDate){
					fromDate = new Date().toJSON().slice(0,10)
				}
				var toDate = _("toDate").value;
				if (!toDate){
					toDate = new Date().toJSON().slice(0,10)
				}				
				var partnerGender = document.querySelector('input[name="sex"]:checked').value;
				var partnerAge = getMultipleCheckbox(document.getElementsByName('partnerAge'));
				partnerAge = partnerAge.toString();
				var partnerMinAge = partnerAge.substr(0, 2);
				var partnerMaxAge = partnerAge.substr(-2, 2);
				var partnerCountry = _("countryNamePartner").value;
				if  (partnerCountry == "Select Country"){partnerCountry = "Null";}	
							
				window.location.href = "searchbuildresults.php?query=newQuery"
				+"&userName="+userName+"&countryName="+countryName+"&cityName="+cityName
				+"&fromDate="+fromDate+"&toDate="+toDate
				+"&partnerGender="+partnerGender+"&partnerMinAge="+partnerMinAge+"&partnerMaxAge="+partnerMaxAge
				+"&partnerCountry="+partnerCountry;
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
						<li class="breadCrumsHighlight"><a href="javascript:window.location.href=window.location.href">Results</a></li>
					</ul>
				</nav>
			    <h1 class="pageHeader searchRstHdr">Results<?php echo $rstH ?></h1>
			    <h4 class="pageHeaderS">your search has been posted, here are the results for suitible partners:</h4>					
			    <div class="content">												
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>
			    	<div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">
			    		<div id="searchresultsPageFiltersBox">
				    		<a class="searchresultsPageFiltersLabel2" href="#searchresultsPageFilters" onclick="toggleElement('searchresultsPageFiltersInsideBox')"><p>Click here to modify your search filter</p></a>
				    		<div id="searchresultsPageFiltersInsideBox">			    			
				    			<h3 class="searchresultsPageFiltersLabel">Filters for Search:</h3>
									<form name="searchresultsPageForm" method="post" onsubmit="return false;">
										<label class="searchResultsFormCountrylabel">Trip to Country:<br><!--NEED CHANGE - NEED 2 OPTIONS -->
									    	<select id="countryName" class="chosen-select_filter countryBox" onchange="fetch_select(this.value);">
									      		<?php include("includes/php_includes/pageReturningSections/template_country_list.php"); ?>
									    	</select>
									    </label><br>
										<label class="searchresultsPageFormCitylabel">City:<br>
											<span id="try"><?php echo $try; ?></span>
										</label><br>
										<label class="searchresultsPageFormFromDatelabel">From Date:<br>
											<input type="date" id="fromDate" class="chosen-date_filter" value="<?php echo date("Y-m-d");?>">
										</label><br>
										<label class="searchresultsPageFormToDatelabel">To Date:<br>
											<input type="date" id="toDate" class="chosen-date_filter"  value="<?php echo date("Y-m-d");?>">
										</label><br>
									    <label class="searchresultsPageFormPartnerGenderlabel">Partner Gender:<br>
									    	<div class="searchresultsPageFormPartnerGenderDiv">
										        <input id="gender" type="radio" name="sex" value="m" checked "> Male
				  								<input id="gender" type="radio" name="sex" value="f" "> Female
										    	<input id="gender" type="radio" name="sex" value="f" "> Both
									    	</div>
									    </label><br>								
										<label class="searchresultsPageFormPartnerAgelabel">Partner Age:<br>
												<div class="searchresultsPageFormPartnerGenderDiv">
													<input type="checkbox" name="partnerAge" value="16-20">16-20
													<input type="checkbox" name="partnerAge" value="21-30" checked>21-30
													<input type="checkbox" name="partnerAge" value="31-40">31-40
													<input type="checkbox" name="partnerAge" value="41-50">41-50
												</div>
										</label>
										<label class="searchresultsPageFormPartnerCountrylabel">Partner Country:<br>
									    	<select id="countryNamePartner" class="chosen-select_filter countryBox">
									      		<?php include("includes/php_includes/pageReturningSections/template_country_list.php"); ?>
									    	</select>
										</label>									
									    <button id="searchresultsSend" onclick="sendQuery()"  class="searchresultsSendBuild">Search</button>
									    <input type="hidden" id="userName" value="<?php echo  $userName; ?>" >
									</form>				    							    			
				    		</div>
				    	</div>
			    		<div class="srcRstBoxes">
							<?php
							    if ($mobile){
							    	$popUpMsg = 'popUpOpenIframe(900,800)';
							    }else{
							    	$popUpMsg = 'popUpOpenIframe(500,400)';
							    }														
								while($row = mysqli_fetch_assoc($result)){
									$userName = $row["userName"];	
									$userGender = $row["userGender"];
									$userAvatar = $row["userAvatar"];
									$userAge = $row["userAge"];
									$userCountry = $row["userCountry"];
									$partnerGender = $row["partnerGender"];		 
									$cityName = $row["cityName"];
									$countryName = $row["countryName"];
									$fromDate = $row["fromDate"];
									$toDate = $row["toDate"];  
									$partnerMinAge = $row['partnerMinAge'];
									$partnerMaxAge = $row['partnerMaxAge'];
									$partnerCountry = $row['partnerCountry'];
									$buildTripDetails = $row["buildTripDetails"];
									$userFbId  = $row["userFbId"]; 
									if ($userGender  == "f"){
										$uSex = "female";
									}else{
										$uSex = "male";
									}

									if ($userAvatar == ""){
										if ($userFbId == 'Null'){
											if($userGender == "f")
												{
													$imgSrc= "images/avatardefaultFemale.png";
												}else{
													$imgSrc = "images/avatardefaultMale.png";
												}		
											}else{
												$imgSrc  = "http://graph.facebook.com/$userFbId/picture?type=normal";
											}
									}else{
										$imgSrc = "users/" . $userName . "/". $userAvatar ."";
									}	

									if ($partnerGender  == "f"){
										$pSex = "a female partner";
									}elseif ($partnerGender  == "m"){
										$pSex = "a male partner";
									}else{
										$pSex = "partner";
									}
									
									if ($userCountry !=""){
										$uCountry = "from $userCountry";
									}
	
									$fromDate = date_format(new DateTime($fromDate), 'd/m/Y');
									$toDate = date_format(new DateTime($toDate), 'd/m/Y');
									$today = date("d/m/Y");
									
									if  ( ($fromDate == $today) && ($toDate == $today) ){										
										$date = "for today";
									}else{
										$date = "from $fromDate to $toDate";
									}
									
									$pAge = "$partnerMinAge-$partnerMaxAge";
									 
									 if($partnerCountry != 'Null'){
									 	$cty = " and from $partnerCountry";
									 }
									 																																										
									echo "<article class='searchresultsPageResultsBox'>";

									echo "<div class='searchresultsPageResultsBoxBtns'>";
									echo "<div class='searchresultsPageResultsBoxSendMessage'>
											<a href='template_pm.php?u=" . $userName . "' onclick='$popUpMsg' class='iframe' >
											<img src='images/message.png'></a>
										   </div>";
									echo "<div class='searchresultsPageResultsBoxViewProfile'>
									 		<a href='mypage.php?id=profile&u=" . $userName . "''>
									 		<img src='images/viewProfile.png'></a>
									 	  </div>";
									echo "</div>";									
									
									echo	"<img  class='searchresultsPageResultsBoxImg' src='". $imgSrc . "'>";	
									echo 	"<label class='searchresultsPageResultsBoxUserInfo'><b>$userName</b>	
												    is $userAge years old $uSex $uCountry</label><br>";
									echo 	"<label class='searchresultsPageResultsBoxPartnerInfo'>$userName is looking for $pSex for $activity $date.<br> 
											 the partner needs to be between the ages $pAge $cty</label><br>";
									if ($buildTripDetails != "Null"){
											echo "<label class='searchresultsPageResultsBoxUserDtl'>More Details for this Search:<br>";
											echo "<span>$buildTripDetails</span>";			
									}
									echo "</article>";										
								}
							?>
						</div>
						<div class="clear"></div>				    	
			    	</div>
			    </div>
				<div class="mobileBtnsSrcRst">
				<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");} ?>
				</div>			    
			 </main>
		</div>	
	</body>
</html>