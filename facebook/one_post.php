<html>
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css">
<head>
	<title>Post Manager</title>
	<script type="text/javascript">
	
	</script>
</head>
<body>
<?
require_once 'app_facebook_config.php';
  try { 
		//$page_id = $_POST['page_id'];
		$post = $facebook->api('/330948406958694_351505928236275_779282');
		print_r($post);
		//echo json_encode($posts);
		// if($post['comments']['count']>0)
			// foreach($post['comments']['data'] as $comment){
				// echo $comment['message'].'<br>';
			// }
  } catch (FacebookApiException $e) {
		error_log($e);
  }
?>




</body>
</html>