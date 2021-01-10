<?php
	$userName = $_GET['userName'];
	$countryName = $_GET['countryName'];
	$cityName = $_GET['cityName'];
	$fromDate = $_GET['fromDate'];
	$toDate = $_GET['toDate'];
	$partnerGender = $_GET['partnerGender'];
	$partnerAge = $_GET['partnerAge'];
	$activityType = $_GET['activityType'];
	$activityName = $_GET['activityName'];
	$activityDetails = $_GET['activityDetails'];	
	
	$today = date('YYYY/mm/dd');
	
	$age1 = "";
	if ( preg_match('/16/',$partnerAge) ){
		$age1 .= '16,17,18,19,20,';
	}
	if (preg_match('/21/',$partnerAge)){
		$age1 .= '21,22,23,24,25,26,27,28,29,30,';
	}
	if (preg_match('/31/',$partnerAge)){
		$age1 .= '31,32,33,34,35,36,37,38,39,40,';
	}
		if (preg_match('/41/',$partnerAge)){
		$age1 .= '41,42,43,44,45,46,47,48,49,50,';
	} 	

  
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
					cityName = '" . $cityName . "' AND  ";
	$ageQuery = "( ( (partnerAge LIKE '%" . $age1 . "%') AND (userAge LIKE  '%" . $Uage . "%') ) OR (partnerAge LIKE '%" . $age1 . "%') )"; //age 1	
	$dateQuery00 = "(fromDate >= '" . $fromDate . " ' AND toDate >='" . $toDate . "') AND ";
	$dateQuery01 = "(fromDate >= '" . $fromDate . " ' AND toDate =='" . $toDate . "') AND ";
	$dateQuery10 = "(fromDate == '" . $fromDate . " ' AND toDate >='" . $toDate . "') AND ";
	$dateQuery11 = "(fromDate == '" . $fromDate . " ' AND toDate =='" . $toDate . "') AND ";
	$genderQuery = "(partnerGender = '" . $partnerGender . "' AND userGender = " . $partnerGender . ") AND"; //gender = 1
	$actTypeQuery =  "activityType = '" . $activityType . "' AND "; //activity type = 1
	$actNameQuery = "activityName = '" . $activityName . "' AND ";	 //activity name = 1    
	$countryQuery = "(partnerCountry = '" . $userCountry . "') AND "; //partner country  = 1 //  //$userCountry == 'Choose Country'
	$endQuery = $ageQuery." (userName != '" . $userName. "') ORDER BY userName ASC";	

