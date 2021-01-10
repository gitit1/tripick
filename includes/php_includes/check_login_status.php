<?php
session_start();
include_once("db.php");
// Files that inculde this file at the very top would NOT require 
// connection to database or session_start(), be careful.
// Initialize some vars
$user_ok = false;
$log_id = "";
$log_username = "";
$log_password = "";
// User Verify function
function evalLoggedUser($conn_users,$id,$u,$p){
	$sql = "SELECT ip FROM users WHERE id='$id' AND username='$u' AND password='$p' AND activated='1' LIMIT 1";
    $query = mysqli_query($conn_users, $sql);
    $numrows = mysqli_num_rows($query);
	if($numrows > 0){
		return true;
	}
}
if(isset($_SESSION["userid"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])) {
	$log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
	$log_username = preg_replace('#[^a-z0-9_-]#i', '', $_SESSION['username']);
	$log_password = preg_replace('#[^a-z0-9]#i', '', $_SESSION['password']);
	// Verify the user
	$user_ok = evalLoggedUser($conn_users,$log_id,$log_username,$log_password);
} else if(isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])){
	$_SESSION['userid'] = preg_replace('#[^0-9]#', '', $_COOKIE['id']);
    $_SESSION['username'] = preg_replace('#[^a-z0-9_-]#i', '', $_COOKIE['user']);
    $_SESSION['password'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['pass']);
	$log_id = $_SESSION['userid'];
	$log_username = $_SESSION['username'];
	$log_password = $_SESSION['password'];
	// Verify the user
	$user_ok = evalLoggedUser($conn_users,$log_id,$log_username,$log_password);
	if($user_ok == true){
		// Update their lastlogin datetime field
		$sql = "UPDATE users SET lastlogin=now() WHERE id='$log_id' LIMIT 1";
        $query = mysqli_query($conn_users, $sql);
	}
}
?>
<?php //facebook check + flags for user menu
	require_once ('includes/Facebook_int/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php');

	if($_SESSION['facebook_access_token']){
		include_once 'includes/Facebook_int/check_login_status_facebook.php';
		$user_flag = true;
		$user_ok = true;
	}elseif($user_ok == true){
		    $user_flag = true;
		    $userName = $_SESSION["username"];
			$userEmail = $_SESSION["email"];
			$userID = $_SESSION["userid"];
	}else{
		$user_flag = false;	
	}
	
	include_once("includes/php_includes/login/login.php");
?>