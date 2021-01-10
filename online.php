//Check if browser supports W3C Geolocation API
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
} 
//Get latitude and longitude;
function successFunction(position) {
    var lat = position.coords.latitude;
    var long = position.coords.longitude;
}
     
<!DOCTYPE html> 
<html lang="en">
<head> 
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
<title>Reverse Geocoding</title> 
 
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript"> 
  var geocoder;
 
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
} 
//Get the latitude and the longitude;
function successFunction(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    codeLatLng(lat, lng)
}
 
function errorFunction(){
    alert("Geocoder failed");
}
 
  function initialize() {
    geocoder = new google.maps.Geocoder();
 
 
 
  }
 
  function codeLatLng(lat, lng) {
 
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
      console.log(results)
        if (results[1]) {
         //formatted address
         alert(results[0].formatted_address)
        //find country name
             for (var i=0; i<results[0].address_components.length; i++) {
            for (var b=0;b<results[0].address_components[i].types.length;b++) {
 
            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                    //this is the object you are looking for
                    city= results[0].address_components[i];
                    break;
                }
            }
        }
        //city data
        alert(city.short_name + " " + city.long_name)
 
 
        } else {
          alert("No results found");
        }
      } else {
        alert("Geocoder failed due to: " + status);
      }
    });
  }
</script> 
</head> 
<body onload="initialize()"> 
 
</body> 
</html>
<!--
<?php
    require_once('includes/php_includes/geoplugin.class.php');
    $geoplugin = new geoPlugin();
    $geoplugin->locate();

    echo "Geolocation results for {$geoplugin->ip}: <br />\n".
        "City: {$geoplugin->city} <br />\n".
        "Region: {$geoplugin->region} <br />\n".
        "Area Code: {$geoplugin->areaCode} <br />\n".
        "DMA Code: {$geoplugin->dmaCode} <br />\n".
        "Country Name: {$geoplugin->countryName} <br />\n".
        "Country Code: {$geoplugin->countryCode} <br />\n".
        "Longitude: {$geoplugin->longitude} <br />\n".
        "Latitude: {$geoplugin->latitude} <br />\n".
    "Currency Code: {$geoplugin->currencyCode} <br />\n".
    "Currency Symbol: {$geoplugin->currencySymbol} <br />\n".
    "Exchange Rate: {$geoplugin->currencyConverter} <br />\n";
?>

<head>
	<script>
if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position){

        initialize(position.coords.latitude,position.coords.longitude);
    }); 
}

function initialize(lat,lng) {
    //directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
    //directionsService = new google.maps.DirectionsService();
    var latlng = new google.maps.LatLng(lat, lng);

    //alert(latlng);
    getLocation(latlng);
}

function getLocation(latlng){

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'latLng': latlng}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var loc = getCountry(results);
                    alert("location is::"+loc);
                }
            }
        });

}

function getCountry(results)
{
    for (var i = 0; i < results[0].address_components.length; i++)
    {
        var shortname = results[0].address_components[i].short_name;
        var longname = results[0].address_components[i].long_name;
        var type = results[0].address_components[i].types;
        if (type.indexOf("country") != -1)
        {
            if (!isNullOrWhitespace(shortname))
            {
                return shortname;
            }
            else
            {
                return longname;
            }
        }
    }

}

function isNullOrWhitespace(text) {
    if (text == null) {
        return true;
    }
    return text.replace(/\s/gi, '').length < 1;
}
	</script>
</head>
-->
<!--
<p>Click the button to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<p id="demo"></p>

<script>
var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;	
}
</script>

</body>
</html>
-->