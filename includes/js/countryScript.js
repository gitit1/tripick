var $ncCountry = jQuery.noConflict();
$ncCountry(document).ready(function(){
	$ncCountry("#countryPageCountryReadMoreLink").on("click",function() {
		$ncCountry("#countryPageReadMore").css("display","block");
		$ncCountry("#countryPageCountryReadMoreLink").css("visibility", "hidden");
		
		

		///////////NEED FIXING - FOOTER///////////////	
		//$("#footer").css("background-color","yellow");	
		//$("#footer").css("position","relative");
		//$("#content").css("min-height","100%");
		//$("#footer").css("margin-top","100%");
		//$("#footer").css("bottom","0");
		///////////NEED FIXING - FOOTER///////////////
		
		
	 });
	
	$ncCountry("#countryPageCountryReadLessLink").on("click",function() {
		$ncCountry("#countryPageReadMore").css("display","none"); 		
		$ncCountry("#countryPageCountryReadMoreLink").css("visibility", "visible");
		
		
		///////////NEED FIXING - FOOTER///////////////
		//$("#footer").css("background-color","red");
		//$("#footer").css("position","absolute");
		//$("#footer").css("bottom","0");

		///////////NEED FIXING - FOOTER///////////////
				
	 });	
/*
 	  //LightBox - Cities
	  $("#countryPagelightboxOpenCitiesLink").click(function(){
	 		$("#countryPagelightCitiesLink").css("display", "block");
			$("#countryPagefadeCitiesLink").css("display", "block"); 	
	  });
	
	  $("#countryPagelightboxCloseCitiesLink").click(function(){
	 		$("#countryPagelightCitiesLink").css("display", "none");
			$("#countryPagefadeCitiesLink").css("display", "none"); 	
	  });
 	  //LightBox - Map
	  $("#countryPagelightboxOpenMapLink").click(function(){
	 		$("#countryPagelightMapLink").css("display", "block");
			$("#countryPagefadeMapLink").css("display", "block"); 	
	  });
	
	  $("#countryPagelightboxCloseMapLink").click(function(){
	 		$("#countryPagelightMapLink").css("display", "none");
			$("#countryPagefadeMapLink").css("display", "none"); 	
	  });
*/

		$ncCountry(".getCityId").on('click',function(e){
			var id = $(e.target).attr('value');
		 	$ncCountry(".countryPagecityBoxDisable").css("display", "none");
		 	$ncCountry('#'+id).css("display", "block");
		 });
		 
		$ncCountry(".getActId").on('click',function(e){
			var id = $(e.target).attr('value');
		 	$ncCountry(".showFullListLightBoxDisable").css("display", "none");
		 	$ncCountry('#'+id).css("display", "block");
		 });		 
});	
var $ncColorBox = jQuery.noConflict();
$ncColorBox(document).ready(function(){
	$ncColorBox(".group1").colorbox({rel:'group1'});
	$ncColorBox(".iframe").colorbox({iframe:true, width:"80%", height:"80%", transition:"none"});
	$ncColorBox(".inline").colorbox({inline:true, width:"50%", transition:"none"});
});