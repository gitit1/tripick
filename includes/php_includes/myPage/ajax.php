<?php //check login status
	include_once("../db.php");
?>
<?php
    if($_POST['act'] == 'rate'){
    	//search if the user(ip) has already gave a note
    	$ip = $_SERVER["REMOTE_ADDR"];
    	$therate = $_POST['rate'];
    	$thepost = $_POST['post_id'];

    	$query = mysqli_query($conn_actlst, "SELECT * FROM wcd_rate where ip= '$ip'  "); 
    	while($data = mysql_fetch_assoc($query)){
    		$rate_db[] = $data;
    	}

    	if(@count($rate_db) == 0 ){
    		mysqli_query($conn_actlst, "INSERT INTO wcd_rate (id_post, ip, rate)VALUES('$thepost', '$ip', '$therate')");
    	}else{
    		mysqli_query($conn_actlst, "UPDATE wcd_rate SET rate= '$therate' WHERE ip = '$ip'");
    	}
	} 
?>
<?php
    if($_POST['list'] == 'rate'){
    	//search if the user(ip) has already gave a note
    	$ip = $_SERVER["REMOTE_ADDR"];
    	$therate = $_POST['rate'];
    	$thepost = $_POST['post_id'];

    	$query = mysqli_query($conn_actlst, "SELECT * FROM wcd_rate_lists where ip= '$ip'  "); 
    	while($data = mysql_fetch_assoc($query)){
    		$rate_db[] = $data;
    	}

    	if(@count($rate_db) == 0 ){
    		mysqli_query($conn_actlst, "INSERT INTO wcd_rate_lists (id_post, ip, rate)VALUES('$thepost', '$ip', '$therate')");
    	}else{
    		mysqli_query($conn_actlst, "UPDATE wcd_rate SET rate= '$therate' WHERE ip = '$ip'");
    	}
	} 
?>