<!--לשנות לשאילתא ולא לשליחת פרטים ואז להפעיל מיידית אחרי לוגין-->
<?php
session_start();
require_once __DIR__ . '/facebook-php-sdk-v4-5.0-dev/src/Facebook/autoload.php';

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
  $user = $response->getGraphUser();

  echo $graphNode->getField('name'). "<br>";
  echo $graphNode->getField('id'). "<br>";
  echo $graphNode->getField('email') . "<br>";
  echo $graphNode->getField('gender') . "<br>";
  echo $response->getGraphNode()->getField('hometown')->getField('name') . "<br>";
  $city_country = explode(',',$response->getGraphNode()->getField('hometown')->getField('name'));
  echo $response->getGraphNode()->getField('country')->getField('name') . "<br>";
  echo $city_country[count($city_country) - 1] . "<br>";
  //var_dump($response->getGraphNode()->getField('hometown')->getField('name'));
  echo $user->getBirthday()->format('d/m/Y') . "<br>";
  $image = "http://graph.facebook.com/" . $graphNode->getField('id') . "/picture";
  echo "<img src=" . "$image" . " >";


?>