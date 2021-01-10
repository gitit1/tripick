<?php							
	while($row = mysqli_fetch_assoc($resultAct)){
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
		
		$queryCountry = "SELECT * FROM countriesTable Where countryName='$countryName' LIMIT 1";
		$resultCountry = mysqli_query($conn_countries, $queryCountry);
		$row = mysqli_fetch_assoc($resultCountry);
		$flag = $row["countryInitial"];
		
		$url = 	"searchresults.php?query=newQuery
				&userName=$userName&countryName=$countryName&cityName=$cityName
				&fromDate=$fromDate&toDate=$toDate
				&partnerGender=$partnerGender&partnerMinAge=$partnerMinAge&partnerMaxAge=$partnerMaxAge
				&partnerCountry=$partnerCountry							
				&activityType=$activityType&activityName=$activityName&activityDetails=$activityDetails";	


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
					$imgSrc  = "http://graph.facebook.com/$userFbId/picture?type=large";
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

		$fromDate1 = date_format(new DateTime($fromDate), 'd/m/Y');
		$toDate1 = date_format(new DateTime($toDate), 'd/m/Y');
		$today = date("d/m/Y");
		
		if  ( ($fromDate1 == $today) && ($toDate1 == $today) ){										
			$date = "$today";
		}else{
			$date = "$fromDate1 - $toDate1";
		}
		
		$pAge = "$partnerMinAge-$partnerMaxAge";
		 
		 if($partnerCountry != 'Null'){
		 	$cty = " and from $partnerCountry";
		 }
		 																																										
		echo "<article class='searchresultsPageResultsBox  mySearchesPageRstBox'>";
			echo "<div class='searchresultsPageResultsBoxBtns mySearchesPageRstBtn'>";
				echo "<div class='mySearchesPageSeeRstBtn'><a href='$url'><img src='images/lists/seeMoreList.png' alt='See Results' title='See Results''>
				  	  </a></div></div>";
			echo "<div><img src='images/country/flags_big/" . $flag . ".png'  class='searchresultsPageResultsBoxImg mySearchesPageRstBoxImg'></div>";
			echo 	"<label class='searchresultsPageResultsBoxUserInfo mySearchesRstBoxUserInfo'><b>$countryName - $cityName</b>	
					  <br>$date</label><br>";
			echo 	"<label class='searchresultsPageResultsBoxPartnerInfo mySearchesPageRstBoxPartnerInfo'>Looking for $pSex for $activity, 
				 		the partner needs to be between the ages $pAge $cty</label><br>";
		echo "</article>";	
		
								
	}
?>