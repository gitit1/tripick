<?php 	
    $query = "SELECT * FROM lists Where username = '$userName' And accepted = '1' ORDER BY fromdate ASC";
    $result = mysqli_query($conn_actlst, $query);
    if(!$result) {
        die("DB query failed.");
    }	
?>
<script>
	function createListBtn(){
		var ListsBoxes = document.getElementById('myListsFirstPage');
		var newList = document.getElementById('myListsCreateNewListForm');
		var createListBtn = document.getElementById('myListsCreateNewListLink');
		createListBtn.style.display = 'none';
		ListsBoxes.style.display = 'none';
		newList.style.display = 'block';		
	}
	function selectActBtn(){
		var ListsBoxes = document.getElementById('myListsFirstPage');
		var newList = document.getElementById('myListsCreateNewListForm');
		var selectAct = document.getElementById('myListsCreateNewListSelectAct');		
		ListsBoxes.style.display = 'none';
		newList.style.display = 'none';	
		selectAct.style.display = 'block';	
	}		
</script>
<div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">
	<div>
		<!--<a href='../../../createnewlist.php' onclick="popUpOpenIframe(700,600)" class='iframe' >Send Message</a>-->
		<div id="myListsFirstPage">
			<!--<h2 class="myListsHeader">My Lists:</h2>-->
			<!--<a id='myListsCreateNewListLink' href='#myListsCreateNewListForm' onclick="createListBtn();">-->
				<a id='myListsCreateNewListLink' href='createnewlist.php' >
				<img src="images/lists/newList.png"></a>	
			<div class='filter box'></div>
			<div id='myListsListsBoxesWrap'>
			<div id='myListsListsBoxes'> <!--friendsSectionSeeMyFriendsBox-->
				<?php
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
						echo "<article class='myListsListsBox'>";
						echo "<div class='myListsListsBoxPhoto'><img src=$photoSrc></div>";
						echo "<div class='myListsListsBoxHeader'><span>$listName</div>";
						echo "<div class='myListsListsBoxDates'><span>$listFromDate-$listToDate</span></div>";
						echo "<div class='myListsListsBoxUserName'><label>By </label><span>$listUsername</span></div>";
						echo "<div class='myListsListsBoxCountry'><br><label>Country: </label><span>$listCountry</span></div>";
						echo "<div class='myListsListsBoxCity'><label>City: </label><span>$listCity</span></div>";
						echo $sites;
						echo "<br>";
						echo "<div class='myListsListsBoxButtons'>";
						echo "<a href='#' onclick=\"alert('Still on Development');\" class='myListsListsBoxBtnEdit'><img src='images/lists/editList.png' alt='edit' title='edit'></a>";
						echo "<a href='#' onclick=\"alert('Still on Development');\" class='myListsListsBoxBtnShare'><img src='images/lists/shareList.png' alt='share' title='share'></a>";
						echo "<a href='#' onclick=\"alert('Still on Development');\" class='myListsListsBoxBtnDelete'><img src='images/lists/deleteList.png' alt='delete' title='delete'></a>";
						echo "<div class='myListsListsBoxBtnFull'>
								<a href='#'  onclick=\"alert('Still on Development');\"><img src='images/lists/seeMoreList.png' alt='See full list'>
							  </a></div>"; 
						echo "</div>";
						echo "</article>";
					}		
				?>			
			</div><!--myListsListsBoxes-->
			</div>
		</div>
	
		<!--<div id="myListsCreateNewListForm"><?php include("includes/php_includes/myPage/createnewlist.php"); ?></div>-->
		<!--<div id"myListsCreateNewListSelectAct"><?php include("includes/php_includes/myPage/createnewlistselectact.php"); ?></div>-->
	</div>
</div>





