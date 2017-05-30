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
$loginUrl = $helper->getLoginUrl('http://localhost/social_data_api/facebook/fb-login-callback.php', $permissions);

header('Location: '.$loginUrl);?>

