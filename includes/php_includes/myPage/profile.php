<?php
	if( ($isOwner = "yes") && ($_GET['u'] == $user) ){
		$edit = "block";
		$myProfile = "block";
		$otherProfile = "none";
	}else{
		$edit = "none";
		$myProfile = "none";
		$otherProfile = "block";		
	}
	
	if($mobile){
		$avt = $profile_pic1;
		$popUpMsg = 'popUpOpenIframe(900,800)';
	}elseif($sex == "Male"){
		$avt = '<img src="images/avatardefaultMale.png" alt="'.$u1.'">';
		$popUpMsg = 'popUpOpenIframe(500,400)';
	}else{ 
		$avt = '<img src="images/avatardefaultFemale.png" alt="'.$u1.'">';
		$popUpMsg = 'popUpOpenIframe(500,400)';
	}		

?>
<script>
	function profileSectionEdit(){
		var viewS = document.getElementById('profileSectionViewData');
		var updateS = document.getElementById('profileSectionUpdateData');
		var labels = document.getElementById('profileSectionLabels');
		viewS.style.display = 'none';
		updateS.style.display = 'block';
		labels.style.color = '#233038';
		
	}
	function profileSectionSave(){
		var viewS = document.getElementById('profileSectionViewData');
		var updateS = document.getElementById('profileSectionUpdateData');
		var labels = document.getElementById('profileSectionLabels');
		viewS.style.display = 'block';
		updateS.style.display = 'none';
		labels.style.color = '#ffffff';
	}		
	function updateProfile(){
		var url = window.location.href;
		var userName = _("profileSectionUserName").value;		
		var userFbId = _("profileSectionFbid").value;
		var userEmail = _("profileSectionEmail").value;	
		var uName = _("profileSectionUserNameInput").value;
		var fName = _("profileSectionFirstNameInput").value;
		var lName = _("profileSectionLastNameInput").value;
		var email = _("profileSectionEmailInput").value;
		var birthday = _("profileSectionBirthdayInput").value;
		var country = _("countryName").value;
		var about = _("profileSectionAboutTextarea").value;
		if (about == "" || about.length == 0 || about == null){about = "";}	
		var profile_status = _("profile_status");
		
		profile_status.innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "includes/php_includes/myPage/updateProfile.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText.trim() != "signup_success"){
					profile_status.innerHTML = ajax.responseText.trim();
				} else {
					if (userName == uName){
						window.location.href = "http://tripick.net/mypage.php?id=profile&u="+userName;
					}else{
						uName == userName;
						window.location.href = "http://tripick.net/index.php?actMsg=relog";
						profile_status.innerHTML = "The userName will be updated in your next Login";
					}
					
				}
	        }
        }
        ajax.send("userName="+userName+"&userFbId="+userFbId+"&userEmail="+userEmail+"&uName="+uName+"&fName="+fName+"&lName="+lName+"&email="+email
        		  +"&birthday="+birthday+"&country="+country+"&about="+about);

	}			
