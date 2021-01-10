function emptyElement(x){
	_(x).innerHTML = "";
}
function login(){	
	var e = _("email").value;
	var p = _("password").value;
	var url = window.location.href;		
	if(e == "" || p == ""){
		_("status").innerHTML = "Fill out all of the form data";
	} else {
		var url = window.location.href;
		_("status").innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", url);
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText.trim() == "login_failed"){
;					_("status").innerHTML = "Login unsuccessful, please try again.";		
				} else {				
					window.location = url.split('?actMsg')[0];		
				}
	        }
        }        
        ajax.send("login=login&e="+e+"&p="+p);
	}	
}

