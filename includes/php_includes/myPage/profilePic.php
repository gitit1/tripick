<?php
	$profile_pic_btn = '<a href="#" onclick="return false;" onmousedown="toggleElement(\'avatar_form\')">Change Avatar</a>';
	$avatar_form  = '<form id="avatar_form" enctype="multipart/form-data" method="post" action="includes/php_parsers/photo_system.php?username='.$userName.'">';
	$avatar_form .=   '<h4>Change your avatar</h4>';
	$avatar_form .=   '<input type="file" name="avatar" required>';
	$avatar_form .=   '<p><input type="submit" value="Upload"></p>';
	$avatar_form .= '</form>';
?>