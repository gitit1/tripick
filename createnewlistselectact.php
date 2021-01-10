
<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
	include_once("includes/php_includes/myPage/myPagePhpIncludes.php"); 	
?>
<?php
	if($user_ok != true){
		header("location: notallowed.php");
	}
?>
<?php
$listId = $_GET['listId'];
$country = $_GET['ctr'];
$city = $_GET['cty'];
 
$query = "SELECT * FROM activities Where countryName = '$country' AND cityName='$city' ORDER BY activityName ASC";	
$result = mysqli_query($conn_actlst, $query);
if(!$result) {
    die("DB query failed.");
}
?>
<?php 
	$arr = array();
	$note = '';
	while($row = mysqli_fetch_assoc($result)){
	$logo = $row["logo"];
	$actId = $row["id"];
	$actName = $row["activityName"];
	
	$note =  "<article class='createListSelectActBoxes'>";
	$note .=  "<a href='createnewlistselectactPopUp.php?listId=$listId&actId=$actId' onclick=\"popUpOpenIframeS(700,500)\" class=\"iframe createListSelectActLink\">";		
	$note .= "<img src='images/activities/logos/$logo' class='createListSelectActImg' alt='$actName'>";
	$note .= "<span class='createListSelectActSpan'>$actName</span>";
	$note .=  "<div  class='createListSelectActSelect' >
				<input type='checkbox' id='list_box_$actId' value='$actId'><label>Add Activity
				</label></div>";
	$note .=  "</a>";
	$note .= "</article>";
	
	array_push($arr,$note);
	}	
?>
<?php
if(isset($_POST["cList"])){
	$listId = $_POST['listId'];
	$actId = $_POST['actId'];


	$update_activities = mysqli_query($conn_actlst, "UPDATE listActivities SET accepted='1' WHERE listId='$listId'");
	$count_activities = mysqli_query($conn_actlst, "SELECT COUNT(id) AS total FROM listActivities WHERE listId='$listId'");
	$count = mysqli_fetch_assoc($count_activities);
	$total = $count['total'];
	$update_list = mysqli_query($conn_actlst, "UPDATE lists SET accepted='1' , numofact = '$total' , create_date =now() WHERE id='$listId' LIMIT 1"); 
	
	if ($update_activities && $count_activities && $update_list){
		echo "query_success";					
	} else {
		echo "There WAS an Error";
	}
	
	exit();

}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Create New List</title>
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?>		   		
	<script>
		function sendQueryCreateList(){
				var status_cList = _("status_cList");				
				status_cList.innerHTML = "Please wait...";
				var userName = _("userName").value;
				var listId = _("listId").value;
				var actId = _("actId").value;
				 _("createNewListActPopUpActBtn").style.display == "none"
				var ajax = ajaxObj("POST", "createnewlistselectact.php");
		        ajax.onreadystatechange = function() {
			        if(ajaxReturn(ajax) == true) {
						if($.trim(ajax.responseText) != "query_success"){
							status_cList.innerHTML = "Error";
							_("createNewListActPopUpActBtn").style.display == "block"
						} else {
							window.location.href = "http://tripick.net/mypage.php?id=lists&u="+userName;
						}
			        }
		        }
		        ajax.send("cList=newList"+"&listId="+listId+"&actId="+actId);	
	       }	      		
		</script>		
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
						<li><a href="createnewlist.php">Create New List</a></li>
						<li><img src="images/main/breadcrumsArrows.png" class="navArrows"></li>
						<li class="breadCrumsHighlight"><a href="createnewlistselectact.php">Choose Sights/Activities</a></li>
					</ul>
				</nav>
			    <h1 class="pageHeader">Choose Sights/Activities</h1>					
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>
				    <div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">	 			
						<div class="createListSelectActBox">												
							<?php
								$offset = (int) (isset($_GET['offset']) ? $_GET['offset'] : 0);
								$limit = 15;
								
								$arrayIterator = new ArrayIterator($arr);
								$limitIterator = new LimitIterator($arrayIterator, $offset, $limit);
								
								$n = 0;
								foreach ($limitIterator as $node) {
								    $n++;
									echo $node;
								}
								$back = $offset - 15;
								$next = $offset + 15;
								if (  $back >= 0 ) {
									echo "<a href='createnewlistselectact.php?listId=$listId&ctr=$country&cty=$city
									&offset=$back'><img src='images/back.png' class='generalBackButton generalBackButton_createnewlist'></a>";
								}									
								if ( $next < (sizeof($arrayIterator))  ) {	
									echo "<a href='createnewlistselectact.php?listId=$listId&ctr=$country&cty=$city
									&offset=$next'><img src='images/next.png' class='generalNextButton generalNextButton_createnewlist'></a>";
								}					    
							?>									
						</div>
						<div>
							<form class='createListForm' name="slcActForm" method="post" onsubmit="return false;">
								<button id="createNewListActPopUpActBtn" class="createNewListActPopUpActBtn3" onclick="sendQueryCreateList()">Create List</button>
								<input type="hidden" id="userName" value="<?php echo  $userName ; ?>" >
								<input type="hidden" id="actId" value="<?php echo  $actId ; ?>" >
								<input type="hidden" id="listId" value=" <?php echo  $listId ; ?>" ?>
								<span id="status_cList"></span>
							</form>		
						</div>			
					</div>
				</div>
			</main>
		</div>
	</body>
</html>
<?php
$queryLstAct = "SELECT * FROM listActivities Where listId = '$listId'";	
$resultLstAct = mysqli_query($conn_actlst, $queryLstAct);
if(!$result) {
    die("DB query failed.");
}
while($row = mysqli_fetch_assoc($resultLstAct)){
	$act_id = $row["activityId"];
	echo "<script>document.getElementById(\"list_box_$act_id\").checked = true;</script>";
}
?>	