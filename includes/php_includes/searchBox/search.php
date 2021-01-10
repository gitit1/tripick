<?php
	include "../db.php";
	$find =$_POST['find']; //the search term
	$link = $_SERVER['HTTP_REFERER']; //get the link witch the request came from
	$root =  $_SERVER['SERVER_NAME'];
	function processReplacement($one, $two) //function to make the first character a capital letter
	{
	  return $one . strtoupper($two);
	}
		
	if (empty($find))
	{ //check if search box is empty
		if ( strpos($link,'?Message=') !== false )  //check if link come from previous error massage (in page like index)
		{
			$linkParts = explode('?Message=', $link); //part the url so that we get only the link without the error message
			$newLink = $linkParts[0]; //part the url so that we get only the link without the error message
			header('Location: ' . $newLink . "?Message=". urlencode(emptyBox)); //return to previous page to return error message- search box is empty
		}
		elseif ( strpos($link,'?') !== false ) //check if link come from another linked page (like country.php)
		{
			$linkParts = explode('&Message=', $link); //part the url so that we get only the link without the error message
			$newLink = $linkParts[0]; //part the url so that we get only the link without the error message
			header('Location: ' . $newLink . "&Message=". urlencode(emptyBox)); //return to previous page to return error message- search box is empty
		}
		else //check if link come from clean page (like index.php with no error message)
		{		
			header('Location: ' . $link . "?Message=". urlencode(emptyBox)); //return to previous page to return error message- search box is empty
		}				
	}
	else //if search box not empty we continue to try and get the reuested country:
	{
		$fullString = preg_replace("/(^|[^a-zA-Z])([a-z])/e","processReplacement('$1', '$2')", $find); //search for full string (like: Argentina)
		$firstWordOfString = explode(' ',trim($find)); //search for only first word string (like: Antigua and Barbuda -> Antigua) //that because preg_replace will replace it with: "Antigua And Barbuda" and it will not match to the query
		$firstWordOfString = preg_replace("/(^|[^a-zA-Z])([a-z])/e","processReplacement('$1', '$2')", $firstWordOfString[0]);
		$queryCountry = "SELECT * FROM countriesTable WHERE ( (countryName LIKE '%$fullString%') OR (countryName LIKE '%$firstWordOfString%') )"; //the query for the search in the DB
		$result = mysqli_query($conn_countries, $queryCountry); //return the result from the DB
	 	
	 	if (!$result)  //check if there is error in the query search
	 	{
	 		die(mysqli_error());
	 	}
	  	if (mysqli_num_rows($result) == 0) //if there is no result (not found)
	  	{	  		
			if ( strpos($link,'?Message=') !== false )  //check if link come from previous error massage (in page like index)
			{
				$linkParts = explode('?Message=', $link); //part the url so that we get only the link without the error message
				$newLink = $linkParts[0]; //part the url so that we get only the link without the error message
				header('Location: ' . $newLink . "?Message=". urlencode(notFound)); //return to previous page to return error message- search box is empty
			}
			elseif ( strpos($link,'?') !== false ) //check if link come from another linked page (like country.php)
			{
				$linkParts = explode('&Message=', $link); //part the url so that we get only the link without the error message
				$newLink = $linkParts[0]; //part the url so that we get only the link without the error message
				header('Location: ' . $newLink . "&Message=". urlencode(notFound)); //return to previous page to return error message- search box is empty
			}
			else //check if link come from clean page (like index.php with no error message)
			{		
				header('Location: ' . $link . "?Message=". urlencode(notFound)); //return to previous page to return error message- search box is empty
			}		  		
		}
		else //there is a result
		{
			//get the country and continent and redirect to the country page
			while($row = mysqli_fetch_assoc($result))
			{
				$continent = $row["countryContinent"];
				$country = $row["countryName"];					
			}
			header('Location: ../../../country.php?continent=' . $continent . '&country=' . $country);
		}					
}	
?>	