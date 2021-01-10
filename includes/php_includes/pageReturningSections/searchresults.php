<?php //check login status_activity
	include_once("includes/php_includes/check_login_status.php");
?>
<?php 
	if($user_ok != true){
		header("location: notallowed.php");
	}
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
	$activityType = $_GET['activityType'];
	$activityName = $_GET['activityName'];
	$activityName = (string)$activityName;
	
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
 
	
	$regularQuery = "SELECT * FROM activitySearch Where 
					countryName = '" . $countryName . "' AND
					cityName = '" . $cityName . "' AND ";
	 
	
	$ageQuery = "( (userAge BETWEEN " . $partnerMinAge . "  AND " . $partnerMaxAge . ") 
				 AND (". $Uage ." BETWEEN partnerMinAge AND partnerMaxAge) )"; 	

	if($partnerGender == 'f'){
		$genderQuery = "( ( (partnerGender = 'f') OR (partnerGender = 'b') ) AND (userGender  = 'f') ) AND"; //gender = 1		
	}else if($partnerGender == 'm'){
		$genderQuery = "( ( (partnerGender = 'm') OR (partnerGender = 'b') ) AND  (userGender = 'm') ) AND"; //gender = 1				
	}else{							
		$genderQuery = "( (partnerGender = 'b') OR (partnerGender = 'f') OR (partnerGender = 'm') ) AND"; //gender = 1
	}
	
	//include("includes/php_includes/searchForms/actQuery.php");		

	$dateQuery00 = "(fromDate = '" . $today . " ' AND toDate ='" . $today. "') AND ";
	$dateQuery01 = "(fromDate = '" . $today . " ' AND toDate ='" . $toDate . "') AND ";
	$dateQuery10 = "(fromDate = '" . $fromDate . " ' AND toDate ='" . $today . "') AND ";
	$dateQuery11 = "(fromDate = '" . $fromDate . " ' AND toDate ='" . $toDate . "') AND ";
	//$genderQuery = "( ( (partnerGender = '" . $partnerGender . "') AND (userGender = '" . $partnerGender . "') )OR (partnerGender = 'b') ) AND"; //gender = 1
	$actTypeQuery =  "activityType = '" . $activityType . "' AND "; //activity type = 1
	$actNameQuery = "activityName = '" . $activityName . "' AND ";	 //activity name = 1    
	$countryQuery = "(userCountry = '" . $partnerCountry . "') AND "; //partner country  = 1 //  //$userCountry == 'Choose Country'
	$endQuery = $ageQuery." AND (userName != '" . $userName. "') ORDER BY userName ASC";	
	$queryNum = 'None';
	
	
	if ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //0 0 0 0 0 0 - 1
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
		$query = $regularQuery . $dateQuery00 . $endQuery;
	}
	   
	elseif ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //0 0 0 0 0 1 - 2
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery . $dateQuery00 . $countryQuery . $endQuery;
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //0 0 0 0 1 0 - 3
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery00 .  $genderQuery . $endQuery;
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //0 0 0 0 1 1 - 4
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery00 . $genderQuery. $countryQuery. $endQuery;
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //0 0 0 1 0 0 - 5
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery00 .  $actNameQuery. $endQuery;
		$queryNum = '5';
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //0 0 0 1 0 1 - 6
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery00 .  $actNameQuery . $countryQuery . $endQuery;
		$queryNum = '6';
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //0 0 0 1 1 0 - 7
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery . $dateQuery00 . $actNameQuery .$genderQuery . $endQuery;
		$queryNum = '7';
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //0 0 0 1 1 1 - 8
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery . $dateQuery00 . $actNameQuery .$genderQuery . $countryQuery . $endQuery;
		$queryNum = '8';
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //0 0 1 0 0 0 - 9
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $endQuery;	
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //0 0 1 0 0 1 - 10
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
		$query = $regularQuery .$dateQuery01 . $countryQuery  . $endQuery;	   	
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //0 0 1 0 1 0 - 11
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $genderQuery.  $endQuery;	
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //0 0 1 0 1 1 - 12
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $genderQuery.$countryQuery . $endQuery;	
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //0 0 1 1 0 0 - 13
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $actNameQuery . $endQuery;
		$queryNum = '13';
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 0 1 1 0 1 - 14
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $actNameQuery. $countryQuery . $endQuery;
		$queryNum = '14';
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 0 1 1 1 0 - 15
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $actNameQuery. $genderQuery . $endQuery;
		$queryNum = '15';
	}
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 0 1 1 1 1 - 16
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $actNameQuery. $genderQuery . $countryQuery  . $endQuery;
		$queryNum = '16';	
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 1 0 0 0 0 - 17
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
		$query = $regularQuery .$dateQuery10 . $endQuery;	   	
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 1 0 0 0 1 - 18
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $countryQuery . $endQuery;
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 1 0 0 1 0 - 19
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $genderQuery . $endQuery;
		$queryNum = '19';	
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 1 0 0 1 1 - 20
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $genderQuery. $countryQuery . $endQuery ;
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 1 0 1 0 0 - 21
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $actNameQuery. $endQuery;
		$queryNum = '21';
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 1 0 1 0 1 - 22
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $actNameQuery. $countryQuery. $endQuery;
		$queryNum = '22';
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 1 0 1 1 0 - 23
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $actNameQuery. $genderQuery . $endQuery;
		$queryNum = '23';
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //0 1 0 1 1 1 - 24
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $actNameQuery. $genderQuery . $countryQuery. $endQuery;
		$queryNum = '24';
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //0 1 1 0 0 0 - 25
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery11. $endQuery;
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //0 1 1 0 0 1 - 26
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery11.$countryQuery. $endQuery;
	}
	   
	   
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //0 1 1 0 1 0 - 27
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery11.$genderQuery. $endQuery;
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //0 1 1 0 1 1 - 28
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery11.$genderQuery. $countryQuery.$endQuery;	
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //0 1 1 1 0 0 - 29
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	    $query = $regularQuery .$dateQuery11. $actNameQuery . $endQuery;
		$queryNum = '29';	
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //0 1 1 1 0 1 - 30
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery11.$actNameQuery.$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //0 1 1 1 1 0 - 31
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery11.$actNameQuery.$genderQuery. $endQuery;
		$queryNum = '31';
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //0 1 1 1 1 1 - 32
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery11.$actNameQuery.$genderQuery.$countryQuery. $endQuery;
		$queryNum = '32';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 0 0 0 0 0 - 33
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery .$dateQuery00 . $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 0 0 0 0 1 - 34
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery .$dateQuery00 .$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 0 0 0 1 0 - 35
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery .$dateQuery00 .$genderQuery . $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 0 0 0 1 1 - 36
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery00 .$genderQuery .$countryQuery + $endQuery;
	}

	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 0 0 1 0 0 - 37
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery00 .$actNameQuery . $endQuery;
		$queryNum = '37';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 0 0 1 0 1 - 38
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery00 .$actNameQuery . $countryQuery. $endQuery;
		$queryNum = '38';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 0 0 1 1 0 - 39
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery . $actTypeQuery. $dateQuery00 .$actNameQuery .$genderQuery . $endQuery;
		$queryNum = '39';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 0 0 1 1 1 - 40
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
		$query = $regularQuery .$actTypeQuery.$dateQuery00 .$actNameQuery .$genderQuery . $countryQuery. $endQuery;
		$queryNum = '40';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //1 0 1 0 0 0 - 41
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery01. $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //1 0 1 0 0 1 - 42
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery01. $countryQuery .  $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //1 0 1 0 1 0 - 43
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery01.$genderQuery .  $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //1 0 1 0 1 1 - 44
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery01.$genderQuery. $countryQuery .  $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //1 0 1 1 0 0 - 45
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery01. $actNameQuery.  $endQuery;
		$queryNum = '45';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //1 0 1 1 0 1 - 46
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery01. $actNameQuery. $countryQuery . $endQuery;
		$queryNum = '46';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //1 0 1 1 1 0 - 47
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   		$query = $regularQuery .$actTypeQuery. $dateQuery01. $actNameQuery. $genderQuery . $endQuery;
			$queryNum = '47';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate == $today) && ($toDate != $today) //1 0 1 1 1 1 - 48
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery01. $actNameQuery. $genderQuery. $countryQuery . $endQuery;
		$queryNum = '48';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //1 1 0 0 0 0 - 49
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //1 1 0 0 0 1 - 50
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   		$query = $regularQuery .$actTypeQuery. $dateQuery10. $countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //1 1 0 0 1 0 - 51
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $genderQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //1 1 0 0 1 1 - 52
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $genderQuery.$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //1 1 0 1 0 0 - 53
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $actNameQuery. $endQuery;
		$queryNum = '53';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //1 1 0 1 0 1 - 54
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $actNameQuery.$countryQuery .$endQuery;
		$queryNum = '54';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //1 1 0 1 1 0 - 55
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $actNameQuery.$genderQuery .$endQuery;
		$queryNum = '55';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate == $today) //1 1 0 1 1 1 - 56
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
		$query = $regularQuery .$actTypeQuery. $dateQuery10. $actNameQuery.$countryQuery.$genderQuery .$endQuery;
		$queryNum = '56';   	
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //1 1 1 0 0 0 - 57
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery11. $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //1 1 1 0 0 1 - 58
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   		$query = $regularQuery .$actTypeQuery. $dateQuery11.$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //1 1 1 0 1 0 - 59
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery11.$genderQuery.$endQuery;
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //1 1 1 0 1 1- 60
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery11. $genderQuery.$countryQuery. $endQuery;
		$queryNum = '60';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //1 1 1 1 0 0- 61
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery. $dateQuery11 .$actTypeQuery. $actNameQuery. $endQuery;
		$queryNum = '61';
	}
	
	elseif  ( ($activityType != "All Activities/Sights") && ($fromDate != $today) && ($toDate != $today) //1 1 1 1 0 1- 62
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery. $dateQuery11 .$actTypeQuery. $actNameQuery.$countryQuery . $endQuery;
		$queryNum = '62';
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 1 1 1 1 0- 63
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   		$query = $regularQuery. $dateQuery11 .$actTypeQuery. $actNameQuery.$countryQuery . $endQuery;
			$queryNum = '63';
	}
	
	elseif  ( ($activityType == "All Activities/Sights") && ($fromDate == $today) && ($toDate == $today) //1 1 1 1 1 1- 64
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
		$query = $regularQuery. $dateQuery11 .$actTypeQuery. $actNameQuery.$genderQuery.$countryQuery . $endQuery;
		$queryNum = '64';
	} 

    $result = mysqli_query($conn_query, $query);
	if ($mobile){
		 $rstH = "";
	}else{
		 $rstH = "to $countryName - $cityName";
	}
		
    if(!$result) {  	
        //die("DB query failed.");
    }
}
elseif ($_GET['query'] == "noQuery"){
	$query = "SELECT * FROM activitySearch where userName !='$userName'"	;
	$result = mysqli_query($conn_query, $query);
	$rstH = "";
}	
?>
<?php	//GET CITY AND COUNTRY           
   if(isset($_POST['get_option']))
   {
	    $defualtCty ="";		      
	    $country = $_POST['get_option'];
	    $queryCity = "SELECT * FROM citiesTable Where countryName = '" . $country . "'";
		$result = mysqli_query($conn_countries, $queryCity);
	    while ($row = mysqli_fetch_assoc($result)){
	        echo "<option>" . $row['cityName'] . "</option>";																		
		}	   
	    exit;
   }  	

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Search for Partner</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?>
		<script>

		function sendQueryFilterAct(){												
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
				var activityType = _("activityType").value;
				var activityName = _("activityName").value;				 
				if (activityName == "" || activityName.length == 0 || activityName == null){activityName = "Null";}	
							
				window.location.href = "searchresults.php?query=newQuery"
				+"&userName="+userName+"&countryName="+countryName+"&cityName="+cityName
				+"&fromDate="+fromDate+"&toDate="+toDate
				+"&partnerGender="+partnerGender+"&partnerMinAge="+partnerMinAge+"&partnerMaxAge="+partnerMaxAge
				+"&partnerCountry="+partnerCountry							
				+"&activityType="+activityType+"&activityName="+activityName;

	       }
	      		
		</script>		
	</head>
	<body>
