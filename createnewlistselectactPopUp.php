<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
?>
<?php
	if($user_ok != true){
		header("location: notallowed.php");
	}
?>
<?php
$listId = $_GET['listId'];
$actId = $_GET['actId'];


$query = "SELECT * FROM activities Where id='$actId' ORDER BY activityName ASC";	
$result = mysqli_query($conn_actlst, $query);
if(!$result) {
    die("DB query failed.");
}

$row = mysqli_fetch_assoc($result);
	$logo = $row["logo"];
	$discription = $row["description"];
	$activityName = $row['activityNameShort'];
	$activityType = $row['activityType'];
?>
<?php
if(isset($_POST["act"])){
	$listId = $_POST['listId'];
	$actId = $_POST['actId'];
	$logo = $_POST["logo"];
	$activityLogo = $_POST["activityLogo"];
	$activityDiscription= $_POST["description"];
	$activityName = $_POST['activityName'];
	$activityType = $_POST['activityType'];		
		
	$fromDate = preg_replace('#[^a-z0-9_]#i', '', $_POST['fromDate']);
	$toDate = preg_replace('#[^a-z0-9_]#i', '', $_POST['toDate']);
	$listDesc = $_POST['listDesc'];

	if($countryName == "Select Country" || $cityName == "Select City" || $activityType == "Select Activity"){
		echo "The form submission is missing values.";
        exit();
    } else {
		$sql = "INSERT INTO listActivities (id, listId, activityId, activityName, activityType, 
				fromdate, todate, details, create_date, mainphoto, accepted) 
				VALUES (NULL, '$listId', '$actId', '$activityName', '$activityType'
				, '$fromDate', '$toDate', '$listDesc', now(), '$activityLogo', '0')";
				$query = mysqli_query($conn_actlst, $sql); 
		
		//$uid = mysqli_insert_id($conn_query);
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
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?>	
		<script>

		function sendQueryAct(){
				var status_Act = _("status_Act");				
				status_Act.innerHTML = "Please wait...";
				var listId = _("listId").value;
				var actId = _("actId").value;
				var activityName = _("activityName").value;
				var activityType = _("activityType").value; 
				var activityDiscription = _("activityDiscription").value;
				var activityLogo = _("activityLogo").value;
				
				var fromDate = _("fromDate").value;
				if (!fromDate){
					fromDate = new Date().toJSON().slice(0,10)
				}
				var toDate = _("toDate").value;
				if (!toDate){
					toDate = new Date().toJSON().slice(0,10)
				}				

				var listDesc = _("listDesc").value;
									
				var ajax = ajaxObj("POST", "createnewlistselectactPopUp.php");
		        ajax.onreadystatechange = function() {
			        if(ajaxReturn(ajax) == true) {
						if($.trim(ajax.responseText) != "query_success"){
							status_Act.innerHTML = $.trim(ajax.responseText);
						} else {
							parent.jQuery.colorbox.close();
						}
			        }
		        }
		        ajax.send("act=newAct"+"&listId="+listId+"&actId="+actId
		        +"&activityName="+activityName+"&activityType="+activityType
		        +"&activityDiscription="+activityDiscription
		        +"&activityLogo="+activityLogo
		        +"&fromDate="+fromDate+"&toDate="+toDate+"&listDesc="+listDesc);	
	       }	      		
		</script>
   <script>
	    // rating script
	    $(function(){ 
	        $('.rate-btn').hover(function(){
	            $('.rate-btn').removeClass('rate-btn-hover');
	            var therate = $(this).attr('id');
	            for (var i = therate; i >= 0; i--) {
	                $('.rate-btn-'+i).addClass('rate-btn-hover');
	            };
	        });
	                        
	        $('.rate-btn').click(function(){    
	            var therate = $(this).attr('id');
	            var dataRate = 'act=rate&post_id=<?php echo $actId; ?>&rate='+therate; 
	            $('.rate-btn').removeClass('rate-btn-active');
	            for (var i = therate; i >= 0; i--) {
	                $('.rate-btn-'+i).addClass('rate-btn-active');
	            };
	            $.ajax({
	                type : "POST",
	                url : "includes/php_includes/myPage/ajax.php",
	                data: dataRate,
	                success:function(){}
	            });
	            
	        });
	    });
	</script>
	</head>
	<body>
		<div class="createNewListActPopUpContent">
			<div class='createNewListActPopUpInfoBox'>
				<img src='images/activities/logos/<?php echo  $logo; ?>' class='createNewListActPopUpInfoBoxLogo' alt='<?php echo $activityName; ?>'>
				<span class='createNewListActPopUpInfoBoxName'><?php echo  $activityName; ?></span>
				<p class='createNewListActPopUpInfoDesc'><?php echo  $discription; ?> </p>
			</div>
			<form class='csActForm' name="slcActForm" method="post" onsubmit="return false;">
				
				<label class="listSectionNewListFormFromDateLabel createNewListActPopUpFormFromDateLabel">From Date:
					<input type="date" id="fromDate" value="<?php echo date("Y-m-d");?>" class="chosen-date"/>
				
				<label class="listSectionNewListFormToDateLabel createNewListActPopUpFormFromToLabel">To Date:
					<input type="date" id="toDate" value="<?php echo date("Y-m-d");?>" class="chosen-date"/>
				</label>
				
				<label class="listSectionNewListDescriptionlabel createNewListActPopUpFormDescLabel">Desciption:								
					<textarea rows="6" cols="35" placeholder="Type Description" id="listDesc"></textarea>
				</label>
				
				<label for="listSectionNewListMorePicBtn2" class="listSectionNewListMorePicBtn2">
				    <i class="fa fa-cloud-upload"></i>Upload More Picture
				</label>
				<input id="listSectionNewListMorePicBtn2" type="file"/>								
				
				<input type="hidden" id="actId" value="<?php echo  $actId ; ?>" >
				<input type="hidden" id="listId" value=" <?php echo  $listId ; ?>" ?>
				<input type="hidden" id="activityName" value=" <?php echo  $activityName; ?>" ?>
				<input type="hidden" id="activityType" value=" <?php echo  $activityType ; ?>" ?>
				<input type="hidden" id="activityLogo" value=" <?php echo  $logo ; ?>" ?>
				<input type="hidden" id="activityDiscription" value=" <?php echo  $discription ; ?>" ?>
				<span id="status_Act"></span>	
				
				<button class="createNewListActPopUpActBtn2" onclick="sendQueryAct()">Done</button>
			</form>	
			<div class="rate-ex2-cnt">
			    <div id="1" class="rate-btn-1 rate-btn"></div>
			    <div id="2" class="rate-btn-2 rate-btn"></div>
			    <div id="3" class="rate-btn-3 rate-btn"></div>
			    <div id="4" class="rate-btn-4 rate-btn"></div>
			    <div id="5" class="rate-btn-5 rate-btn"></div>
			</div>
	        <div class="box-result-cnt">
	            <?php
	
	                $query1 = "SELECT * FROM wcd_rate WHERE id_post='$actId'";
					$result1 = mysqli_query($conn_actlst, $query);
	                while($data = mysqli_fetch_assoc($result1)){
	                    $rate_db[] = $data;
	                    $sum_rates[] = $data['rate'];
	                }
	                if(@count($rate_db)){
	                    $rate_times = count($rate_db);
	                    $sum_rates = array_sum($sum_rates);
	                    $rate_value = $sum_rates/$rate_times;
	                    $rate_bg = (($rate_value)/5)*100;
	                }else{
	                    $rate_times = 0;
	                    $rate_value = 0;
	                    $rate_bg = 0;
	                }
	            ?>
	            <p>This Activity was rated <strong><?php echo $rate_times; ?></strong> times.</h3>
	            The rating is at <strong><?php echo $rate_value; ?></strong></p>
	            <div class="rate-result-cnt">
	                <div class="rate-bg" style="width:<?php echo $rate_bg; ?>%"></div>
	                <div class="rate-stars"></div>
	            </div>
	
	        </div><!-- /rate-result-cnt -->
	 	</div>            		
	</body>
</html>