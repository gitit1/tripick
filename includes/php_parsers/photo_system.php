<?php
include_once("../php_includes/db.php");
$userName = $_GET['username'];
?><?php 
if (isset($_FILES["avatar"]["name"]) && $_FILES["avatar"]["tmp_name"] != ""){
	$link = $_SERVER['HTTP_REFERER'];
	$fileName = $_FILES["avatar"]["name"];
    $fileTmpLoc = $_FILES["avatar"]["tmp_name"];
	$fileType = $_FILES["avatar"]["type"];
	$fileSize = $_FILES["avatar"]["size"];
	$fileErrorMsg = $_FILES["avatar"]["error"];
	$kaboom = explode(".", $fileName);
	$fileExt = end($kaboom);
	list($width, $height) = getimagesize($fileTmpLoc);
	if($width < 10 || $height < 10){
		header("location: ../php_includes/login/message.php?msg=ERROR: That image has no dimensions");
        exit();	
	}
	$db_file_name = rand(100000000000,999999999999).".".$fileExt;
	if($fileSize > 1048576) {
		header("location: ../php_includes/login/message.php?msg=ERROR: Your image file was larger than 1mb");
		exit();	
	} else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
		header("location: ../php_includes/login/message.php?msg=ERROR: Your image file was not jpg, gif or png type");
		exit();
	} else if ($fileErrorMsg == 1) {
		header("location: ../php_includes/login/message.php?msg=ERROR: An unknown error occurred");
		exit();
	}
	$sql = "SELECT avatar FROM users WHERE username='$userName' LIMIT 1";
	$query = mysqli_query($conn_users, $sql);
	$row = mysqli_fetch_row($query);
	$avatar = $row[0];
	if($avatar != ""){
		$picurl = "../../users/$userName/$avatar"; 
	    if (file_exists($picurl)) { unlink($picurl); }
	}
	$moveResult = move_uploaded_file($fileTmpLoc, "../../users/$userName/$db_file_name");
	if ($moveResult != true) {
		header("location: ../php_includes/login/message.php?msg=ERROR: File upload failed");
		exit();
	}
	include_once("image_resize.php");
	$target_file = "../../users/$userName/$db_file_name";
	$resized_file = "../../users/$userName/$db_file_name";
	$wmax = 150;
	$hmax = 150;
	img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
	$sql = "UPDATE users SET avatar='$db_file_name' WHERE username='$userName' LIMIT 1";
	$query = mysqli_query($conn_users, $sql);
	mysqli_close($conn_users);
	header("location: $link");
	exit();
}
?>