<?php
session_start();
require '/../functions.php';

if ($_GET['code']) {
	$code = $_GET['code'];
	$url = 'https://api.instagram.com/oauth/access_token';
    
    $fields = 'client_id='.IN_CLIENT_ID.'&client_secret='.IN_CLIENT_SCREAT.'&grant_type=authorization_code&redirect_uri='.IN_REQ_URI.'&code='.$code.'&scope=public_content';

    $assesToken = curlPost($url,$fields);
   	
	if ($assesToken) {
		$_SESSION['in_access_token'] = $assesToken['access_token'];
	}
}
header('Location: '.APP_URL);
