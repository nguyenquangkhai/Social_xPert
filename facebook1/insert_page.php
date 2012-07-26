<? 
require_once 'app_facebook_config.php';

try {
	$page_id = '330948406958694';
	$page = $facebook->api('/'.$page_id);
	if($page){
		// print_r($page);
		require_once 'connect.php';
		$s_query = "select id from page where id='$page_id'";
		$query = mysql_query($s_query);
		$result_n = mysql_num_rows($query);
		if($result_n == 0)
		{
			$page_id = $page['id'];
			$page_likes = $page['likes'];
			$s_query = "insert into page values('$page_id','$page_likes')";
			$query = mysql_query($s_query);
			$result_m = mysql_affected_rows();
			if($result_m == -1 || $result_m == 0){
				echo 'Can not insert';
			}
		}
		else{
			echo 'This page has existed';
		}
	}
}
catch (FacebookApiException $e) {
    echo $e;
}
?>