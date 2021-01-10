<?php //check login status
	include_once("includes/php_includes/db.php");
	$userName = $_GET['userName'];
?>
<?php	
	$listId = $_GET['id'];	
    //get data from DB	
    $queryLists = "SELECT * FROM lists Where id = '$listId'";	
    $resultLists = mysqli_query($conn_actlst, $queryLists);
    if(!$resultLists) {
        die("DB query failed.");
    }

	while($row = mysqli_fetch_assoc($resultLists)){
		$listId = $row["id"];	
		$listMainPhoto = $row["main_photo"];
		$listUsername = $row["username"];	
		$listName = $row["listname"];
		$listFromDate = $row["fromdate"];
		$listFromDate = date_format(new DateTime($listFromDate), 'd/m/Y');
		$listToDate = $row["todate"]; 
		$listToDate = date_format(new DateTime($listToDate), 'd/m/Y');
		$listCountry = $row["country"];
		$listCity = $row["city"];
		$details = $row["details"];
		
		if ($listMainPhoto == ""){
			$photoSrc = 'http://tripick.net/images/lists/listDefault.png';
		}else{
			$photoSrc = 'http://tripick.net/users/$listUsername/$listMainPhoto';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Tripick</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php");?>
	    <meta property="og:url"           content="http://tripick.net/showfulllist.php?username=eliran222&fbId=Null&id=<?php echo $listId; ?>" />
	    <meta property="og:type"          content="website" />
	    <meta property="og:title"         content="<?php echo $listName; ?>" />
	    <meta property="og:description"   content="<?php echo $details; ?>" />
	    <meta property="og:image"         content="<?php echo $photoSrc; ?>" />

</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>	
		<div id="shareWithFBDiv">	
			<div class="fb-share-button" data-href="http://tripick.net/showfulllist.php?username=eliran222&fbId=Null&id=<?php echo $listId; ?>" data-layout="button_count"></div>			
		</div>
</body>
</html>