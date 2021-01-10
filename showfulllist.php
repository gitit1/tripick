<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
	$noBtnMobile = False; 
?>
<?php	
	$listId = $_GET['id'];	
    //get data from DB	
    $queryLists = "SELECT * FROM lists Where id = '$listId'";	
    $resultLists = mysqli_query($conn_actlst, $queryLists);
    if(!$resultLists) {
        die("DB query failed.");
    }

	while($row = mysqli_fetch_assoc($resultLists)){
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
		$details = $row["details"];
		
		if ($listMainPhoto == ""){
			$photoSrc = 'images/lists/listDefault.png';
		}else{
			$photoSrc = 'users/$listUsername/$listMainPhoto';
		}
																
		$listNote = "<div class='viewFullListBoxPhoto'><img src=$photoSrc></div>";
		$listNote .= "<div class='viewFullListBoxHeader'><span>$listName</div>";
		$listNote .= "<div class='viewFullListBoxDates'><span>$listFromDate-$listToDate</span></div>";
		$listNote .= "<div class='viewFullListBoxUserName'><label>By:&nbsp;</label><span>$listUsername</span></div>";
		$listNote .= "<div class='viewFullListBoxCountry'><br><label>Country: </label><span>$listCountry</span></div>";
		$listNote .= "<div class='viewFullListBoxCity'><label>City: </label><span>$listCity</span></div>";		
		$listNote .= "<div class='viewFullListBoxDtl'><label>Details: </label><span>$details</span></div>";	
		
	}
	
	$queryAct = "SELECT * FROM listActivities Where listId = '$listId' AND accepted='1' ORDER BY activityName ASC";	
	$resultAct = mysqli_query($conn_actlst, $queryAct);
	if(!$resultAct ) {
	    die("DB query failed.");
	}	
			                         	
