<!--NOT ACTIVE
<?php  	    
if (isset($_GET['Message'])) 
{
	if ($search == "true"){ //if its a message of search box
		echo "<script type='text/javascript'>";
		echo "$(document).ready(function(){				
				$.colorbox({href:'#searchErrorAlert', open:true, inline:true});  
			 });";
		echo "</script>";
	}else if ($search == "false"){ //if its a message of login status
		echo "<script type='text/javascript'>";
		echo "$(document).ready(function(){			
				$('#status').html('$msg');
			 });";
		echo "</script>";
	}
}									
?>

-->