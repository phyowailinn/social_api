<?php
include '/config.php';

function curlGet($url)
{
	  $header = ["Content-type: application/json"];
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	  curl_setopt($ch, CURLOPT_URL, $url);	  
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	  $set = curl_exec($ch);
	  $result = json_decode($set,true);
	  isset($result['access_token'])?$_SESSION['fb_page_access_token']=(string)$result['access_token']:'';

	  return $result;
}

function curlPost($url,$fields)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	$set = curl_exec($ch);
	$result = json_decode($set,true);

	return $result;
}

function convertURL($token,$social_name=FACEBOOK,$review=false)
{	 
	$fields = ($review==true)?urlencode(FB_REVIEW_FIELDS):urlencode(FB_PAGE_FIELDS);
	$url = ($social_name==FACEBOOK)?$social_name.'/'.FB_APP_VERSION.'/'.FB_PAGE_NAME.'?fields='.FB_TITLE_FIELD.$fields.'&access_token='.$token:$social_name.'/'.IN_APP_VERSION.'/'.IN_END_POINT.'/?access_token='.$token;
	
	return $url;	
}

function generate_sig($endpoint, $params, $secret) { // instragran secure request hash algorithm
  $sig = $endpoint;
  ksort($params);
  foreach ($params as $key => $val) {
    $sig .= "|$key=$val";
  }
  return hash_hmac('sha256', $sig, $secret, false);
}

function getInstraToken()
{
	$getTokenURL = INSTAGRAM.'/oauth/authorize/?client_id='.IN_CLIENT_ID.'&redirect_uri='.IN_REQ_URI.'&response_type=code&scope=public_content';
	 
	return $getTokenURL;
}

