<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
?>
<?php
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
	$countryName =  preg_replace('#[^a-z]#i', '', $row['countryName']);	
	$cityName =  $row['cityName'];
	$adress =  $row['address'];
	$map =  $row['map'];
	
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); 
			if($mobile){
				header("location: index.php");
			}
		?>
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
		
		<div class="actPagePopUpContent">
			<div class='actPagePopUpInfoBox'>
				<img src='images/activities/logos/<?php echo  $logo; ?>' class='actPagePopUpLogo' alt='<?php echo $activityName; ?>'>
				<span class='actPagePopUpInfoBoxName'><?php echo  $activityName; ?></span>
				<label class='actPagePopUpInfoActType'><?php echo  $activityType ; ?> </label>
				<label class='actPagePopUpInfoActCnt'><?php echo  $countryName; ?> </label>
				<label class='actPagePopUpInfoActCty'><?php echo  $cityName; ?> </label>
				<label class='actPagePopUpInfoActAdress'><?php echo  $adress ; ?> </label>
				<label class='actPagePopUpInfoActMap'><a href='<?php echo  $map; ?>'   target="_blank">(Show On Map)</a></label>
				<p class='actPagePopUpInfoDesc'><?php echo  $discription; ?> </p>
			</div>
		    <div class="fb-like" 
		        data-href="<?php echo $_SERVER['REQUEST_URI'] ?>"  
		        data-layout="button_count" 
		        data-action="like" 
		        data-show-faces="false">
		    </div>
            <?php

                $query1 = "SELECT * FROM wcd_rate WHERE id_post='$actId'";
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
			<div class="rate-ex2-cnt">
			    <div id="1" class="rate-btn-1 rate-btn <?php echo $ratebtn1 ?>"></div>
			    <div id="2" class="rate-btn-2 rate-btn <?php echo $ratebtn2 ?>"></div>
			    <div id="3" class="rate-btn-3 rate-btn <?php echo $ratebtn3 ?>"></div>
			    <div id="4" class="rate-btn-4 rate-btn <?php echo $ratebtn4 ?>"></div>
			    <div id="5" class="rate-btn-5 rate-btn <?php echo $ratebtn5 ?>"></div>
			</div>
	        <div class="box-result-cnt">
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