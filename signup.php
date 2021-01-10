<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
	$noBtnMobile = True;
?>
<?php
session_start();
// If user is logged in, header them away
if($user_ok == true){
	header("location: index.php?actMsg=loggedIn"); 
    exit();
}
$profile_pic = "<img src='images/avatardefaultMale.png'>";
?><?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
	include_once("includes/php_includes/db.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
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
	    echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
	    exit();
    } else {
	    echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
	    exit();
    }
}
?><?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["u"])){
	// CONNECT TO THE DATABASE
	include_once("includes/php_includes/db.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$u = $_POST['u'];
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
<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); ?>
		<script>
			function checkusername(){
				var u = _("username").value;
				if(u != ""){
					_("unamestatus").innerHTML = 'checking ...';
					var ajax = ajaxObj("POST", "signup.php");
			        ajax.onreadystatechange = function() {
				        if(ajaxReturn(ajax) == true) {
				            _("unamestatus").innerHTML = ajax.responseText;
				        }
			        }
			        ajax.send("usernamecheck="+u);
				}
			}			
			function signup(){
				var u = _("username").value;
				var e = _("email").value;
				var p1 = _("pass1").value;
				var p2 = _("pass2").value;
				var c = _("country").value;
				var g = document.querySelector('input[name="sex"]:checked').value;
				var b = _("birthday").value;
				var status = _("signup_status");
				if(u == "" || e == "" || p1 == "" || p2 == "" || c == "" || g == ""){
					status.innerHTML = "Fill out all of the form data";
				} else if(p1 != p2){
					status.innerHTML = "Your password fields do not match";
				//} else if( _("terms").style.display == "none"){
				//	status.innerHTML = "Please view the terms of use";
				} 
				else {
					status.innerHTML = 'please wait ...';
					var ajax = ajaxObj("POST", "signup.php");
			        ajax.onreadystatechange = function() {
				        if(ajaxReturn(ajax) == true) {
				            if(ajax.responseText != "signup_success"){
								status.innerHTML = ajax.responseText;
							} else {
								window.scrollTo(0,0);
								_("signupform").innerHTML = "<div class='signUpPageActiveMsg'>OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> <br>in a moment to complete the sign up process by activating your account.<br> You will not be able to do anything on the site until you successfully activate your account.</div>";
							}
				        }
			        }
			        ajax.send("u="+u+"&e="+e+"&p="+p1+"&c="+c+"&g="+g+"&b="+b);
				}
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
			<main>			
				<nav class="breadCrums">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><img src="images/main/breadcrumsArrows.png" class="navArrows"></li>
						<li><a href="signup.php">Sign Up</a></li>
					</ul>
				</nav>
			    <h1 class="pageHeader headerSignUp">Sign Up</h1>					
			    <div class="content">
			    	
				    <div class="mapGeneralSettings mapOpacity mapFixedHeight smallMap">
						<div class="signUpPageSignUpDiv">
							<form name="signupform" id="signupform" onsubmit="return false;">
							    <label class="signUpPageSignUpUserNameLabel">Username:<br>
							    <input id="username" type="text" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16" class="chosen-text" placeholder="Enter your UserName">
							    	<span id="unamestatus"></span></label><br><br>					    
							    <label class="signUpPageSignUpEmailLabel">Email Address:<br>
									<input id="email" type="text" onfocus="emptyElement('signup_status')" onkeyup="restrict('email')" maxlength="88" class="chosen-text" placeholder="Enter your Email">
								</label><br><br>							    							    	
							    <label class="signUpPageSignUpBirthdayLabel">Birthday:<br>
							    	<input id="birthday" type="date" maxlength="2" onfocus="emptyElement('signup_status')" class="chosen-date">
							    </label>
							    <label class="signUpPageSignUpPassword1Label">Create Password:<br>
							    	<input id="pass1" type="password" onfocus="emptyElement('signup_status')" maxlength="16" class="chosen-text" placeholder="Enter your Pssword">
							    </label><br><br>
							    <label class="signUpPageSignUpPassword2Label">Confirm Password:<br>
							    	<input id="pass2" type="password" onfocus="emptyElement('signup_status')" maxlength="16" class="chosen-text" placeholder="Repeat Pssword">
							    </label><br><br>
							    <label class="signUpPageSignUpGenderLabel">Gender:</br>
							        <label class="genderMaleLabel"><input id="genderMale" type="radio" name="sex" value="m" checked onfocus="emptyElement('signup_status')">
							        	Male</label>
	  								<label class="genderFemaleLabel"><input id="genderFemale" type="radio" name="sex" value="f" onfocus="emptyElement('signup_status')">
	  									Female</label>
							    </label><br>
							    <br><label class="signUpPageSignUpCountryLabel">Country:<br>
									    <select id="country" onfocus="emptyElement('signup_status')" class="chosen-select countryBox">
									      <?php include_once("includes/php_includes/pageReturningSections/template_country_list.php"); ?>
									    </select>
								    </label>
							    <!-- NOT IN USE RIGHT NOW
							    <div>
							      <a href="#" onclick="return false" onmousedown="openTerms()">
							        View the Terms Of Use
							      </a>
							    </div>
							    <div id="terms" style="display:none;">
							      <h3>Web Intersect Terms Of Use</h3>
							      <p>1. Play nice here.</p>
							      <p>2. Take a bath before you visit.</p>
							      <p>3. Brush your teeth before bed.</p>
							    </div>
							    -->
							    <br /><br />
							    <button id="signupbtn" onclick="signup()">Create Account</button>
							    <span id="signup_status"></span>						    
							</form>
						</div>
					</div>	
				</div>
				<div class="mobileBtnsSignUp">
					<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");}else{/*include_once("includes/php_includes/pageReturningSections/footer.php");*/} ?>
				</div>								
			</main>
		</div>	
	</body>
</html>	