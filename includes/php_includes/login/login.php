<?php //Login for signed users
if(isset($_POST["login"])){
	include_once("includes/php_includes/db.php");
	$e = mysqli_real_escape_string($conn_users, $_POST['e']);
	$p = md5($_POST['p']);
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

	if($e == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
		$sql = "SELECT id, username, password FROM users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($conn_users, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 

    					$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($conn_users, $sql);
			echo $db_username;
		    exit();
		}
	}
	exit();
}
?>