<!--
<?php
	if($activityType == "All Activities/Sights"){
		echo "<h3 style='color:#fff'>activityType - 0</h3>";
	}else{
		echo "<h3 style='color:#fff'>activityType- 1</h3>";
	}
	/*if(($fromDate == $today) && ($toDate == $today)){
		echo "<h3 style='color:#fff'>fromDate & todate - True</h3>";
	}else{
		echo "<h3 style='color:#fff'>fromDate & todate - False</h3>";
		echo "<h3 style='color:#red'>$fromDate</h3>";
		echo "<h3 style='color:#red'>$toDate</h3>";
		echo "<h3 style='color:#red'>$today</h3>";
	}*/
		
	if($activityName == "Null") {
		echo "<h3 style='color:#fff'>activityName  - 0</h3>";
	}else{
		echo "<h3 style='color:#fff'>activityName - 1</h3>";
	}
	
	if($partnerGender == "b") {
		echo "<h3 style='color:#fff'>partnerGender  - 0</h3>";
	}else{
		echo "<h3 style='color:#fff'>partnerGender - 1</h3>";
	}

	if($partnerCountry == "Null") {
		echo "<h3 style='color:#fff'>partnerCountry - 0</h3>";
	}else{
		echo "<h3 style='color:#fff'>partnerCountry - 1</h3>";
	}	
