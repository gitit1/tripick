<div class="mapGeneralSettings mapOpacityFixed mapAutoHeight mapWithoutBorder">
	<div>
			<div id="notificatioSectionNotesBox">
				<!--<h2 class='notificatioSectionNotesBoxHeader0'>Notifications</h2>-->
				<?php if( ($note == 0) && (!$mobile)){echo "<h4 class='notificatioSectionNotesBoxHeader1'>You Dont have any new Notifications</h4>";
					  }elseif((!$mobile)){echo "<h4 class='notificatioSectionNotesBoxHeader2'>You Have <b>$note</b> new notes</h4>";}?>			
					<!--<a class='noteSectionSeeNotesLink' href='#noteSectionSeeNotesBox' onclick="toggleElement('noteSectionSeeNotesBox'); markRead('Null','Null','<?php echo $userName; ?>','mark_as_read_note')">
					<p>Click here to see your notifications</p></a>-->
					<div id='noteSectionSeeNotesBox'>
						<span><?php echo $notification_list; ?></span>
					</div>						
			</div>
	</div>
</div>
<div class="mobileBtnsNotifications">
<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");} ?>
</div>
<div class="clear"></div>