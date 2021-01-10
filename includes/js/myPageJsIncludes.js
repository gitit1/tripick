//*************friends Requests:*************//
function friendToggle(type,user,elem,username){
	var conf = confirm("Press OK to confirm the '"+type+"' action for user "+ user);
	
	if(conf != true){
		return false;
	}
	_(elem).innerHTML = 'please wait ...';
	var ajax = ajaxObj("POST", "includes/php_parsers/friend_system.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "friend_request_sent"){
				_(elem).innerHTML = 'OK Friend Request Sent';
			} else if(ajax.responseText == "unfriend_ok"){
				_(elem).innerHTML = '<button onclick="friendToggle(\'friend\',\'<?php echo $u; ?>\',\'friendBtn\')">Request As Friend</button>';
			} else {
				alert(ajax.responseText);
				_(elem).innerHTML = 'Try again later';
			}
		}
	}
	ajax.send("type="+type+"&user="+user+"&username="+username);
}
function blockToggle(type,blockee,elem,username){
	var conf = confirm("Press OK to confirm the '"+type+"' action on " +blockee);
	if(conf != true){return false;}
	_(elem).innerHTML = 'please wait ...';
	var ajax = ajaxObj("POST", "includes/php_parsers/block_system.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "blocked_ok"){
				_(elem).innerHTML = "<button onclick='blockToggle('unblock',"+elem+",'blockBtn')'>Unblock User</button>";
			} else if(ajax.responseText == "unblocked_ok"){
				_(elem).innerHTML = "<button onclick='blockToggle('block',"+elem+",'blockBtn')'>Block User</button>";
			} else {
				alert(ajax.responseText);
				_(elem).innerHTML = 'Try again later';
			}
		}
	}
	ajax.send("type="+type+"&blockee="+blockee+"&username="+username);
}
function friendReqHandler(action,reqid,user1,elem,username){
	var conf = confirm("Press OK to '"+action+"' this friend request.");
	if(conf != true){
		return false;
	}
	_(elem).innerHTML = "<span class='friendReqSpan'>processing ...</span>";
	var ajax = ajaxObj("POST", "includes/php_parsers/friend_system.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "accept_ok"){
				_(elem).innerHTML = "<span class='friendReqSpan'><b>Request Accepted!</b><p>You and "+user1+" are now friends</p></span>";
			} else if(ajax.responseText == "reject_ok"){
				_(elem).innerHTML = "<span class='friendReqSpan'> <b>Request Rejected</b><p>You chose to reject friendship with "+u+"</p></span>";
			} else {
				_(elem).innerHTML = ajax.responseText;
			}
		}
	}
	ajax.send("action="+action+"&reqid="+reqid+"&user1="+user1+"&username="+username);
}
//*************pm_inbox:*************//
function replyToPm(pmid,user,ta,btn,osender){	
	var data = _(ta).value;
	if(data == ""){
		_(ta).value = "The textBox is empty";
		return false;
	}
	var ajax = ajaxObj("POST", "includes/php_parsers/pm_system.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			var datArray = ajax.responseText.split("|");
			if(datArray[0] == "reply_ok"){
				var rid = datArray[1];
				data = data.replace(/\</g,"&lt;").replace(/\>/g,"&gt;").replace(/\n/g,"<br />").replace(/\r/g,"<br />");
				//_("pm_"+pmid).innerHTML += '<br><span class="notificatioSectionMsgReplyNowLabel">Reply by you just now:</span><span class="notificatioSectionMsgReplyNowSpan">'+data+'</span>';
				//_("pm_"+pmid).innerHTML += '<br><span class="notificatioSectionMsgReplyNowLabel">Reply has been sent</span>';
				expand("pm_"+pmid);
				_(ta).value = "Reply has been sent";
			} else {
				alert(ajax.responseText);
			}
		}
	}
	ajax.send("action=pm_reply&pmid="+pmid+"&user="+user+"&data="+data+"&osender="+osender);
}
function deletePm(pmid,wrapperid,wrapperid2,originator,username,action){
	var conf = confirm(originator+" Press OK to confirm deletion of this message and its replies");
	if(conf != true){
		return false;
	}
	var ajax = ajaxObj("POST", "includes/php_parsers/pm_system.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true){
			if(ajax.responseText == "delete_ok"){
				_(wrapperid).style.display = 'none';
				_(wrapperid2).style.display = 'none';
			}else if(ajax.responseText == "delete_ok_note")
			{
				_(wrapperid).style.display = 'none';			
			}else 
			{
				alert(ajax.responseText);
			}
		}
	}
	if (action == 'delete_pm'){
		ajax.send("action=delete_pm&pmid="+pmid+"&originator="+originator+"&username="+username);
	}else{
		ajax.send("action=delete_pm_note&pmid="+pmid+"&username="+username);
	}
	
}
function markRead(pmid,originator,username,action){
	var ajax = ajaxObj("POST", "includes/php_parsers/pm_system.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "read_ok_msg"){
				alert("Message has been marked as read");
			} else if(ajax.responseText == "read_ok_note"){
				console.log("Note has been marked as read");
			}else if(ajax.responseText == "read_ok_friends"){
				console.log('Friend has been marked as read');
			}else{
				alert(ajax.responseText);
				alert('error');				
			}
		}
	}
	if (action == 'mark_as_read'){
		ajax.send("action=mark_as_read&pmid="+pmid+"&originator="+originator+"&username="+username);
	}else if(action == 'mark_as_read_note'){
		ajax.send("action=mark_as_read_note&pmid="+pmid+"&username="+username);
	}else{				
		ajax.send("action=mark_as_read_friends&username="+username);
	}
}
function expand(element){
	var target = document.getElementById(element);
	var h = target.offsetHeight;
	var sh = target.scrollHeight;
	var loopTimer = setTimeout('expand(\''+element+'\')',8);
	if (h < sh){
		h += 5;
	}else{
		clearTimeout (loopTimer);
	}
	target.style.height = h+"px";
}

function retract(element){
	var target = document.getElementById(element);
	var h = target.offsetHeight;
	var loopTimer = setTimeout('retract(\''+element+'\')',8);
	if (h > 0){
		h -= 5;
	}else{
		target.style.height = "0px";
		clearTimeout (loopTimer);
	}
	target.style.height = h+"px";
}

var $ncColorBoxMyPage = jQuery.noConflict();
$ncColorBoxMyPage(document).ready(function(){
	$ncColorBoxMyPage(".group1").colorbox({rel:'group1'});
});