<?php
	$arr = array();
	$listNote = '';
	$id = 0;
	while($row = mysqli_fetch_assoc($result)){
		$listId = $row["id"];	
		$listMainPhoto = $row["main_photo"];
		$listUsername = $row["username"];	
		$listName = $row["listname"];
		$listFromDate = $row["fromdate"];
		$listFromDate = date_format(new DateTime($listFromDate), 'd/m/Y');
		$listToDate = $row["todate"]; 
		$listToDate = date_format(new DateTime($listToDate), 'd/m/Y');
		$listCountry = $row["country"];
		$listCity = $row["city"]; 
		
		if ($listMainPhoto == ""){
			$photoSrc = 'images/lists/listDefault.png';
		}else{
			$photoSrc = 'users/$listUsername/$listMainPhoto';
		}
			
		 
		$queryAct = "SELECT activityName FROM listActivities Where listId = '$listId' AND accepted='1' ORDER BY activityName ASC";	
	    $resultAct = mysqli_query($conn_actlst, $queryAct);
	    if(!$resultAct ) {
	        die("DB query failed.");
	    }
		//$rowAct = mysqli_fetch_array($resultAct);
		$numrows = mysqli_num_rows($resultAct);
		$sites = '';

		$storeArray = Array();
		while ($rowAct = mysqli_fetch_array($resultAct, MYSQL_ASSOC)) {
		    $storeArray[] =  $rowAct['activityName'];  
		}
		if ($numrows == 0){
			$sites = "<div class='myListsListsBoxSites'><label>No Activities</label>";
			$sites .= "<br><br><br></div>";
		}elseif ($numrows == 1){
			$actName = $storeArray[0];
			$sites = "<div class='myListsListsBoxSites'><span>$actName</span><br><br><br></div>";										
		}elseif ($numrows == 2){
			$actName = $storeArray[0];
			$actName1 = $storeArray[1];
			$sites = "<div class='myListsListsBoxSites'><label>Activities:</label>";
			$sites .= "<br><label class='myListsListsBoxSitesNum'>1. </label><span>$actName</span>";
			$sites .= "<br><label class='myListsListsBoxSitesNum'>2. </label><span>$actName1</span><br>";
			$sites .= "</div>";
		}else{
			$actName = $storeArray[0];
			$actName1 = $storeArray[1];
			$actName2 = $storeArray[2];
			$sites = "<div class='myListsListsBoxSites'><label>Activities:</label>";
			$sites .= "<br><label class='myListsListsBoxSitesNum'>1. </label><span>$actName</span>";
			$sites .= "<br><label class='myListsListsBoxSitesNum'>2. </label><span>$actName1</span>";
			$sites .= "<div><br><label class='myListsListsBoxSitesNum'>3. </label><span>$actName2</span></div>";
			$sites .= "</div>";					
		}
		//EDIT WHEN I HAVE BUTTONS:													
		$listNote =  "<article class='myListsListsBox'>";
		$listNote .= "<div class='myListsListsBoxPhoto'><img src=$photoSrc></div>";
		$listNote .= "<div class='myListsListsBoxHeader'><span>$listName</div>";
		$listNote .= "<div class='myListsListsBoxDates'><span>$listFromDate-$listToDate</span></div>";
		$listNote .= "<div class='myListsListsBoxUserName'><label>By:&nbsp;</label><span>$listUsername</span></div>";
		$listNote .= "<div class='myListsListsBoxCountry'><br><label>Country: </label><span>$listCountry</span></div>";
		$listNote .= "<div class='myListsListsBoxCity'><label>City: </label><span>$listCity</span></div>";
		$listNote .= $sites;
		$listNote .= "<br>";
		$listNote .= "<div class='myListsListsBoxButtons'>";
		//$listNote .= "<div class='myListsListsBoxBtnEdit'><a href='#'><img src='images/lists/editList.png' alt='Edit' title='Edit'></a></div>";
		$listNote .= "<div class='myListsListsBoxBtnShare'><a href='sharelist.php?id=$listId' class='iframe' onclick=\"popUpOpenIframeSwthR(350,200)\" ><img src='images/lists/shareList.png' alt='Share' title='Share'></a></div>";
		$listNote .= "<div class='myListsListsBoxBtnFull'><a href='showfulllist.php?username=$userName&fbId=$fbId&id=$listId' class='iframe' onclick=\"popUpOpenIframeSwthR(750,700)\" ><img src='images/lists/seeMoreList.png' alt='See full list' title='See full list'></a></div>"; 
		$listNote .= "</div>";
		$listNote .= "</article>";
		$id = $id + 1;
		array_push($arr,$listNote);		
	}		
?>