?>		
<!--		<?php echo "<h3 style='color:#fff'>$query</h3>" ?>
		<?php echo "<h3 style='color:#fff'>$queryNum</h3>"  ?>
		<?php echo "<h3 style='color:#fff'>$fromDate</h3>"  ?>
		<?php echo "<h3 style='color:#fff'>$toDate</h3>"  ?>
		<?php echo "<h3 style='color:#fff'>$activityType</h3>"  ?>
		<?php echo "<h3 style='color:#fff'>$activityName</h3>"  ?>
		<?php echo "<h3 style='color:#fff'>$queryNum</h3>"  ?>-->
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
										<label class="searchResultsFormCountrylabel">Trip to Country:<br>
									    	<select id="countryName" class="chosen-select_filter countryBox " onchange="fetch_select(this.value);">
									      		<option>Select Country</option>
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
											<input type="date" id="toDate" class="chosen-date_filter" value="<?php echo date("Y-m-d");?>">
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
										<label class="searchresultsPageFormActivityTypelabel">Activity Type:<br>	
							    	<select id="activityType" placeholder="Activities/Sights" class="chosen-select_filter countryBox" onchange="fetch_select_act();" >
										<?php include("includes/php_includes/pageReturningSections/template_activities_list.php"); ?>
									</select>
										</label><br>
										<label class="searchresultsPageFormActivityNamelabel">Activity Name:<br>
											<span id="try"><?php echo $tryAct; ?></span>
									    <button id="searchresultsSend" onclick="sendQueryFilterAct()" class="searchresultsSend">Search</button>
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
									$activityType = $row["activityType"];	 
									$activityName = $row["activityName"];	 
									$cityName = $row["cityName"];
									$countryName = $row["countryName"];
									$fromDate = $row["fromDate"];
									$toDate = $row["toDate"];  
									$partnerMinAge = $row['partnerMinAge'];
									$partnerMaxAge = $row['partnerMaxAge'];
									$partnerCountry = $row['partnerCountry'];
									$activityDetails = $row["activityDetails"];
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
									
									if ($activityName != "Null"){
										$activity = $activityName;
									}else if ($activityType != ""){
										$activity = $activityType;
									}else{
										$activity = "any kind of activity";
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
									if ($activityDetails != "Null"){
											echo "<label class='searchresultsPageResultsBoxUserDtl'>More Details for this Search:<br>";
											echo "<span>$activityDetails</span>";			
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