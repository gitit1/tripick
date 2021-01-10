<div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">
	<div>
	  	    <div id="notificatioSectionMsgBox">
	  	    	<!--<h2 class='notificatioSectionMsgBoxHeader0'>Messages</h2>-->	  	    	
				<?php if(($message == 0) && (!$mobile)){echo "<h4  class='notificatioSectionMsgBoxHeader'>You Dont have any new Messages</h4>";
					  }elseif((!$mobile)){echo "<h4 class='notificatioSectionMsgBoxHeader2'>You Have <b>$message</b> new messages</h4>";}?>			
					<!--<a class='noteSectionSeeMsgLink' href='#noteSectionSeeMsgBox' onclick="toggleElement('noteSectionSeeMsgBox')">
					<p>Click here to see your messages</p></a>-->
					<div id='noteSectionSeeMsgBox'>
						<span><?php echo $mail; ?></span>
					</div>
	 	    	
	  	    </div>
	</div>
</div>
<div class="mobileBtnsMsgs">
<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");} ?>
</div>
<div class="clear"></div>