?>	
<!DOCTYPE html>
<html>
	<head>
		<title>List</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?> 
		<script>
			function getActId(val) {
			  var elems = document.getElementsByClassName("showFullListLightBoxDisable");
			  for (i = 0; i < elems.length; i++) {
			    elems[i].style.display = 'none';
			  }
				document.getElementById('showFullListLightBoxDivHeaderLists').style.display='none';
				var res = val.split("href");							  
				document.getElementById(res[1]).style.display='block';
			}
			function getFirstActId(val) {
			  var elems = document.getElementsByClassName("showFullListLightBoxDisable");
			  for (i = 0; i < elems.length; i++) {
			    elems[i].style.display = 'none';
			  }
				document.getElementById('showFullListLightBoxDivHeaderLists').style.display='block';
			}							
		</script>
	    <meta property="og:url"           content="<?php echo $_SERVER['REQUEST_URI'] ?>" />
	    <meta property="og:type"          content="website" />
	    <meta property="og:title"         content="TriPick" />
	    <meta property="og:description"   content="Choose the Country -> Pick a Partner -> Share your Trip" />
	    <meta property="og:image"         content="http://tripick.net/index.php" />		
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
	            var dataRate = 'list=rate&post_id=<?php echo $listId; ?>&rate='+therate; 
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
    <div id="fb-root"></div>
	<script type="text/javascript">
	    (function(d, s, id){
	        var js, fjs = d.getElementsByTagName(s)[0];
	        if (d.getElementById(id)) {return;}
	        js = d.createElement(s); js.id = id;
	        js.src = "https://connect.facebook.net/en_US/sdk.js#version=v2.2&appId=768628683249593&status=true&cookie=true&xfbml=true";
	        fjs.parentNode.insertBefore(js, fjs);
	    }(document, 'script', 'facebook-jssdk'));
	</script>		
		<div class="showFullListLightBoxWrapper" id='inline_content_Lists'>		
			<div class="showFullListLightBoxDivL">															
				<?php
					$rows = array();
					echo "<ul>";
					echo "<li><a href='#' onclick=\"getFirstActId(this.id)\">Full List Info</a></li>";																																
				    while ($row1 = mysqli_fetch_assoc($resultAct)){
				    	$rows[] = $row1;	
				    	$activityName = $row1['activityName'];
						$activityType = $row1['activityType'];						
						$cityName = preg_replace('#[^a-z ]#i', '', $row1['activityName']);
				        echo "<li><a href='#' id='hrefactId" . $row1['id'] . "' onclick=\"getActId(this.id)\">$activityName</a></li>";																		
			    	}
					echo "</ul>";
				?>
			</div>
			
			<div class="showFullListLightBoxDivR">
				<?php
				foreach($rows as $row2){
					$activityName = $row2['activityName'];
					$activityType = $row2['activityType'];
					$fromdate = $row2['fromdate'];
					$todate = $row2['todate'];
					$actId = $row2['id'];
					$details = $row2['details'];
					if ($todate == $fromdate){
						$dates = "$fromdate";
					}else{
						$dates = "$fromdate - $todate";
					}
		    		echo "<div id='actId$actId' class='showFullListLightBoxDisable'>";
		    		echo "<span class= 'dates'><h1>$dates</h1></span>";
		    		echo "<span class= 'showFullListLightBoxActName'>$activityName</span>";
					echo "<span class= 'showFullListLightBoxActType'>$activityType</span>";
					echo "<span class= 'showFullListLightBoxActDts'>$details</span>";
		    		//if ($row2['pic'] != ""){
		    		//echo "<span><img src='images/country/citiesPics/" . $row2['countryInitial'] . "_" . $row2['pic']  .    "_1.png' class='citiesImagesLists'></span>";
		    		//echo "<span><img src='images/country/citiesPics/" . $row2['countryInitial'] . "_" . $row2['pic']  .    "_2.png' class='citiesImagesLists'></span>";
		    		//echo "<span><img src='images/country/citiesPics/" . $row2['countryInitial'] . "_" . $row2['pic']  .    "_3.png' class='citiesImagesLists'></span>";
		    		//}
		    		echo "</div>";
				}													
				?>
				<div id="showFullListLightBoxDivHeaderLists">
					<?php echo $listNote; ?>
				    <div class="fb-like fb-like1" 
				        data-href="<?php echo $_SERVER['REQUEST_URI'] ?>"  
				        data-layout="button_count" 
				        data-action="like" 
				        data-show-faces="false">
				    </div>
		            <?php
		
		                $query1 = "SELECT * FROM wcd_rate_lists WHERE id_post='$listId'";
						$result1 = mysqli_query($conn_actlst, $query1);
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
						 
						if ( ($rate_value > 0) && ($rate_value <= 1) ){
							$ratebtn1 = "rate-btn-hover";
						}else{
							$ratebtn1 = "";
						}
						
						if ( ($rate_value > 1) && ($rate_value <= 2) ){
							$ratebtn1 = "rate-btn-hover";	
							$ratebtn2 = "rate-btn-hover";
						}else{
							$ratebtn2 = "";
						}
						
						if ( ($rate_value > 2) && ($rate_value <= 3) ){
							$ratebtn1 = "rate-btn-hover";	
							$ratebtn2 = "rate-btn-hover";
							$ratebtn3 = "rate-btn-hover";
						}else{
							$ratebtn3 = "";
						}								
		
						if ( ($rate_value > 3) && ($rate_value <= 4) ){
							$ratebtn1 = "rate-btn-hover";	
							$ratebtn2 = "rate-btn-hover";
							$ratebtn3 = "rate-btn-hover";
							$ratebtn4 = "rate-btn-hover";
						}else{
							$ratebtn4 = "";
						}
						
						if ( ($rate_value > 4) && ($rate_value <= 5) ){
							$ratebtn1 = "rate-btn-hover";	
							$ratebtn2 = "rate-btn-hover";
							$ratebtn3 = "rate-btn-hover";
							$ratebtn4 = "rate-btn-hover";
							$ratebtn5 = "rate-btn-hover";
						}else{
							$ratebtn5 = "";
						}								
		            ?>		    		
					<div class="rate-ex2-cnt rate-ex2-cnt-lst">
					    <div id="1" class="rate-btn-1 rate-btn <?php echo $ratebtn1 ?>"></div>
					    <div id="2" class="rate-btn-2 rate-btn <?php echo $ratebtn2 ?>"></div>
					    <div id="3" class="rate-btn-3 rate-btn <?php echo $ratebtn3 ?>"></div>
					    <div id="4" class="rate-btn-4 rate-btn <?php echo $ratebtn4 ?>"></div>
					    <div id="5" class="rate-btn-5 rate-btn <?php echo $ratebtn5 ?>"></div>
					</div>
			        <div class="box-result-cnt box-result-cnt-lst">
			            <p>This Activity was rated <strong><?php echo $rate_times; ?></strong> times.</h3>
			            The rating is at <strong><?php echo $rate_value; ?></strong></p>
			            <div class="rate-result-cnt">
			                <div class="rate-bg" style="width:<?php echo $rate_bg; ?>%"></div>
			                <div class="rate-stars"></div>
			            </div>
			
			        </div><!-- /rate-result-cnt -->					
				</div>
				<div class="clear"></div>
			</div>	
		</div>
	</body>
</html>