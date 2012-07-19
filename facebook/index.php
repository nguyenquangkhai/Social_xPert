<html>
<head>
    <meta name="googlebot" content="noarchive" />
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
	<title>Test</title>
    <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
	<script type="text/javascript">
		function post_wall(){
	//		var p=document.getElementById('post_new').value;
	//		alert(p);
			var p=$('#post_new').val();
			alert(p);
			var p_id=$('#post_user_id').val();;
			$.ajax({
			  type: 'POST',
			  url: 'function/post_message.php',
			  data: ({
				page_id : p_id, 
				message : p,
			  }),
			  success: function(data) {
				alert(data);
			  }
			});
		}
	</script>
</head>
<body>
<? 
require_once 'app_facebook_config.php';
$user = $facebook->getUser();
//136408006489339|vYQIML6dheDkouqtOSJ0s1cX_ow

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
//	$friends = $facebook->addWallPost("asdasd");
//	print_r($friends);
  //  $access_token = $facebook->getAccessToken();
//if(isset($_GET['wall_post'])){
//	$facebook->api('/'.$user.'/feed', 'post', array(
	//	'message' => '123456789',//$_GET['wall_post']

//	));
//	}
 //               $publishStream = $facebook->api("/$user/feed", 'post', array(
//					'access_token'  => '136408006489339|vYQIML6dheDkouqtOSJ0s1cX_ow',
 //                   'message' => 'I love thinkdiff.net for facebook app development tutorials',
 //                   'link'    => 'http://ithinkdiff.net',
 //                   'picture' => 'http://thinkdiff.net/ithinkdiff.png',
 //                   'name'    => 'iOS Apps & Games',
 //                   'description'=> 'Checkout iOS apps and games from iThinkdiff.net. I found some of them are just awesome!'
 //                   )
 //               );
//    $page_id = '330948406958694';
//    $page_info = $facebook->api("/$page_id?fields=access_token");
//    if( !empty($page_info['access_token']) ) {
//        $args = array(
//            'access_token'  => $page_info['access_token'],
//            'message'       => "Quang test"
//        );
 //       $post_id = $facebook->api("/$page_id/feed","post",$args);
 //   }
 
		 $page_id = '449021921787077';
		 $page_info = $facebook->api("/$page_id");
         $user_account = $facebook->api("/me/accounts");
		 print_r($user_account);
		// $page_info = $facebook->api("/$page_id?fields=access_token");
		// echo $page_info['id'];
		// if( !empty($page_info['access_token']) ) {
			// $args = array(
				// 'access_token'  => $page_info['access_token']
			// );
			// $posts = $facebook->api('/'.$page_info['id'].'/posts','GET',$args);
			// print_r($posts);
		// }
  } catch (FacebookApiException $e) {
    print($e);
	$user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
//  $logoutUrl = $facebook->getLogoutUrl();
   $logoutUrl = $facebook->getLogoutUrl(array(
	'next' => 'http://localhost/facebook/index.php'
  ));
    $loginUrl = $facebook->getLoginUrl(array(
	'scope' => 'publish_stream,publish_actions,manage_pages,read_stream',
	'redirect_uri' => 'http://localhost/facebook/index.php'
  )); 
} else {
  $loginUrl = $facebook->getLoginUrl(array(
	'scope' => 'publish_stream,publish_actions,manage_pages',
	'redirect_uri' => 'http://localhost/facebook/index.php'
  ));
}

?>

<div>
	<?if($user){?>
		<div style="padding:5px;margin:5px; border: 1px solid black; width: 300px;">
            <p>User information</p>
			<div id="user id">user id:<?=$user?></div>
			<div id="user name">user name:<?=$user_profile['name']?></div>
			<div id="link">link:<?=$user_profile['link']?></div>
			<div id="email">email:<?=$user_profile['email']?></div>
		</div>
        <div style="clear:both;"></div>
		<div style="padding:5px;margin:5px;float:left; border: 1px solid black; width: 200px;">
            <p>Post to fanpage</p>
			Page ID<input type="text" name="post_user_id" id="post_user_id" value="330948406958694"/>
			<br/>
            Message<input type="text" name="post_new" id="post_new"/>
            <br/>
			<input type="button" name="post_new_bt" id="post_new_bt" onclick="post_wall()" value="post in wall fan page"/>
		</div>
				
		<div style="padding:5px;margin:5px;float:left; border: 1px solid black; width: 350px;">
			<p>Select a photo to upload on Facebook Fan Page</p>
			<form method="post" action="function/post_photo.php" enctype="multipart/form-data">
				Page ID<input type="text" value="449021921787077" name="page_id" />
                <br/>
				Message<input type="text" name="message" />
                <br/>
				Select the image: <input type="file" name="pic" />
                <br/>
				<input class="post_but" type="submit" value="Upload to my album" />
			</form>
		</div>
        
		<div style="padding:5px;margin:5px;float:left; border: 1px solid black; width: 350px;">
			<p>Select a video to upload on Facebook Fan Page</p>
			<form method="post" action="function/post_video.php" enctype="multipart/form-data">
				Page ID<input type="text" value="449021921787077" name="page_id" />
                <br/>
				Message<input type="text" name="message" />
                <br/>
				Select the video: <input type="file" name="vid" />
                <br/>
				<input class="post_but" type="submit" value="Upload video" />
			</form>
		</div>
		<div style="clear:both;"></div>
		<div style="padding:5px;margin:5px; border: 1px solid black; width: 300px;">
			<p>View all post</p>
			<form method="post" action="post_manage.php">
				Page ID<input type="text" value="330948406958694" name="page_id" />
				<p><input class="post_but" type="submit" value="Go to post manager" /></p>
			</form>
		</div>
		<div style="clear:both;"></div>
		<div>
			<a href="<?=$logoutUrl?>">Logout</a>
		</div>
		<div>
			<a href="<?=$loginUrl?>">Update permission</a>
		</div>
	<?}else{?>
		<div>
			<a href="<?=$loginUrl?>">Login face</a>
		</div>
	<?}?>
</div>



</body>
</html>