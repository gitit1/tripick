var $ncSearchBox = jQuery.noConflict();	

$ncSearchBox(document).ready(function(){
	//SEARCH BOX AUTO COMPLETE//
	$ncSearchBox("#autocomplete-ajax").keypress(function () {
		$ncSearchBox("#autocomplete-ajax").css("-moz-border-radius", "0 0 0 0");
		$ncSearchBox("#autocomplete-ajax").css("-webkit-border-radius", "0 0 0 0");
    });  

	$ncSearchBox("#autocomplete-ajax").focusout(function () {
		$ncSearchBox("#autocomplete-ajax").css("-moz-border-radius", "0 0 0 10px");
		$ncSearchBox("#autocomplete-ajax").css("-webkit-border-radius", "0 0 0 10px");
    }); 
 
	$ncSearchBox("#autocomplete-ajax-x").focusout(function () {
		$ncSearchBox("#autocomplete-ajax-x").css("-moz-border-radius", "0 0 0 10px");
		$ncSearchBox("#autocomplete-ajax-x").css("-webkit-border-radius", "0 0 0 10px");
    }); 
	//SEARCH BOX ALERT//
	$ncSearchBox("#searchErrorAlertClose").on("click",function() 
	{
		$ncSearchBox("#searchErrorAlert").css("display","none");
    }); 
     
});