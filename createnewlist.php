<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
	include_once("includes/php_includes/myPage/myPagePhpIncludes.php"); 	
?>
<?php if($user_ok != true){header("location: notallowed.php");} ?>
<?php 
	$filter = false;
	include_once("includes/php_includes/pageReturningSections/getCityAndCountry.php");
?>
<?php
if(isset($_POST["list"])){
	$listName = $_POST['listName'];
	$countryName = $_POST['countryName'];
	$cityName = $_POST['cityName'];
	$fromDate = preg_replace('#[^a-z0-9_]#i', '', $_POST['fromDate']);
	$toDate = preg_replace('#[^a-z0-9_]#i', '', $_POST['toDate']);
	$listDesc = $_POST['listDesc'];
	
	if($countryName == "Null" || $cityName == "Null" || $listName == "Null"){
		echo "wrong_data";
		exit();
    }else{
		if ($fbId == ''){
			$fbId = 'Null';
		}
		$sql = "INSERT INTO lists (`id`, `username`, `fbId`, `listname`, `country`, `city`, `fromdate`, 
							 `todate`,`details`, `create_date`, `accepted`) 
							 VALUES (NULL, '$userName', '$fbId', '$listName', '$countryName', '$cityName', '$fromDate', '$toDate', '$listDesc', now(), '0')";
		$result = mysqli_query($conn_actlst, $sql); 					 
		$queryGetId = mysqli_insert_id($conn_actlst);	    				   
		
		if ($result){
			echo $queryGetId;
		} else {
			echo "error";		
			}		
			exit();	
		}	
		exit();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Create New List</title>
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); 
			if($mobile){
				header("location: index.php");
			}
		?>	
		<script>
		function sendQueryList(){
				var status_list = _("status_list");				
				status_list.innerHTML = "Please wait...";
				var listName = _("listName").value;
				if (listName  == "" || listName .length == 0 || listName  == null){listName  = "Null";}	
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

				var listDesc = _("listDesc").value;
											
				var ajax = ajaxObj("POST", "createnewlist.php");
		        ajax.onreadystatechange = function() {
			        if(ajaxReturn(ajax) == true) {
						if($.trim(ajax.responseText) == "wrong_data"){
							status_list.innerHTML = "The form submission is missing values.";
						}else if($.trim(ajax.responseText) == "error"){
							status_list.innerHTML = "There was an Error";							
						}else{
							window.location.href = 	"createnewlistselectact.php?listId="+ajax.responseText
							+"&ctr="+countryName+"&cty="+cityName;
						}
			        }
		        }
		        ajax.send("list=newList&listName="+listName+"&countryName="+countryName+"&cityName="+cityName
							+"&fromDate="+fromDate+"&toDate="+toDate						
							+"&listDesc="+listDesc);
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
			<h1 class="pageHeader">Create New List</h1>	
			<main>
				<nav class="breadCrums">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><img src="images/main/breadcrumsArrows.png" class="navArrows"></li>
						<li class="breadCrumsHighlight"><a href="createnewlist.php">Create New List</a></li>
					</ul>
				</nav>
			    <h1 class="pageHeader"><?php echo $myPageheader; ?></h1>					
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>
				    <div class="mapGeneralSettings mapOpacity mapFixedHeight">	 			
						<div class="listSectionNewListFirstForm">
								<form name="ListForm" method="post" onsubmit="return false;">
									<label class="listSectionNewListFormListNameLabel">List Name:<br>
										<input type="text"  id="listName" name="listName" class="chosen-text"/>
									</label>
									<label class="listSectionNewListFormListCountryLabel">Country:<br>
								    	<select id="countryName" name="countryName" onchange="fetch_select(this.value);"  class="chosen-select countryBox">
								      		<?php include("includes/php_includes/pageReturningSections/template_country_list.php"); ?>
								    	</select>						
									</label>
									<label class="listSectionNewListFormCityLabel"/>City:<br>							
										<span id="try"><?php echo $try; ?></span>
									</label>						
									<label class="listSectionNewListFormFromDateLabel">From Date:<br>
										<input type="date" id="fromDate" value="<?php echo date("Y-m-d");?>" class="chosen-date">
									</label>
									<label class="listSectionNewListFormToDateLabel">To Date:<br>
										<input type="date" id="toDate" value="<?php echo date("Y-m-d");?>" class="chosen-date">
									</label>
									<label class="listSectionNewListDescriptionlabel">Desciption:<br>								
										<textarea rows="6" cols="35" placeholder="Type Description" id="listDesc"></textarea>
									</label>
									
									<label for="listSectionNewListMainPicBtn" class="listSectionNewListMainPicBtn">
									    <i class="fa fa-cloud-upload"></i>Upload Main Pictures
									</label>
									<input id="listSectionNewListMainPicBtn" type="file" onclick="alert('Still on Development');"/>			
									
									<label for="listSectionNewListMorePicBtn" class="listSectionNewListMorePicBtn">
									    <i class="fa fa-cloud-upload"></i>Upload More Picture
									</label>
									<input id="listSectionNewListMorePicBtn" type="file" onclick="alert('Still on Development');"/>
									<span id="status_list"></span>			
									<!--<a href='#myListsCreateNewListSelectAct' onclick="sendQueryList();" class="listSectionNewListChsActBtn"><p>Select Activities</p></a>-->				
									<button class="listSectionNewListChsActBtn" onclick="sendQueryList()">Select Activities</button>
									<!--<input type="hidden" id="listId" value="<?php echo  $queryGetId; ?>" >-->
								</form>									
						</div>
					</div>
				</div>
			</main>
		</div>
	</body>
</html>