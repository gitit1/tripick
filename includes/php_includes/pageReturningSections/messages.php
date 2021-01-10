<?php 
	if (isset($_GET['Message'])) 
	{				
		$getMsg = $_GET['Message'];
		if ($getMsg == 'emptyBox')
		{
			$msg="The Search box is empty";			
		}elseif($getMsg == 'notFound')
		{
			$msg="Nothing Found Here";			
		}
	}
	else
	{
		$display="none";
	}
?>
<?php 
	if (isset($_GET['actMsg'])) 
	{				
		$actMsg = $_GET['actMsg'];
		if ($actMsg == "activation_success"){
			$actMsg = "Activation Success, Your account is now activated. you can now log in";		
		}elseif($actMsg == "forgotFError"){
			$actMsg = "There is no match for that username with that temporary password in the system. We cannot proceed.";
		}elseif($actMsg == 'birthday_missing'){
			$actMsg = "could not proceed, your profile missing the birthday parameter, please add it.";
		}elseif($actMsg == 'loggedIn'){
			$actMsg ="You are already signed up";	
		}elseif($actMsg == 'relog'){
			$actMsg ="Please login again in order to update the new UserName";
		}else{
			$actMsg = "Sorry there seems to have been an issue activating your account at this time, please try again";
		}	
	}
?>
<?php 
	if (isset($_GET['fPassMsg'])) 
	{				
		$fPassMsg = $_GET['fPassMsg'];
		if ($fPassMsg == "fPassMsg"){
			$actMsg = "There is no match for that username with that temporary password in the system. We cannot proceed.";		
		}	
	}
?>

<?php if (isset($_GET['Message'])) {echo "<script type='text/javascript'>";echo "popUpOpen('searchErrorAlert');";echo "</script>";}?>									
<?php if (isset($_GET['actMsg'])){echo "<script type='text/javascript'>";echo "popUpOpen('actMsgAlert');";echo "</script>";}?>
<?php if (isset($_GET['fPassMsg'])){echo "<script type='text/javascript'>";echo "popUpOpen('actMsgAlert');";echo "</script>";}?>	