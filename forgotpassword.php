<?php //check login status
	include_once("includes/php_includes/db.php");
?>
<?php
// AJAX CALLS THIS CODE TO EXECUTE
if(isset($_POST["e"])){
	$e = mysqli_real_escape_string($conn_users, $_POST['e']);
	$sql = "SELECT id, username,fbId FROM users WHERE email='$e' AND activated='1' LIMIT 1";	
	$query = mysqli_query($conn_users, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows > 0){
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
			$id = $row["id"];
			$u = $row["username"];
			$fbId = $row["fbId"];
		}
		if ($fbId != 'Null'){
			echo "facebook";
			exit();			
		}
		$emailcut = substr($e, 0, 4);
		$randNum = rand(10000,99999);
		$tempPass = "$emailcut$randNum";
		$hashTempPass = md5($tempPass);
		$sql = "UPDATE useroptions SET temp_pass='$hashTempPass' WHERE email='$e' LIMIT 1";
	    $query = mysqli_query($conn_users, $sql);
		$to = "$e";
		$from = "auto_responder@tripick.net";
		$headers ="From: $from\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
		$subject ="TriPick Temporary Password";
		$msg = '<h2>Hello '.$u.'</h2><p>This is an automated message from yoursite. If you did not recently initiate the Forgot Password process, please disregard this email.</p><p>You indicated that you forgot your login password. We can generate a temporary password for you to log in with, then once logged in you can change your password to anything you like.</p><p>After you click the link below your password to login will be:<br /><b>'.$tempPass.'</b></p><p><a href="http://tripick.net/forgotpassword.php?u='.$u.'&p='.$hashTempPass.'&e=' . $e. '">Click here now to apply the temporary password shown below to your account</a></p><p>If you do not click the link in this email, no changes will be made to your account. In order to set your login password to the temporary password you must click the link above.</p>';
		if(mail($to,$subject,$msg,$headers)) {
			echo "success";
			exit();
		} else {
			echo "email_send_failed";
			exit();
		}
    } else {
        echo "no_exist";
    }
    exit();
}
?><?php
// EMAIL LINK CLICK CALLS THIS CODE TO EXECUTE
if(isset($_GET['u']) && isset($_GET['p'])){
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
	$temppasshash = preg_replace('#[^a-z0-9]#i', '', $_GET['p']);
	$e =   $_GET['e'];
	if(strlen($temppasshash) < 10){
		exit();
	}
	$sql = "SELECT id FROM useroptions WHERE username='$u' AND temp_pass='$temppasshash' AND email='$e' LIMIT 1";
	$query = mysqli_query($conn_users, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows == 0){
		header("location: index.php?fPassMsg=fPassMsg");
    	exit();
	} else {
		$row = mysqli_fetch_row($query);
		$id = $row[0];
		$sql = "UPDATE users SET password='$temppasshash' WHERE id='$id' AND username='$u' AND email='$e' LIMIT 1";
	    $query = mysqli_query($conn_users, $sql);
		$sql = "UPDATE useroptions SET temp_pass='' WHERE username='$u' AND email='$e' LIMIT 1";
	    $query = mysqli_query($conn_users, $sql);
	    header("location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tripick</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php");?>
	<script>
	function forgotpass(){
		var e = _("email").value;
		if(e == ""){
			_("userMenuforgotPassStatus").innerHTML = "Type in your email address";
		} else {
			_("userMenuforgotPassStatus").innerHTML = 'please wait ...';
			var ajax = ajaxObj("POST", "forgotpassword.php");
	        ajax.onreadystatechange = function() {
		        if(ajaxReturn(ajax) == true) {
					var response = ajax.responseText.trim();
					if(response == "success"){
						_("userMenuforgotPassForm").innerHTML = "<div class='userMenuforgotPassP'><p>Email has been send.<br> Check your email inbox in a few minutes</p></div>";
					} else if (response == "no_exist"){
						_("userMenuforgotPassStatus").innerHTML = "Sorry that email address is not in our system";
					} else if(response == "email_send_failed"){
						_("userMenuforgotPassStatus").innerHTML = "Mail function failed to execute";
					} else if(response == "facebook"){
						_("userMenuforgotPassStatus").innerHTML = "This Email is registrar with facebook<br>try login with the Facebook login button";
					} else {
						_("userMenuforgotPassStatus").innerHTML = "An unknown error occurred";
					}
		        }
	        }
	        ajax.send("e="+e);
		}
	}
	</script>
</head>
<body>
		<div id="userMenuforgotPassDiv">
			  <form id="userMenuforgotPassForm" onsubmit="return false;">
			    <label class="userMenuforgotPassLabel">Enter Your Email Address:</label>
			    <input id="email" type="text" onfocus="_('userMenuforgotPassStatus').innerHTML='';" maxlength="88" class="chosen-text">
			    <br /><br />
			    <button id="userMenuforgotPassButton" onclick="forgotpass()">Send</button> 
			    <p id="userMenuforgotPassStatus"></p>
			  </form>				
		</div>
</body>
</html>