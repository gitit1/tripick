<?php //check login status_activity
	include_once("includes/php_includes/check_login_status.php");
?>
<?php //permissions:
	if($user_ok != true){
		header("location: notallowed.php");
	}
?>
<?php include_once("includes/php_includes/pageReturningSections/getCityAndCountry.php"); ?> 
<?php
if(isset($_POST["query"])){
	$userName = $_POST['userName'];
	$countryName = $_POST['countryName'];
	$cityName = $_POST['cityName'];
	$fromDate = preg_replace('#[^a-z0-9_]#i', '', $_POST['fromDate']);
	$toDate = preg_replace('#[^a-z0-9_]#i', '', $_POST['toDate']);
	$partnerGender = preg_replace('#[^a-z]#i', '', $_POST['partnerGender']);
	$partnerMinAge = preg_replace('#[^0-9]#i', '', $_POST['partnerMinAge']);
	$partnerMaxAge = preg_replace('#[^0-9]#i', '', $_POST['partnerMaxAge']);
	$partnerCountry = preg_replace('#[^a-z0-9_-]#i', '', $_POST['partnerCountry']);
	$buildTripDetails = preg_replace('#[^a-z0-9_ ]#i', '', $_POST['buildTripDetails']);

	$sql1 = "SELECT * FROM users WHERE username='$userName' LIMIT 1";
	$user_query = mysqli_query($conn_users, $sql1);
	
	$row1 = mysqli_fetch_array($user_query, MYSQLI_ASSOC);
	$userAvatar = $row1["avatar"];
	$userAge = $row1["birthday"];
	$userGender = $row1["gender"];
	$userCountry = $row1["country"];
	$userFbId = $row1["fbId"];

	 if ($userAge == '0000-00-00'){		
		 echo 'birthday_missing';
		 exit; 		
 	}
	 
	$dob = strtotime(str_replace("/","-",$userAge));       
	$tdate = time();
	$Uage =  date('Y', $tdate) - date('Y', $dob);

	
	if($countryName == "Null" || $cityName == "Null"){
		echo "The form submission is missing values.";
        exit();
    } else {
		$sql = "INSERT INTO buildTripSearch (userName, countryName, cityName, fromDate, toDate, partnerGender
				, partnerMinAge, partnerMaxAge, partnerCountry, buildTripDetails, queryDate, userAvatar, userAge, userCountry, userGender, userFbId)       
		        VALUES('$userName','$countryName','$cityName','$fromDate','$toDate','$partnerGender'
		        ,'$partnerMinAge','$partnerMaxAge','$partnerCountry','$buildTripDetails', now(), '$userAvatar', '$Uage', '$userCountry', '$userGender', '$userFbId')";
		$query = mysqli_query($conn_query, $sql); 
		
		if ($query){
			echo "query_success";
		} else {
			echo "There WAS an Error";		
		}
		
		exit();
	}
	exit();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Search for Partner</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?> 
		<script>
		function sendQueryBuild(){
				var status_buildTrip = _("status_buildTrip");				
				status_buildTrip.innerHTML = "Please wait...";
				var userName = _("userName").value;
				var countryName = _("countryName").value;
				if (countryName == "" || countryName.length == 0 || countryName == null){countryName = "Null";}	
				var cityName = _("cityName").value;
				if (cityName == "" || cityName.length == 0 || cityName == null){cityName = "Null";}	
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
				if (partnerCountry == "" || partnerCountry.length == 0 || partnerCountry== null){partnerCountry = "Null";}
				var buildTripDetails = _("buildTripDetails").value;
				if (buildTripDetails == "" || buildTripDetails.length == 0 || buildTripDetails == null){buildTripDetails = "Null";}	
												
				var ajax = ajaxObj("POST", "searchbuild.php");
		        ajax.onreadystatechange = function() {
			        if(ajaxReturn(ajax) == true) {
			            if (ajax.responseText.trim() == "birthday_missing"){
			            	window.location.href =	'searchbuild.php?actMsg=birthday_missing';						
						} else if(ajax.responseText.trim() != "query_success"){
							status_buildTrip.innerHTML = ajax.responseText;
						} else {
							window.location.href = "searchbuildresults.php?query=newQuery"
							+"&userName="+userName+"&countryName="+countryName+"&cityName="+cityName
							+"&fromDate="+fromDate+"&toDate="+toDate
							+"&partnerGender="+partnerGender+"&partnerMinAge="+partnerMinAge+"&partnerMaxAge="+partnerMaxAge
							+"&partnerCountry="+partnerCountry							
							+"&buildTripDetails="+buildTripDetails;
						}
			        }
		        }
		        ajax.send("query=newQuery"+"&userName="+userName+"&countryName="+countryName+"&cityName="+cityName
							+"&fromDate="+fromDate+"&toDate="+toDate
							+"&partnerGender="+partnerGender+"&partnerMinAge="+partnerMinAge+"&partnerMaxAge="+partnerMaxAge
							+"&partnerCountry="+partnerCountry							
							+"&buildTripDetails="+buildTripDetails);
	       }	      		
		</script>	
	</head>
	<body>
		<?php include_once("includes/php_includes/pageReturningSections/messages.php"); ?>
		<div style='display:none'><div id="actMsgAlert"><p><?php echo $actMsg ?></p></div></div>		
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
						<?php if ($_GET["cnt"]){
							$cnt = $_GET["cnt"];
							$cty = $_GET["cty"];
							echo "<li><a href=\"continents.php\">Continent</a></li>";
							echo "<li><img src=\"images/main/breadcrumsArrows.png\" class=\"navArrows\"></li>";
							echo "<li><a href=\"countries.php?continent=$cnt\">$cnt</a></li>";
							echo "<li><img src=\"images/main/breadcrumsArrows.png\" class=\"navArrows\"></li>";
							echo "<li><a href=\"country.php?continent=$cnt&country=$cty\">$cty</a></li>";
						}else{
							echo "<li><a href=\"searches.php\">Searches</a></li>";
						}
						?>
						<li><img src="images/main/breadcrumsArrows.png" class="navArrows"></li>
						<li class="breadCrumsHighlight"><a href="javascript:window.location.href=window.location.href">Search Partner</a></li>
					</ul>	
				</nav>
			    <h1 class="pageHeader activitySrc">Build a Trip</h1>					
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>
				    <div class="mapGeneralSettings mapOpacity mapFixedHeight">
				    	<div class="actFrmReq"><h4>(*)Required Fields</h4></div>
						<div class="searchBuildTripFormDiv">				    	
							<form name="searchBuildTripForm" method="post" onsubmit="return false;">
								<label class="searchBuildTripFormCountrylabel">(*)Country:<br>
							    	<select id="countryName" name="countryName" onfocus="emptyElement('status_activity')" 
							    			onchange="fetch_select(this.value);"  class="chosen-select countryBox">
							      		<?php include("includes/php_includes/pageReturningSections/template_country_list.php"); ?>
							    	</select>
							    </label><br>						    
								<label class="searchBuildTripFormCitylabel">(*)City:<br>								
									<span id="try"><?php echo $try; ?></span>
								</label><br>
								<label class="searchBuildTripFormFromDatelabel">From Date:<br>
									<input type="date" id="fromDate" value="<?php echo date("Y-m-d");?>" class="chosen-date">
								</label><br>
								<label class="searchBuildTripToDatelabel">To Date:<br>
									<input type="date" id="toDate" value="<?php echo date("Y-m-d");?>" class="chosen-date">
								</label><br>
							    <label class="searchBuildTripFormPartnerGenderlabel">Partner Gender:<br>
							    	<div>
								        <input id="gender" type="radio" name="sex" value="m" checked> Male
		  								<input id="gender" type="radio" name="sex" value="f"> Female
								    	<input id="gender" type="radio" name="sex" value="b"> Both
							    	</div>
							    </label><br>								
								<label class="searchBuildTripPartnerAgelabel">Partner Age:<br>
										<div>
											<input type="checkbox" name="partnerAge" value="16-20">16-20
											<input type="checkbox" name="partnerAge" value="21-30" checked>21-30
											<input type="checkbox" name="partnerAge" value="31-40">31-40
											<input type="checkbox" name="partnerAge" value="41-50">41-50
										</div>
								</label>
								<label class="searchBuildTripCountryPartnerlabel">Only partner from::<br>							    
							    	<select id="countryNamePartner" name="countryNamePartner" onfocus="emptyElement('status_activity')" 
							    		    class="chosen-select countryBox"> 							    		
							      		<?php include("includes/php_includes/pageReturningSections/template_country_list_clean.php"); ?>
							    	</select>							    
							    </label><br>
							    								
								<label class="searchBuildTripDescriptionlabel">Desciption For Search:<br>								
									<textarea rows="6" cols="35" placeholder="Type Description" id="buildTripDetails"></textarea>
								</label><br>
							    <button id="searchBuildTripSearch" onclick="sendQueryBuild()">Search Partners</button>
							    <span id="status_buildTrip"></span>
							    <input type="hidden" id="userName" value="<?php echo  $userName; ?>" >
							</form>						
						</div>
					</div>	
				</div>
				<?php if ($mobile){
					echo "<div class=\"compassPhotoAct\"><img src=\"http://tripick.net/images/mobile/com.png\"></div>";
				}
				?>				
				<div class="mobileBtnsSrcBld">
					<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");}else{/*include_once("includes/php_includes/pageReturningSections/footer.php");*/} ?>
				</div>								
			</main>

		</div>	
	</body>    	