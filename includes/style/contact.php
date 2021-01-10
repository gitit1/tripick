<?php
$field_name = $_POST['cf_name'];
$field_email = $_POST['cf_email'];
$field_message = $_POST['cf_message'];

$mail_to = 'contact@tripick.net';
$subject = 'Message from a site visitor '.$field_name;

$body_message = 'From: '.$field_name."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'Message: '.$field_message;

$headers = 'From: '.$field_email."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";

$mail_status = mail($mail_to, $subject, $body_message, $headers);

?>
<?php //check login status
	include_once("includes/php_includes/check_login_status.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Not Allowed</title>		
		<?php include_once("includes/php_includes/pageReturningSections/head.php"); 
			if($mobile){
				header("location: index.php");
			}
		?>	
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
				<nav class="indexNav"></nav>							
			    <div class="content">
			    	<div class="userMenu">
						<?php include_once("includes/php_includes/pageReturningSections/userMenu.php"); ?>
			    	</div>			    	
					<div class="mapGeneralSettings mapOpacity mapFixedHeight">					
						<section class="searchSection">
							<?php include_once("includes/php_includes/searchBox/searchBox.php"); ?>													
						</section>
						<form action="contact.php" method="post">
							Your name<br>
						    <input type="text" name="cf_name"><br>
							Your e-mail<br>
						    <input type="text" name="cf_email"><br>
							Message<br>
						    <textarea name="cf_message"></textarea><br>
							<input type="submit" value="Send">
							<input type="reset" value="Clear">
						</form>
					</div>
				</div>				
			</main>
			<!--
			<footer>
				<?php include_once("includes/php_includes/pageReturningSections/footer.php"); ?>			
			</footer>
			-->
		</div>	
	</body>
</html>	