<?php	//GET CITY AND COUNTRY
   if ($filter){
   	$ch_css = 'chosen-select_filter';
   }else{
   	$ch_css = 'chosen-select';
   }        
   if(isset($_POST['get_option']))
   {   		
	    $defualtCty ="";		      
	    $country = $_POST['get_option'];
	    $queryCity = "SELECT * FROM citiesTable Where countryName = '" . $country . "'";
		$result = mysqli_query($conn_countries, $queryCity);
   		$try = "";
		echo "<select id=\"cityName\" class=\"$ch_css countryBox\" placeholder=\"Select City\">";
				echo "<option></option>";	
	    while ($row = mysqli_fetch_assoc($result)){
	        echo "<option>" . $row['cityName'] . "</option>";																		
		}
		echo "</select>";		   
	    exit;
   }elseif(isset($_GET["cty"])){
   		$defualtCty ="";
		$country = $_GET["cty"];
	    $queryCity = "SELECT * FROM citiesTable Where countryName = '" . $country . "'";
		$result = mysqli_query($conn_countries, $queryCity);
		
   		$try = "";
		$try .= "<select id=\"cityName\" class=\"$ch_css countryBox\" placeholder=\"Select City\">";	
			$try .= "<option></option>";		
	    while ($row = mysqli_fetch_assoc($result)){
	        $try .= "<option>" . $row['cityName'] . "</option>";																			
		}
		$try .= "</select>";  	
   }else{
   		$try = "";
		$try = "<select id=\"cityName\" class=\"$ch_css countryBox\" placeholder=\"Select City\">";
			$try .= "<option></option>";
		$try .= "</select>"; 	
   }   	
?>