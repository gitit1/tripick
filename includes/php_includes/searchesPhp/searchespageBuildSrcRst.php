<?php							
    if ($mobile){
    	$popUpMsg = 'popUpOpenIframe(900,800)';
    }else{
    	$popUpMsg = 'popUpOpenIframe(500,400)';
    }
	while($row = mysqli_fetch_assoc($resultBuild )){
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
		 																																										
		echo "<article class='searchresultsPageResultsBox searchesPageRstBoxBuild'>";

		echo "<div class='searchresultsPageResultsBoxBtns searchesPageRstBtnBuild'>";
		echo "<div class='searchresultsPageResultsBoxSendMessage searchesPageSndMsgBuild'>
				<a href='template_pm.php?u=" . $userName . "' onclick='$popUpMsg' class='iframe' >
				<img src='images/message.png'></a>
			   </div>";
		echo "<div class='searchresultsPageResultsBoxViewProfile searchesPageRstBoxViewPrfBuild'>
		 		<a href='mypage.php?id=profile&u=" . $userName . "''>
		 		<img src='images/viewProfile.png'></a>
		 	  </div>";
		echo "</div>";									
		
		echo	"<img  class='searchresultsPageResultsBoxImg searchesPageRstBoxImgBuild' src='". $imgSrc . "'>";	
		echo 	"<label class='searchresultsPageResultsBoxUserInfo searchesPageRstBoxUserInfoBuild'><b>$userName</b>	
					    is $userAge years old $uSex $uCountry</label><br>";
		echo 	"<label class='searchresultsPageResultsBoxPartnerInfo searchesPageRstBoxPartnerInfoBuild'>$userName is looking for $pSex $date.<br> 
				 the partner needs to be between the ages $pAge $cty</label><br>";
		echo "</article>";										
	}
?>