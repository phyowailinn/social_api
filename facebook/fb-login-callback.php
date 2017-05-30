<?php  
session_start();
require __DIR__.'/../vendor/autoload.php';
require '/../config.php';

$fb = new Facebook\Facebook([
  'app_id'     => FB_APP_ID,
  'app_secret' => FB_APP_SECREAT,
  'default_graph_version' => FB_APP_VERSION,
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = json_decode(FB_PERMISSIONS); // Optional permissions

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

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}
// Logged in
  $assess = $accessToken->getValue();

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token

$_SESSION['fb_access_token'] = (string) $assess;

header('Location: http://localhost/social_data_api');