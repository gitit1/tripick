<?php							
    if ($mobile){
    	$popUpMsg = 'popUpOpenIframe(900,800)';
    }else{
    	$popUpMsg = 'popUpOpenIframe(500,400)';
    }	
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
		 																																										
		echo "<article class='searchresultsPageResultsBox searchesPageRstBox'>";

		echo "<div class='searchresultsPageResultsBoxBtns searchesPageRstBtn'>";
		echo "<div class='searchresultsPageResultsBoxSendMessage searchesPageSndMsg'>
				<a href='template_pm.php?u=" . $userName . "' onclick='$popUpMsg' class='iframe' >
				<img src='images/message.png'></a>
			   </div>";
		echo "<div class='searchresultsPageResultsBoxViewProfile searchesPageRstBoxViewPrf'>
		 		<a href='mypage.php?id=profile&u=" . $userName . "''>
		 		<img src='images/viewProfile.png'></a>
		 	  </div>";
		echo "</div>";									
		
		echo	"<img  class='searchresultsPageResultsBoxImg searchesPageRstBoxImg' src='". $imgSrc . "'>";	
		echo 	"<label class='searchresultsPageResultsBoxUserInfo searchesPageRstBoxUserInfo'><b>$userName</b>	
					    is $userAge years old $uSex $uCountry</label><br>";
		echo 	"<label class='searchresultsPageResultsBoxPartnerInfo searchesPageRstBoxPartnerInfo'>$userName is looking for $pSex for $activity $date.<br> 
				 the partner needs to be between the ages $pAge $cty</label><br>";
		echo "</article>";										
	}
?>