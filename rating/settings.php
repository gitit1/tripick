<?php 
$rating_tableName     = 'ratings';
$rating_unitwidth     = 15;
$rating_dbname        = 'xxx';
$units=5;
?>
<?php
	$dbhost = "localhost";	
	
	$dbCountries = "u363954600_trip";
	$dbCountriesPass = "trip12345";
	
	$dbQuery = "u363954600_query";
	$dbQueryPass = "query12345";
	
	$dbUsers = 'u363954600_users'; 
    $dbUsersPass = "users12345";
	
	$dbActLst = 'u363954600_lists';
	$dbActLstPass = "lists12345";
	 
    $conn_users = mysqli_connect($dbhost, $dbUsers,$dbUsersPass, $dbUsers);   
    $conn_countries = mysqli_connect($dbhost, $dbCountries, $dbCountriesPass, $dbCountries);
	$conn_query = mysqli_connect($dbhost, $dbQuery, $dbQueryPass, $dbQuery);
	$conn_actlst = mysqli_connect($dbhost, $dbActLst , $dbActLstPass, $dbActLst);
	$con = $conn_actlst; 
	//testing connection success
    if(mysqli_connect_errno()) {
    	die("DB connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    }
?>
