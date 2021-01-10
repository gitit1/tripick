<?php
include_once("includes/php_includes/check_login_status.php");
// If user is already logged in, header that weenis away

// Initialize our ui

$u = $_GET['u'];
$pm_ui = "";
if ($fbId != null){
	$fb = $fbId;
}else{
	$fb= 'Null';
}
// If visitor to profile is a friend and is not the owner can send you a pm
// Build ui carry the profile id, vistor name, pm subject and comment to js
$pm_ui .= '<input id="pmsubject" onkeyup="statusMax(this,30)" placeholder="Subject of pm..."><br />';
$pm_ui .= '<textarea id="pmtext" onkeyup="statusMax(this,250)" placeholder="Send '.$u.' a private message" onclick="this.value=\'\'"></textarea>';
$pm_ui .= '<button id="pmBtn" onclick="postPm(\''.$u.'\',\''.$userName.'\',\'pmsubject\',\'pmtext\',\''.$fb.'\')">Send</button>';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tripick</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?>
	<script>
	function postPm(tuser,fuser,subject,ta,fb){
		var data = _(ta).value;
		var data2 = _(subject).value;
		var status = document.getElementById('template_pm_status');
		if(data == "" || data2 == ""){
			_(ta).value = 'Fill out all the fields';
			return false;
		}
		var ajax = ajaxObj("POST", "includes/php_parsers/pm_system.php");
		ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				if(ajax.responseText == "pm_sent"){
					_(ta).value = 'Message has been sent.';
					_(subject).value = "";
				} else {
					status.innerHTML = ajax.responseText;
				}
			}
		}
		ajax.send("action=new_pm&fuser="+fuser+"&tuser="+tuser+"&data="+data+"&data2="+data2+"&fbId="+fb);
	}
	function statusMax(field, maxlimit) {
		if (field.value.length > maxlimit){
			var status = document.getElementById('template_pm_status');
			status.innerHTML = maxlimit+" maximum character limit reached";
		}
	}
	</script>
	</head>
	<body>	
		<div id="statusui">
		 	 <?php echo $pm_ui; ?>
		 	 <div id="template_pm_status"></div>
		</div>
	</body>
</html>