<?php //check login status
	include_once("includes/php_includes/db.php");
	$userName = $_GET['userName'];
?>
<?php
if(isset($_POST['pass'])){
	$userName = $_POST['userName'];
	$pass = $_POST['pass'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];

	$sql = "SELECT * FROM users WHERE username='$userName' AND fbId='Null' LIMIT 1";
    $query = mysqli_query($conn_users, $sql); 
    $row = mysqli_fetch_assoc($query);
	$oldPass = $row["password"];	
	
	$pass_hash = MD5($pass);
	if ($pass_hash != $oldPass){
		echo "notOldPass";
		exit;
	}elseif ($pass1 != $pass2){
		echo "notMach";
		exit;
	}elseif(strlen($pass1) <= 3 || strlen($pass1) > 8){
		echo "len";
		exit;		
	}else{
		$p_hash = MD5($pass1);
		$sql = "UPDATE users SET password='$p_hash' WHERE username='$userName' AND fbId='Null' LIMIT 1";
	    $query = mysqli_query($conn_users, $sql);
		
		if($query){
			echo "pass_success";
		} else {
			echo "There WAS an Error";
		}			
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
	function changePass(){
		var userName = _("userMenuchangePassUserName").value;
		var pass = _("pass").value;
		var pass1 = _("pass1").value;
		var pass2 = _("pass2").value;
		if ( (pass == "") || (pass1 == "") || (pass2 == "") ){
			_("userMenuchangePassStatus").innerHTML = "Missing Data";
		}else{
			_("userMenuchangePassStatus").innerHTML = 'please wait ...';
			var ajax = ajaxObj("POST", "changePassword.php");
	        ajax.onreadystatechange = function() {
		        if(ajaxReturn(ajax) == true) {
					var response = ajax.responseText.trim();
					if(response == "pass_success"){
						_("userMenuchangePassStatus").innerHTML = 'Your password have been Changed';
					} else if (response == "notOldPass"){
						_("userMenuchangePassStatus").innerHTML = "The Old password you entered didn't match to the password in the database, please try again";
					} else if(response == "notMach"){
						_("userMenuchangePassStatus").innerHTML = "The new passord dosen't match eachother!";
					} else if(response == "len"){
						_("userMenuchangePassStatus").innerHTML = "the length of the password should be between 3-8";
					}
		        }
	        }
	        ajax.send("pass="+pass+"&pass1="+pass1+"&pass2="+pass2+"&userName="+userName);
		}
	}
	</script>
</head>
<body>
		<div id="userMenuchangePassDiv">
			  <form id="userMenuchangePassForm" onsubmit="return false;">
			    <label class="userMenuchangePassLabel">Enter your old password:<br>
			    <input id="pass" type="password" onfocus="_('userMenuchangePassStatus').innerHTML='';" maxlength="8" class="chosen-text">
			   </label>
			    <label class="userMenuchangePassLabel1">Enter your new password:<br>
			    <input id="pass1" type="password" onfocus="_('userMenuchangePassStatus').innerHTML='';" maxlength="8" class="chosen-text">
			   </label>
			    <label class="userMenuchangePassLabel2">Enter your new Password again:<br>
			    <input id="pass2" type="password" onfocus="_('userMenuchangePassStatus').innerHTML='';" maxlength="8" class="chosen-text">
			   </label>
				<input type="hidden" id="userMenuchangePassUserName" value="<?php echo  $userName; ?>" >			   		   			   
			    <button id="userMenuchangePassButton" onclick="changePass()">Send</button> 
			    <p id="userMenuchangePassStatus"></p>
			  </form>				
		</div>
</body>
</html>