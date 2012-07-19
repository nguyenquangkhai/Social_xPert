<?   
require_once 'app_facebook_config.php';
	try{
		$post_id=$_POST['post_id'];
		$old_count=$_POST['old_count'];
		if( !empty($post_id) ) {
			$post = $facebook->api("/".$post_id);
		}
		if($old_count<$post['comments']['count']){
			for($i=$old_count; $i<$post['comments']['count']; $i++){
		//	echo json_encode($post);
				echo include("modules/post_comment.php");
			}	
			exit();
		}
		echo "none";
	} catch (FacebookApiException $e) {
		echo "error";
		exit();
	}
?>