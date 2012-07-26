<?   
require_once '../app_facebook_config.php';
	try{
		$page_id=$_POST['page_id'];
		$page_info = $facebook->api("/$page_id?fields=access_token");
		if( !empty($page_info['access_token']) ) {
			$args = array(
				'access_token'  => $page_info['access_token'],
				'message'       => $_POST['message']
			);
			$feed_post = $facebook->api($page_id."/feed","POST",$args);
		}
		echo $feed_post['id'];
		exit();
	} catch (FacebookApiException $e) {
    echo $e;
	exit();
  }

?>