/*
 0 activityType == "All" : DO NOT PUT IN QUERY
1 activityType != "All" : activityType = '" . $activityType . "' AND
 
0 activityName == "Null" : DO NOT PUT IN QUERY
1 activityName != "Null" : activityName = '" . $activityName . "' AND
 
0 0 $fromDate == $today && $toDate == $today : (fromDate >= '" . $fromDate . " ' AND toDate >='" . $toDate . "')
0 1 $fromDate == $today && $toDate != $today : (fromDate >= '" . $fromDate . " ' AND toDate =='" . $toDate . "')
1 0 $fromDate != $today && $toDate == $today : (fromDate == '" . $fromDate . " ' AND toDate >='" . $toDate . "')
1 1 $fromDate != $today && $toDate != $today : (fromDate == '" . $fromDate . " ' AND toDate =='" . $toDate . "')

0 partnerGender == "b" : DO NOT PUT IN QUERY
1 partnerGender != "b" : (partnerGender = '" . $partnerGender . "' OR partnerGender = 'b') AND

0 partnerCountry == "Null" : DO NOT PUT IN QUERY
1 partnerCountry != "Null" : (partnerCountry = '" . $partnerCountry. "') 
 
 */

	if ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 0 0 0 0 0 - 1
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
		$query = $regularQuery . $dateQuery00 . $endQuery;
	}
	   
	elseif ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 0 0 0 0 1 - 2
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery . $dateQuery00 . $countryQuery . $endQuery;
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 0 0 0 1 0 - 3
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery00 .  $genderQuery . $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 0 0 0 1 1 - 4
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery00 . $genderQuery. $countryQuery. $endQuery;
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 0 0 1 0 0 - 5
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery00 .  $actNameQuery. $endQuery;
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 0 0 1 0 1 - 6
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery00 .  $actNameQuery . $countryQuery . $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 0 0 1 1 0 - 7
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery . $dateQuery00 . $actNameQuery .$genderQuery . $endQuery;
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 0 0 1 1 1 - 8
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery . $dateQuery00 . $actNameQuery .$genderQuery . $countryQuery . $endQuery;
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate != $today) //0 0 1 0 0 0 - 9
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $endQuery;	
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate != $today) //0 0 1 0 0 1 - 10
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
		$query = $regularQuery .$dateQuery01 . $countryQuery  . $endQuery;	   	
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate != $today) //0 0 1 0 1 0 - 11
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $genderQuery.  $endQuery;	
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate != $today) //0 0 1 0 1 1 - 12
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $genderQuery.$countryQuery . $endQuery;	
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate != $today) //0 0 1 1 0 0 - 13
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $actNameQuery . $endQuery;
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 0 1 1 0 1 - 14
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $actNameQuery. $countryQuery . $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 0 1 1 1 0 - 15
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $actNameQuery. $genderQuery . $endQuery;
	}
	   
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 0 1 1 1 1 - 16
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery01 . $actNameQuery. $genderQuery . $countryQuery  . $endQuery;	
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 1 0 0 0 0 - 17
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
		$query = $regularQuery .$dateQuery10 . $endQuery;	   	
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 1 0 0 0 1 - 18
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $countryQuery . $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 1 0 0 1 0 - 19
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $genderQuery . $endQuery;	
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 1 0 0 1 1 - 20
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $genderQuery. $countryQuery . $endQuery ;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 1 0 1 0 0 - 21
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $actNameQuery. $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 1 0 1 0 1 - 22
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $actNameQuery. $countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 1 0 1 1 0 - 23
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $actNameQuery. $genderQuery . $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate == $today) //0 1 0 1 1 1 - 24
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery10 . $actNameQuery. $genderQuery . $countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate != $today) //0 1 1 0 0 0 - 25
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery11. $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate != $today) //0 1 1 0 0 1 - 26
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery11.$countryQuery. $endQuery;
	}
	   
	   
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate != $today) //0 1 1 0 1 0 - 27
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery11.$genderQuery. $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate != $today) //0 1 1 0 1 1 - 28
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery11.$genderQuery. $countryQuery.$endQuery;	
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate != $today) //0 1 1 1 0 0 - 29
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	    $query = $regularQuery .$dateQuery11.$actNameQuery. $endQuery;	
	}
	
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //0 1 1 1 0 1 - 30
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery11.$actNameQuery.$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate != $today) //0 1 1 1 1 0 - 31
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$dateQuery11.$actNameQuery.$genderQuery. $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate != $today) && ($toDate != $today) //0 1 1 1 1 1 - 32
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$dateQuery11.$actNameQuery.$genderQuery.$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate == $today) //1 0 0 0 0 0 - 33
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery .$dateQuery00 . $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate == $today) //1 0 0 0 0 1 - 34
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery .$dateQuery00 .$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate == $today) //1 0 0 0 1 0 - 35
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery .$dateQuery00 .$genderQuery . $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate == $today) //1 0 0 0 1 1 - 36
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery00 .$genderQuery .$countryQuery + $endQuery;
	}

	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate == $today) //1 0 0 1 0 0 - 37
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery00 .$actNameQuery . $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate == $today) //1 0 0 1 0 1 - 38
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery00 .$actNameQuery . $countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate == $today) //1 0 0 1 1 0 - 39
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery00 .$actNameQuery .$genderQuery . $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate == $today) //1 0 0 1 1 1 - 40
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
		$query = $regularQuery .$actTypeQuery.$dateQuery00 .$actNameQuery .$genderQuery . $countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate != $today) //1 0 1 0 0 0 - 41
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery01. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate != $today) //1 0 1 0 0 1 - 42
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery01. $countryQuery .  $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate != $today) //1 0 1 0 1 0 - 43
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery01.$genderQuery .  $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate != $today) //1 0 1 0 1 1 - 44
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery.$dateQuery01.$genderQuery. $countryQuery .  $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate != $today) //1 0 1 1 0 0 - 45
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery01. $actNameQuery.  $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate != $today) //1 0 1 1 0 1 - 46
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery01. $actNameQuery. $countryQuery . $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate != $today) //1 0 1 1 1 0 - 47
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   		$query = $regularQuery .$actTypeQuery. $dateQuery01. $actNameQuery. $genderQuery . $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate == $today) && ($toDate != $today) //1 0 1 1 1 1 - 48
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery01. $actNameQuery. $genderQuery. $countryQuery . $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate == $today) //1 1 0 0 0 0 - 49
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate == $today) //1 1 0 0 0 1 - 50
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   		$query = $regularQuery .$actTypeQuery. $dateQuery10. $countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate == $today) //1 1 0 0 1 0 - 51
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $genderQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate == $today) //1 1 0 0 1 1 - 52
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $genderQuery.$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate == $today) //1 1 0 1 0 0 - 53
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $actNameQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate == $today) //1 1 0 1 0 1 - 54
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $actNameQuery.$countryQuery .$endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate == $today) //1 1 0 1 1 0 - 55
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery10. $actNameQuery.$genderQuery .$endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate == $today) //1 1 0 1 1 1 - 56
	   && ($activityName != "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
		$query = $regularQuery .$actTypeQuery. $dateQuery10. $actNameQuery.$countryQuery.$genderQuery .$endQuery;   	
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate != $today) //1 1 1 0 0 0 - 57
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery11. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate != $today) //1 1 1 0 0 1 - 58
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   		$query = $regularQuery .$actTypeQuery. $dateQuery11.$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate != $today) //1 1 1 0 1 0 - 59
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery11.$genderQuery.$endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate != $today) //1 1 1 0 1 1- 60
	   && ($activityName == "Null") && ($partnerGender != "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery .$actTypeQuery. $dateQuery11. $genderQuery.$countryQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate != $today) //1 1 1 1 0 0- 61
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   	$query = $regularQuery. $dateQuery11 .$actTypeQuery. $actNameQuery. $endQuery;
	}
	
	elseif  ( ($activityType != "All") && ($fromDate != $today) && ($toDate != $today) //1 1 1 1 0 1- 62
	   && ($activityName != "Null") && ($partnerGender == "b")  && ($partnerCountry != "Null") ){
	   	$query = $regularQuery. $dateQuery11 .$actTypeQuery. $actNameQuery.$countryQuery . $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //1 1 1 1 1 0- 63
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
	   		$query = $regularQuery. $dateQuery11 .$actTypeQuery. $actNameQuery.$countryQuery . $endQuery;
	}
	
	elseif  ( ($activityType == "All") && ($fromDate == $today) && ($toDate == $today) //1 1 1 1 1 1- 64
	   && ($activityName == "Null") && ($partnerGender == "b")  && ($partnerCountry == "Null") ){
		$query = $regularQuery. $dateQuery11 .$actTypeQuery. $actNameQuery.$genderQuery.$countryQuery . $endQuery;
	} 

$test = "<h1>this is a test</h1>";
?>