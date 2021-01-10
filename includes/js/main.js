function _(x){
	return document.getElementById(x);
}
function toggleElement(x){
	var x = _(x);
	if(x.style.display == 'block'){
		x.style.display = 'none';
	}else{
		x.style.display = 'block';
	}
}
/*Forms:*/
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "username"){
		rx = /[^a-z0-9_]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
}

function getMultipleCheckbox(inputdata) {
    var selectedItems = [];
    var count = 0;
    for(var i=0;i<inputdata.length;i++) {
        if(inputdata[i].checked) {
            selectedItems[count] = inputdata[i].value;
            count++;
        }
    }
    for(var loop=0; loop< selectedItems.length; loop++) {
        console.log(selectedItems[loop]);
    }
    return selectedItems;
}

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function fetch_select(val) //for city select
{
	var url = window.location.href;
   $.ajax({
     type: 'post',
     url: url,
     data: {
       get_option:val
     },
     success: function (response) {
       document.getElementById("cityName").innerHTML=response;
     }
   });
}


function fetch_select_act() //for city select
{
	var url = window.location.href;
	var countryName = _("countryName").value;
	if (countryName == "" || countryName.length == 0 || countryName == null){countryName = "Null";}	
	var cityName = _("cityName").value;
	if (cityName == "" || cityName.length == 0 || cityName == null){cityName = "Null";}
	var activityType = _("activityType").value;
	if (activityType == "" || activityType.length == 0 || activityType== null){activityName = "Null";}		
   $.ajax({
     type: 'post',
     url: url,
     data: {
       activity:activityType,
       country:countryName,
       city:cityName
     },
     success: function (response) {
       document.getElementById("activityName").innerHTML=response;
     }
   });
}

var $ncSelect = jQuery.noConflict();
$ncSelect(document).ready(function(){
	$(function(){	
		  $ncSelect('.countryBox').select2({
		  		  placeholder: "Select Country",
		  		  allowClear: true
		  });
	});    
});
/*pop up boxes:*/
function popUpOpen(id){
		var $ncColorBoxPop = jQuery.noConflict();
	    $ncColorBoxPop(document).ready(function(){				
			$ncColorBoxPop.colorbox({href:'#'+id, open:true, inline:true, transition:"none"});
		});	
}
function popUpOpenIframe(elWidth,elHeigth){
		var $ncColorBoxPop = jQuery.noConflict();
	    $ncColorBoxPop(document).ready(function(){				
			$ncColorBoxPop(".iframe").colorbox({iframe:true, fastIframe:true, width:elWidth+"px", height:elHeigth+"px", transition:"none", scrolling: false}); 
		});	
}

function popUpOpenIframeS(elWidth,elHeigth){
		var $ncColorBoxPop = jQuery.noConflict();
	    $ncColorBoxPop(document).ready(function(){				
			$ncColorBoxPop(".iframe").colorbox({iframe:true, 
												fastIframe:true, width:elWidth+"px", 
												height:elHeigth+"px", transition:"none",
												data:true, 
												scrolling: false,
												onClosed:function(){ location.reload(true); }
			}); 			
		});	
}
function popUpOpenIframeSwthR(elWidth,elHeigth){
		var $ncColorBoxPop = jQuery.noConflict();
	    $ncColorBoxPop(document).ready(function(){				
			$ncColorBoxPop(".iframe").colorbox({iframe:true, 
												fastIframe:true, width:elWidth+"px", 
												height:elHeigth+"px", transition:"none",
												data:true, 
												scrolling: false,												
			}); 			
		});	
}	
/*
var $ncColorBox = jQuery.noConflict();
$ncColorBox(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$ncColorBox(".group1").colorbox({rel:'group1'});
				$ncColorBox(".group2").colorbox({rel:'group2', transition:"fade"});
				$ncColorBox(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
				$ncColorBox(".group4").colorbox({rel:'group4', slideshow:true});
				$ncColorBox(".ajax").colorbox();
				$ncColorBox(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				$ncColorBox(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$ncColorBox(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$ncColorBox(".inline").colorbox({inline:true, width:"50%"});
				$ncColorBox(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});

				$ncColorBox('.non-retina').colorbox({rel:'group5', transition:'none'})
				$ncColorBox('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
				
				//Example of preserving a JavaScript event for inline calls.
				$ncColorBox("#click").click(function(){ 
					$ncColorBox('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
			
*/