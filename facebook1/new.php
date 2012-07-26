<?php
// This code is just a snippet of the example.php script
// from the PHP-SDK <http://github.com/facebook/php-sdk/blob/master/examples/example.php>
require 'libs/facebook.php';
 
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '136408006489339',
  'secret' => '5bf57be1ee19125a959b75820a205d12',
));
 
// Get User ID
$user = $facebook->getUser();
 
if ($user) {
  try {
    $page_id = '330948406958694';
    $page_info = $facebook->api("/$page_id?fields=access_token");
    if( !empty($page_info['access_token']) ) {
        $args = array(
            'access_token'  => $page_info['access_token'],
            'message'       => "Quang"
        );
        $post_id = $facebook->api("/$page_id/feed","post",$args);
    }
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
 
// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(array('scope'=>'manage_pages,publish_stream'));
}
?>