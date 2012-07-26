<html>
<head>
<title>WebSpeaks.in | Upload images to Facebook</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
require_once 'libs/facebook.php';
$facebook = new Facebook(array(
	'appId' => '136408006489339',
	'secret' => '5bf57be1ee19125a959b75820a205d12',
	'cookie' => true,
	'fileUpload' => true
));


//It can be found at https://developers.facebook.com/tools/access_token/
$access_token = '<Your access token>';

$params = array('access_token' => $access_token);

//The id of the fanpage
$fanpage = '330299184793';

//The id of the album
$album_id ='10150418901414794';

//Replace arvind07 with your Facebook ID
$accounts = $facebook->api('/arvind07/accounts', 'GET', $params);

foreach($accounts['data'] as $account) {
 if( $account['id'] == $fanpage || $account['name'] == $fanpage ){
  $fanpage_token = $account['access_token'];
 }
}


$valid_files = array('image/jpeg', 'image/png', 'image/gif');

if(isset($_FILES) && !empty($_FILES)){
 if( !in_array($_FILES['pic']['type'], $valid_files ) ){
  echo 'Only jpg, png and gif image types are supported!';
 }else{
  #Upload photo here
  $img = realpath($_FILES["pic"]["tmp_name"]);

  $args = array(
   'message' => 'This photo was uploaded via WebSpeaks.in',
   'image' => '@' . $img,
   'aid' => $album_id,
   'no_story' => 1,
   'access_token' => $fanpage_token
  );

  $photo = $facebook->api($album_id . '/photos', 'post', $args);
  if( is_array( $photo ) && !empty( $photo['id'] ) ){
   echo '<p><a target="_blank" href="http://www.facebook.com/photo.php?fbid='.$photo['id'].'">Click here to watch this photo on Facebook.</a></p>';
  }
 }
}

?>
 <!-- Form for uploading the photo -->
 <div class="main">
  <p>Select a photo to upload on Facebook Fan Page</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
  <p>Select the image: <input type="file" name="pic" /></p>
  <p><input class="post_but" type="submit" value="Upload to my album" /></p>
  </form>
 </div>
</body>
</html>