<?php include_once("../php_includes/db.php"); ?>
<?php	
	session_start();
	require_once __DIR__ . '/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php';
	
	$fb = new Facebook\Facebook([
	  'app_id' => '768628683249593',
	  'app_secret' => '42413e7cd6aad6c720a35292c95f9c06',
	  'default_graph_version' => 'v2.4',
	  ]);
	
	$helper = $fb->getRedirectLoginHelper();
	try {
	  $accessToken = $helper->getAccessToken();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  // When Graph returns an error
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  // When validation fails or other local issues
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
	
	if (isset($accessToken)) {
	  // Logged in!
	  $_SESSION['facebook_access_token'] = (string) $accessToken;
	
	  // Now you can redirect to another page and use the
	  // access token from $_SESSION['facebook_access_token']
	  //echo "Got access.<br>";
	}

$request = $fb->request('GET', '/me?fields=id,name,email,gender,birthday,location,first_name,middle_name,last_name');
$request->setAccessToken($_SESSION['facebook_access_token']);

// Send the request to Graph
  try {
    $response = $fb->getClient()->sendRequest($request);
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

  $graphNode = $response->getGraphNode();
  $user = $response->getGraphUser();

  $userName = $graphNode->getField('name');
  $fbId = $graphNode->getField('id');
  $userEmail = $graphNode->getField('email');
  $userFirstName = $user->getField('first_name');
  $userLastName = $user->getField('last_name');
  $userGender = $graphNode->getField('gender');
  $userBirthday = $user->getBirthday();     
  $image = "http://graph.facebook.com/" . $graphNode->getField('id') . "/picture?type=normal";


  //echo $response->getGraphNode()->getField('hometown') ->getField('name') . "<br>";
  //echo $response->getGraphNode()->getField('location') ."<br>";
  
  //$city_country = explode(',',$response->getGraphNode()->getField('hometown')->getField('name'));
 // echo $city_country[count($city_country) - 1] . "<br>";
  
  //echo  $city_country . "<br>";
  //var_dump($response->getGraphNode()->getField('hometown')->getField('name'));
  
 // echo "<img src=" . "$image" . " >";


	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	
	$sql = "SELECT email FROM users WHERE email='$userEmail' LIMIT 1";
    $query = mysqli_query($conn_users, $sql);
    $numrows = mysqli_num_rows($query);
	$row = mysqli_fetch_array($user_query, MYSQLI_ASSOC);
	$login_fbId  = $row["fbId"];
	if($numrows > 0){
		//header('Location: ../php_includes/login/login.php?fEmail=' . $email . '&fbId='. $fbId . '');
	   		//$link = $_SERVER['HTTP_REFERER'];
			//$linkParts = explode('#', $link); 
			//$newLink = $linkParts[0];
			if ($login_fbId == 'Null'){
				echo "<script>alert('error')</script>";
				include_once("../php_includes/login/logout.php");
				//echo "<script>console.log($login_fbId);</script>";
				//echo "<script>console.log($sql);</script>";
				//echo "<script>console.log('1');</script>";				
			}else{
				header('Location: ../../index.php');
				//echo "<script>console.log($login_fbId);</script>";
				//echo "<script>console.log($sql);</script>";
				//echo "<script>console.log('2');</script>";	
			}				
	}else{
				//echo "<script>console.log($login_fbId);</script>";
				//echo "<script>console.log($sql);</script>";
				//echo "<script>console.log('3');</script>";		
		  if ($userGender == "female"){
		  	$sex = 'f';
		  }else{
		  	$sex = 'm';
		  }
		  
		
		  if ($userEmail == null){
		  	$userEmail = $fbId."@facebook.com";
		  }
	 
		  if ($userBirthday==''){
		  	$sql = "INSERT INTO notifications (username, email,initiator,app, note, did_read, date_time,gender)       
			        VALUES('$userName','$userEmail','TriPick','Field Missing','Hello, we couldnt retrieved you\'re birth date from Facebook, please update your profile in order to get better results for partners search',
			        	   '0',now(),'$sex')";
			$query = mysqli_query($conn_users, $sql); 
			$note = mysqli_insert_id($conn_users);  	  	 
		  }else{
			$userBirthday = $userBirthday->format('Y-m-d');	 	
		  }
		  	$sql = "INSERT INTO notifications (username, email,initiator,app, note, did_read, date_time,gender)       
			        VALUES('$userName','$userEmail','TriPick','Field Missing','Hello, we couldnt retrieved you\'re country from Facebook, please update your profile in order to get better results for partners search',
			        	   '0',now(),'$sex')";
			$query = mysqli_query($conn_users, $sql); 
			$note = mysqli_insert_id($conn_users); 
						
			$sql = "INSERT INTO users (username,firstname,lastname, email, gender, birthday, ip, signup, lastlogin, notescheck,  
					fbId,activated)       
			        VALUES('$userName','$userFirstName','$userLastName','$userEmail','$sex','$userBirthday','$ip',now(),now(),now(),'$fbId','1')";
			$query = mysqli_query($conn_users, $sql); 
			$uid = mysqli_insert_id($conn_users);
			// Establish their row in the useroptions table
			$sql = "INSERT INTO useroptions (id, username, email) VALUES ('$uid','$userName', '$userEmail')";
			$query = mysqli_query($conn_users, $sql);
			// Create directory(folder) to hold each user's files(pics, MP3s, etc.)
			if (!file_exists("users/$userName")) {
				mkdir("../../users/$userName-$fbId", 0755);
			
		   		//$link = $_SERVER['HTTP_REFERER'];
				//$linkParts = explode('#', $link); 
				//$newLink = $linkParts[0];
				header('Location: ../../index.php');	
			}
	}
?>