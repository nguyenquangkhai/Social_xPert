<?   
require_once '../app_facebook_config.php';
	try{
		$page_id=$_POST['page_id'];
		$page_info = $facebook->api("/$page_id?fields=access_token");
		if( !empty($page_info['access_token']) ) {
            $valid_videos = array('application/octet-stream', 'video/3gpp', 'video/mp4');
			if(isset($_FILES) && !empty($_FILES)){
                echo $_FILES['vid']['type'];

  				if( !in_array($_FILES['vid']['type'], $valid_videos ) ){
  					echo 'Only jpg, png and gif image types are supported!';
 				}
  				else{
  					  #Upload video here
  					$vid = realpath($_FILES["vid"]["tmp_name"]);
  //echo $img;
  			//		move_uploaded_file($_FILES["vid"]["tmp_name"],"images/uploads/".$_FILES["vid"]["name"]);
   					$args = array(
  						'access_token'  => $page_info['access_token'],
  						'description' => $_POST['message'],
  						'source' => '@'.$vid
  					//	'aid' => $album_id,
  				//		'no_story' => 1
  					);

  					$video_post = $facebook->api($page_id."/videos", 'POST', $args);
  					echo $video_post['post_id'];
  					if( is_array( $video_post ) && !empty( $video_post['id'] ) ){
  						echo '<p><a target="_blank" href="http://www.facebook.com/video.php?fbid='.$video_post['id'].'">Click here to watch this video on Facebook.</a></p>';
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