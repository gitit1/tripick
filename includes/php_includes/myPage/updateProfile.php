<?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["userName"])){
	// CONNECT TO THE DATABASE
	include_once("../db.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$userName = $_POST['userName'];
	$userFbId = $_POST['userFbId'];
	$userEmail = $_POST['userEmail'];
	$uName = $_POST['uName'];
	$fName = $_POST['fName'];
	$lName = $_POST['lName'];
	$email = mysqli_real_escape_string($conn_users, $_POST['email']);
	$birthday = preg_replace('#[^a-z0-9_]#i', '', $_POST['birthday']);
	$country = $_POST['country'];
	$about = $_POST['about'];

	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users WHERE username='$uName' LIMIT 1";
    $query = mysqli_query($conn_users, $sql); 
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT id FROM users WHERE email='$email ' LIMIT 1";
    $query = mysqli_query($conn_users, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING

	if ( ($u_check > 0) && ($uName != $userName) ){ 
        echo "The username you entered is alreay taken";
        exit();
	} else if ( ($e_check > 0) && ($email != $userEmail) ){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($uName) < 3 || strlen($uName) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($uName[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
	// END FORM DATA ERROR HANDLING

		$sql = "UPDATE users SET firstname='$fName' WHERE username='$userName' AND fbId='$userFbId'";
		$query_fname = mysqli_query($conn_users, $sql); 

		$sql = "UPDATE users SET lastname='$lName' WHERE username='$userName' AND fbId='$userFbId'";
		$query_lname = mysqli_query($conn_users, $sql); 

		$sql = "UPDATE users SET email='$email' WHERE username='$userName' AND fbId='$userFbId'";
		$query_email = mysqli_query($conn_users, $sql); 

		$sql = "UPDATE users SET birthday='$birthday' WHERE username='$userName' AND fbId='$userFbId'";
		$query_birthday = mysqli_query($conn_users, $sql); 

		$sql = "UPDATE users SET country='$country' WHERE username='$userName' AND fbId='$userFbId'";
		$query_country = mysqli_query($conn_users, $sql); 

		$sql = "UPDATE users SET about='$about' WHERE username='$userName' AND fbId='$userFbId'";
		$query_about= mysqli_query($conn_users, $sql); 

		if ( ($uName != $userName) && ($userFbId =='Null') ){
			if (!file_exists("../../../users/$uName")) {
				rename("../../../users/$userName","../../../users/$uName");
			}
			/*
			$sql = "SELECT * FROM users WHERE username='$userName' AND fbId='Null' LIMIT 1";
    		$query = mysqli_query($conn_users, $sql);
    		$row = mysqli_fetch_assoc($query);
			$avatar = $row["avatar"];
			 		
			$file = '../../../users/$userName/$avatar';
			$newfile = '../../../users/$uName/$avatar';			
			if (!copy($file, $newfile)) {
			    echo "failed to copy";
			}	*/			
		}

 		$sql = "UPDATE users SET username='$uName' WHERE username='$userName' AND fbId='$userFbId'";
		$query_uname = mysqli_query($conn_users, $sql); 

		 		
		if ($query_fname && $query_lname && $query_email && $query_birthday && $query_country && $query_about && $query_uname){
			echo "signup_success";
		} else {
			echo "There WAS an Error";
		}
				

	
		exit();
	}		


	exit();
}	
?>