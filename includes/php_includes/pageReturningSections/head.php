<meta charset='UTF-8 w/o BOM'>

<!--<link rel='stylesheet' href='includes/style/media.css'>-->
<link rel='stylesheet' href='includes/style/jquery.confirmon.css'>
<link rel='stylesheet' href='includes/style/colorbox.css'>
<link rel='shortcut icon' type='image/png' href='images/favicon.png'/>
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
<script type='text/javascript' src='includes/js/colorbox/jquery.colorbox-min.js'></script>
<script type='text/javascript' src='includes/php_includes/searchBox/jsSearchFiles.php'></script>
<script type='text/javascript' src='includes/js/searchBox.js'></script>
<script src='includes/js/colorbox/jquery.colorbox.js'></script>
<script src='includes/js/ajax.js'></script>
<script src='includes/js/main.js'></script>
<script type='text/javascript' src='includes/js/login.js'></script>
<script type='text/javascript' src='includes/js/myPageJsIncludes.js'></script>
<script type='text/javascript' src='includes/js/confirmon/jquery.confirmon.js'></script>		

 <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
 <script src="includes/select2/select2.js"></script>
 
<?php
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
//$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
if ($iphone || $android || $palmpre /*|| $ipod*/ || $berry == true) 
{    
	echo "<link rel='stylesheet' href='includes/style/style_mobile.css'>";
	echo "<link rel='stylesheet' href='includes/select2/select2Mobile.css'>";
	$mobile = true;
}else{
	echo "<link rel='stylesheet' href='includes/style/style.css'>";
	echo "<link rel=\"stylesheet\" href=\"includes/select2/select2.css\">";
	$mobile = false;
}
 
?>


 
