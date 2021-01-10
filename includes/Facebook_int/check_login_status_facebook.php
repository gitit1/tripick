<?php
session_start();
require_once 'includes/Facebook_int/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '768628683249593',
  'app_secret' => '42413e7cd6aad6c720a35292c95f9c06',
  'default_graph_version' => 'v2.4',
  ]);

$request = $fb->request('GET', '/me?fields=id,name,email,gender,hometown,birthday');
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
  //$user = $response->getGraphUser();

  //$userName = $graphNode->getField('name');
  //$userEmail = $graphNode->getField('email');
  $fbId = $graphNode->getField('id');
  $sql = "SELECT * FROM users WHERE fbId='$fbId' AND activated='1' LIMIT 1";
  $user_query = mysqli_query($conn_users, $sql);
  $row = mysqli_fetch_array($user_query, MYSQLI_ASSOC);
  $userName = $row["username"];
 // echo $userName;
?>