</script>
<div class="mapGeneralSettings mapOpacity mapFixedHeight">
	<h1 class='profileSectionPageHeader'><?php  echo $u; ?> Profile</h1>
	<section id="profileSectionLabels">		
		<label class="profileSectionUserNameLabel">User Name:</label>
		<label class="profileSectionFirstNameLabel">First Name:</label>
		<label class="profileSectionLastNameLabel">Last Name:</label>
		<label class="profileSectionEmailLabel">Email Adress:</label>
		<label class="profileSectionBirthdayLabel">Birthday:</label>
		<label class="profileSectionCountryLabel">Country:</label>
		<label class="profileSectionAboutLabel">About Myself:</label>
	</section>
	<section id="profileSectionViewData" style="display:<?php $profileSectionViewData; ?>">
		
		<div class="myProfile" style="display:<?php echo $myProfile; ?>"><?php echo $avt;?></div>
		<div class="otherProfile" style="display:<?php echo $otherProfile;?>"><?php echo $profile_pic1; ?></div>
		
		<span class="profileSectionUserNameSpan"><?php  echo $u; ?></span>
		<span class="profileSectionFirstNameSpan"><?php  echo $firstname; ?></span>
		<span class="profileSectionLastNameSpan"><?php  echo $lastname; ?></span>
		<span class="profileSectionEmailSpan"><?php  echo $email; ?></span>
		<span class="profileSectionBirthdaySpan"><?php  echo date_format(new DateTime($birthday), 'd/m/Y')?></span>
		<span class="profileSectionCountrySpan"><?php  echo $country; ?></span>
		<div class="profileSectionAboutSpan"><span><?php  echo $about; ?></span></div>
		<span class="profileSectionStatus"></span>
		
		<div class="friendsStatusProfile" style="display:<?php echo $friendBtn;?>">
	  		<p><span id="friendBtn"><?php echo $friend_button; ?></span></p>
	  		<!--<p><span id="blockBtn"><?php echo $block_button; ?></span></p>-->
	  		<a href="template_pm.php?u=<?php  echo $u; ?>" onclick="<?php echo $popUpMsg; ?>" class="iframe generalBtn btnImgMessage">
	  			<img src="images/btn/message.png" alt="Send Message" title="Send Message"/>
	  		</a>
	    </div>

		<?php if (!$mobile){echo "<input type=\"button\" id=\"profileSectionUpadateDataButton\" value=\"Edit\" onclick=\"profileSectionEdit();\" style=\"display:<?php echo $edit;?>\">";}?>

	</section>
	<section id="profileSectionUpdateData">
		<h2>Edit your info</h2>
		<p>Click on the info that you want to edit</p>
		<form>
			<input type='text' class="chosen-text" id="profileSectionUserNameInput" onclick="this.value=''" placeholder="Enter Your UserName" value='<?php  echo$u; ?>' maxlength="16">
			<!--onblur="checkusername()"-->
			<span id="unamestatusPrf"></span>
			<input type='text' class="chosen-text" id="profileSectionFirstNameInput" onclick="this.value=''" placeholder="Enter Your First Name" value='<?php  echo$firstname; ?>'>
			<input type='text'  class="chosen-text" id="profileSectionLastNameInput" onclick="this.value=''" placeholder="Enter Your Last Name" value='<?php  echo$lastname; ?>'>
			<input type='text' class="chosen-text"  id="profileSectionEmailInput" onclick="this.value=''" placeholder="Enter Your Email" value='<?php  echo$email; ?>'>
			<input type='date' id="profileSectionBirthdayInput" class="chosen-date" onclick="this.value=''" value='<?php  echo$birthday; ?>'>
	    	<div id="profileSectionCountryInput">
		    	<select id="countryName" name="countryName" onchange="fetch_select(this.value);"  class="chosen-select chosen-select_profile countryBox">
		      		<?php include("includes/php_includes/pageReturningSections/template_country_list.php"); ?>
		    	</select>
	    	</div>	    				
			<textarea id="profileSectionAboutTextarea"></textarea>			
			<input type="hidden" id="profileSectionUserName" value="<?php echo  $userName; ?>" >
			<input type="hidden" id="profileSectionFbid" value="<?php echo  $fbId; ?>" >
			<input type="hidden" id="profileSectionEmail" value="<?php echo  $email; ?>" >
			<?php if ($fbId == 'Null'){
				echo"<a id=\"profileSectionUpadatePassword\" href='changePassword.php?userName=$userName' 
					  onclick=\"popUpOpenIframe(450,400)\" class=\"iframe\" >Change Password</a>";					
			}
			?>
			<?php if (!$mobile){echo "<input type=\"button\" id=\"profileSectionSaveDataButton\" onclick=\"updateProfile()\" value=\"Save\">";} ?>
			<span id="profile_status"></span>
		</form>
		<div id="profile_pic_box2"><?php if($fbId=='Null'){echo $profile_pic_btn;  echo $avatar_form;} ?></div>
	</section>	
</div>
<div class="mobileBtnsProfile">
<?php if ($mobile){include("includes/php_includes/pageReturningSections/mobilebtns.php");} ?>
</div>
<div class="clear"></div>