<?php	//GET CITY AND COUNTRY
   if ($filter){
   	$ch_css = 'chosen-select_filter';
   }else{
   	$ch_css = 'chosen-select';
   }        
   if(isset($_POST['activity']))
   {   		
	    $defualtCty ="";
		$activity = $_POST['activity'];      
	    $country = $_POST['country'];
		$city = $_POST['city'];
	    if ( ($country == 'Null') && ($city == 'Null') && ($activity == 'All Activities/Sights')){//000
	    	$queryAct = "SELECT * FROM activities  Where activityType LIKE '%$activity%'";
	    }elseif ( ($country == 'Null') && ($city == 'Null') && ($activity != 'All Activities/Sights')){//001
	    	$queryAct = "SELECT * FROM activities";
	    }elseif ( ($country == 'Null') && ($city != 'Null') && ($activity == 'All Activities/Sights')){//010
			$queryAct = "SELECT * FROM activities WHERE cityName='$city'";
		}elseif ( ($country == 'Null') && ($city != 'Null') && ($activity != 'All Activities/Sights')){//011
			$queryAct = "SELECT * FROM activities WHERE cityName='$city' AND activityType LIKE '%$activity%'";
		}elseif ( ($country != 'Null') && ($city == 'Null') && ($activity == 'All Activities/Sights')){//100
			$queryAct = "SELECT * FROM activities WHERE countryName='$country'";
		}elseif ( ($country != 'Null') && ($city == 'Null') && ($activity != 'All Activities/Sights')){//101
			$queryAct = "SELECT * FROM activities WHERE countryName='$country' AND activityType LIKE '%$activity%'";
		}elseif ( ($country != 'Null') && ($city != 'Null') && ($activity == 'All Activities/Sights')){//110
			$queryAct = "SELECT * FROM activities WHERE countryName='$country' AND cityName='$city'";
		}elseif ( ($country != 'Null') && ($city != 'Null') && ($activity != 'All Activities/Sights')){//111
			$queryAct = "SELECT * FROM activities WHERE countryName='$country' AND cityName='$city' AND activityType LIKE '%$activity%'";
		}
	    
		$result = mysqli_query($conn_actlst, $queryAct);
   		$tryAct = "";
		echo "<select id=\"activityName\" class=\"$ch_css countryBox\" placeholder=\"Activity Name\">";
				echo "<option></option>";	
	    while ($row = mysqli_fetch_assoc($result)){
	        echo "<option>" . $row['activityName'] . "</option>";																		
		}
		echo "</select>";		   
	    exit;
   }elseif(isset($_POST['cty]'])){
   		$country = $_POST['cty'];
   		$queryAct = "SELECT * FROM activities WHERE countryName='$country'";
		$result = mysqli_query($conn_actlst, $queryAct);
   		$tryAct  = "";
		$tryAct  = "<select id=\"activityName\" class=\"$ch_css countryBox\" placeholder=\"ActivityName\">";
		while ($row = mysqli_fetch_assoc($result)){
	        $tryAct  .=  "<option>" . $row['activityName'] . "</option>";
		}
		$tryAct  .= "</select>";
		
   }else{
   		$queryAct = "SELECT * FROM activities";
		$result = mysqli_query($conn_actlst, $queryAct);
   		$tryAct  = "";
		$tryAct  = "<select id=\"activityName\" class=\"$ch_css countryBox\" placeholder=\"ActivityName\">";
		$tryAct  .=  "<option></option>";
		while ($row = mysqli_fetch_assoc($result)){			
			$tryAct  .=  "<option>" . $row['activityName'] . "</option>";
		}
		$tryAct  .= "</select>";
   }
?>