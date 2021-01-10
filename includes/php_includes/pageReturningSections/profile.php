<?php
	if( ($isOwner = "yes") && ($_GET['u'] == $user) ){
		$edit = "block";
		$myProfile = "block";
		$otherProfile = "none";
	}else{
		$edit = "none";
		$myProfile = "none";
		$otherProfile = "block";		
	}
	
	if($mobile){
		$avt = $profile_pic1;
	}elseif($sex == "Male"){
		$avt = '<img src="images/avatardefaultMale.png" alt="'.$u1.'">';
	}else{ 
		$avt = '<img src="images/avatardefaultFemale.png" alt="'.$u1.'">';
	}		
?>
<?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
	$usernamechk = $_POST['usernamecheck'];
	$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($conn_users, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
	    echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
	    exit();
    }
	if (is_numeric($username[0])) {
	    echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
	    exit();
    }
    if ($uname_check < 1) {
	    echo '<strong style="color:#009900;">' . $usernamechk . ' is OK</strong>';
	    exit();
    } else {
	    echo '<strong style="color:#F00;">' . $usernamechk . ' is taken</strong>';
	    exit();
    }
}
?><?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["u"])){
	// CONNECT TO THE DATABASE
	include_once("includes/php_includes/db.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$u = preg_replace('#[^a-z0-9_-]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($conn_users, $_POST['e']);
	$p = $_POST['p'];
	$g = preg_replace('#[^a-z]#', '', $_POST['g']);
	$b = preg_replace('#[^a-z0-9_]#i', '', $_POST['b']);
	$c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($conn_users, $sql); 
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($conn_users, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if($u == "" || $e == "" || $p == "" || $g == "" || $c == ""){
		echo "The form submission is missing values.";
        exit();
	} else if ($u_check > 0){ 
        echo "The username you entered is alreay taken";
        exit();
	} else if ($e_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($u) < 3 || strlen($u) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
	// END FORM DATA ERROR HANDLING
	    // Begin Insertion of data into the database
		// Hash the password and apply your own mysterious unique salt
			//NOT USING RIGHT NOW  - $cryptpass = crypt($p);
			//NOT USING RIGHT NOW  - include_once ("includes/php_includes/login/randStrGen.php");
			//NOT USING RIGHT NOW  - $p_hash = randStrGen(20)."$cryptpass".randStrGen(20);
		$p_hash = MD5($p);
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users (username, email, password, gender, birthday, country, ip, signup, lastlogin, notescheck,  
				fbId)       
		        VALUES('$u','$e','$p_hash','$g','$b','$c','$ip',now(),now(),now(),'Null')";
		$query = mysqli_query($conn_users, $sql); 
		$uid = mysqli_insert_id($conn_users);
		// Establish their row in the useroptions table
		$sql = "INSERT INTO useroptions (id, username, email) VALUES ('$uid','$u', '$e')";
		$query = mysqli_query($conn_users, $sql);
		// Create directory(folder) to hold each user's files(pics, MP3s, etc.)
		if (!file_exists("users/$u")) {
			mkdir("users/$u", 0755);
		}
		// Email the user their activation link
		$to = "$e";							 
		$from = "auto_responder@tripick.net";
		$subject = 'TriPick Account Activation';
		$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>TriPick Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://tripick.net"><img src="http://tripick.net/images/logo.png" width="36" height="30" alt="TriPick" style="border:none; float:left;"></a>TriPick Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="http://www.tripick.net/activation.php?id='.$uid.'&u='.$u.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
		$headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		if (mail($to, $subject, $message, $headers)){
			echo "signup_success";
		} else {
			echo "There WAS an Error";
		}
		
		exit();
	}
	exit();
}	
?>
<script>
	function profileSectionEdit(){
		var viewS = document.getElementById('profileSectionViewData');
		var updateS = document.getElementById('profileSectionUpdateData');
		var labels = document.getElementById('profileSectionLabels');
		viewS.style.display = 'none';
		updateS.style.display = 'block';
		labels.style.color = '#233038';
		
	}
	function profileSectionSave(){
		var viewS = document.getElementById('profileSectionViewData');
		var updateS = document.getElementById('profileSectionUpdateData');
		var labels = document.getElementById('profileSectionLabels');
		viewS.style.display = 'block';
		updateS.style.display = 'none';
		labels.style.color = '#ffffff';
	}
		
	function updateProfile(){
		var userName = _("profileSectionUserName").value;
		var userFbId = _("profileSectionFbid").value;
		
		var uName = _("profileSectionUserNameInput").value;
		var fName = _("profileSectionFirstNameInput").value;
		var lName = _("profileSectionLastNameInput").value;
		var email = _("profileSectionEmailInput").value;
		var birthday = _("profileSectionBirthdayInput").value;
		var country = _("profileSectionCountryInput").value;
		var about = _("profileSectionAboutTextarea").value;
	
		var profile_status = _("profile_status");
		
		if(u == "" || e == ""){
			profile_status.innerHTML = "Fill out all of the form data";
		} else if(p1 != p2){
			profile_status.innerHTML = "Your password fields do not match";
		//} else if( _("terms").style.display == "none"){
		//	status.innerHTML = "Please view the terms of use";
		} 
		else {
			status.innerHTML = 'please wait ...';
			var ajax = ajaxObj("POST", "http://tripick.net/mypage.php?id=profile&u="+uName+".php");
	        ajax.onreadystatechange = function() {
		        if(ajaxReturn(ajax) == true) {
		            if(ajax.responseText != "signup_success"){
						profile_status = ajax.responseText;
					} else {
						window.scrollTo(0,0);
						_("signupform").innerHTML = "<div class='signUpPageActiveMsg'>OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.</div>";
					}
		        }
	        }
	        ajax.send("userName="+userName+"&userFbId="+userFbId+"&uName="+uName+"&fName="+fName+"&lName="+lName+"&email="+email
	        		  +"&birthday="+birthday+"&country="+country+"&about="+about);
		}
	}			
</script>
<div class="mapGeneralSettings mapOpacity mapFixedHeight">
	<h1 class='profileSectionPageHeader'><?php  echo $u; ?> Profile</h1>
	<section id="profileSectionLabels">		
		<label class="profileSectionUserNameLabel">User Name:</label>
		<label class="profileSectionFirstNameLabel">First Name:</label>
		<label class="profileSectionLastNameLabel">Last Name:</label>
		<label class="profileSectionEmailLabel">Email Adress:</label>
		<label class="profileSectionBirthdayLabel">Birthday:</label>
		<label class="profileSectionCountryLabel">Country:</label>
		<label class="profileSectionAboutLabel">About Myself:</label>
	</section>
	<section id="profileSectionViewData" style="display:<?php $profileSectionViewData; ?>">
		
		<div class="myProfile" style="display:<?php echo $myProfile; ?>"><?php echo $avt;?></div>
		<div class="otherProfile" style="display:<?php echo $otherProfile;?>"><?php echo $profile_pic1; ?></div>
		
		<span class="profileSectionUserNameSpan"><?php  echo $u; ?></span>
		<span class="profileSectionFirstNameSpan"><?php  echo $firstname; ?></span>
		<span class="profileSectionLastNameSpan"><?php  echo $lastname; ?></span>
		<span class="profileSectionEmailSpan"><?php  echo $email; ?></span>
		<span class="profileSectionBirthdaySpan"><?php  echo date_format(new DateTime($birthday), 'd/m/Y')?></span>
		<span class="profileSectionCountrySpan"><?php  echo $country; ?></span>
		<div class="profileSectionAboutSpan"><span><?php  echo $about; ?></span></div>
		<span class="profileSectionStatus"></span>
		
		<div class="friendsStatusProfile" style="display:<?php echo $friendBtn;?>">
	  		<p><span id="friendBtn"><?php echo $friend_button; ?></span></p>
	  		<p><span id="blockBtn"><?php echo $block_button; ?></span></p>
	  		<a href="template_pm.php?u=<?php  echo $u; ?>" onclick="popUpOpenIframe(500,400)" class="iframe generalBtn btnImgMessage">
	  			<img src="images/btn/message.png" alt="Send Message" title="Send Message"/>
	  		</a>
	    </div>
	    <!--NEED FIX-->	
		<!--<input type="button" id="profileSectionUpadateDataButton" value="Edit" onclick="profileSectionEdit();" style="display:<?php echo $edit;?>">-->
		<!--NEED FIX-->
	</section>
	<section id="profileSectionUpdateData">
		<h2>Edit your info</h2>
		<p>Click on the info that you want to edit</p>
		<form>
			<input type='text' class="chosen-text" id="profileSectionUserNameInput" onclick="this.value=''" placeholder="Enter Your UserName" value='<?php  echo$u; ?>' onblur="checkusername()" onkeyup="restrict('username')" maxlength="16">
			<input type='text' class="chosen-text" id="profileSectionFirstNameInput" onclick="this.value=''" placeholder="Enter Your First Name" value='<?php  echo$firstname; ?>'>
			<input type='text'  class="chosen-text" id="profileSectionLastNameInput" onclick="this.value=''" placeholder="Enter Your Last Name" value='<?php  echo$lastname; ?>'>
			<input type='text' class="chosen-text"  id="profileSectionEmailInput" onclick="this.value=''" placeholder="Enter Your Email" value='<?php  echo$email; ?>'>
			<input type='date' id="profileSectionBirthdayInput" class="chosen-date" onclick="this.value=''" value='<?php  echo$birthday; ?>'>
	    	<select id="country" name="countryNamePartner" onfocus="emptyElement('status_activity')" 
	    		    class="chosen-select" data-placeholder='<?php  echo$country; ?>'> 							    		
	      		<?php include("includes/php_includes/pageReturningSections/template_country_list_clean.php"); ?>
	    	</select>	    				
			<textarea id="profileSectionAboutTextarea"></textarea>
			
			<input type="hidden" id="profileSectionUserName" value="<?php echo  $userName; ?>" >
			<input type="hidden" id="profileSectionFbid" value="<?php echo  $fbId; ?>" >
			
			<button id="profileSectionUpadatePassword">Change password</button>			
			<input type="button" id="profileSectionSaveDataButton" onclick="updateProfile()" value="Save">
			<span id="profile_status"></span>
		</form>
		<div id="profile_pic_box2"><?php if($fbId=='Null'){echo $profile_pic_btn;  echo $avatar_form;} ?></div>
	</section>	
</div>
<div class="mobileBtnsProfile">
<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");} ?>
</div>
<div class="clear"></div>