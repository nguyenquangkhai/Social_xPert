<?   
require_once '../app_facebook_config.php';
	try{
		$page_id=$_POST['page_id'];
		$page_info = $facebook->api("/$page_id?fields=access_token");
		if( !empty($page_info['access_token']) ) {
			$valid_photos = array('image/jpeg', 'image/png', 'image/gif');

			if(isset($_FILES) && !empty($_FILES)){
                echo $_FILES['pic']['type'];

  				if( !in_array($_FILES['pic']['type'], $valid_photos ) ){
  					echo 'Only jpg, png and gif image types are supported!';
 				}
  				else{
  					  #Upload photo here
  					$img = realpath($_FILES["pic"]["tmp_name"]);
  //echo $img;
  			//		move_uploaded_file($_FILES["pic"]["tmp_name"],"images/uploads/".$_FILES["pic"]["name"]);
   					$args = array(
  						'access_token'  => $page_info['access_token'],
  						'message' => $_POST['message'],
  						'source' => '@'.$img
  					//	'aid' => $album_id,
  				//		'no_story' => 1
  					);

  					$photo_post = $facebook->api($page_id."/photos", 'POST', $args);
  					echo $photo_post['post_id'];
  					if( is_array( $photo_post ) && !empty( $photo_post['id'] ) ){
  						echo '<p><a target="_blank" href="http://www.facebook.com/photo.php?fbid='.$photo_post['id'].'">Click here to watch this photo on Facebook.</a></p>';
  					//	echo 'success';
  						exit();
  					} 
  				}
 
			}
		}
	//	echo 'success';
		exit();
	} catch (FacebookApiException $e) {
    echo $e;
	exit();
  }

?>