<html>
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css">
<head>
	<title>Post Manager</title>
	<script type="text/javascript">
	function load_comment(id){
		var auto_refresh = setInterval(function (){
		var c = $('#cm_count_'+id).val();
			$.ajax({
				type: 'POST',
				url: 'post_get.php',
				data: ({
				post_id : id,
				old_count : c
				}),
				success: function(data) {
					if(data!='none'&&data!='error'){
						$('#'+id).before(data);
					//	$('#cm_count_'+id).attr('value','')
						//eval('var jsonData = ' + data + ';');
						//alert(jsonData.comments.count);
						//var y = jsonObj.y;
					}
				}
			});
		}, 5000); // refresh every 10000 milliseconds
	}
	function test(id){
		var c = $('#'+id).before("<input type='button'/>");
	//	alert(c);
	}
	</script>
</head>
<body>
<?
require_once 'app_facebook_config.php';
$page_id = $_POST['page_id'];
  try { 
		//$page_id = $_POST['page_id'];
	//	$page = $facebook->api("/".$page_id."?fields=access_token");
		$page = $facebook->api("/me/accounts");
		$posts = $facebook->api("/$page_id/posts");
	//	print_r ($page);
		print_r($posts);
/* 		if( !empty($page['access_token']) ) {
			$args = array(
				'access_token'  => $page['access_token']
			);
			$posts = $facebook->api('/'.$page['id'].'/posts','GET',$args);
			print_r($posts);
	   } */
  } catch (FacebookApiException $e) {
		echo $e;
  }
?>
<div id="wrapper">
	<div id="posts_contain">
	<? //	echo $page_info['access_token'];
	$j=0;foreach($posts['data'] as $post){
		if($post['id']=='330948406958694_330948420292026') continue;
		if($j%2==0&&$j!=0)
			echo '<div class="clear"></div>';?>
		<div class="post_item">
			<div class="post_person">
				<div class="avatar"><img src="https://graph.facebook.com/<?=$post['from']['id']?>/picture"/></div>
				<div class="person_content">
					<div class="name"><?=$post['from']['name']?></div>
					<div class="clear"></div>
					<div class="time"><?=$post['created_time']?></div>
				</div>
			</div>
			<div class="clear"></div>
			<div id="post_content">
				<div class="p_message"><?=$post['message']?></div>
				<?if($post['type']=='photo'){?>
				<div class="p_source"><img src="<?=$post['picture']?>"/></div>
				<?}?>
			</div>
			<div class="clear"></div>
			<div id="post_action">
				<div class="p_action">Like</div>
				<div class="p_action a_line">-</div>
				<div class="p_action">Comment</div>
				<div class="p_action a_line">-</div>
				<div class="p_action">Share</div>
			</div>
			<?	if($post['comments']['count']>0){
				//	print_r($post['comments']['data']);
					foreach($post['comments']['data'] as $comment){?>
			<div class="clear"></div>
			<div id="post_comment">
				<div class="avatar"><img src="https://graph.facebook.com/<?=$comment['from']['id']?>/picture"/></div>
				<div class="person_content">
					<div class="name"><?=$comment['from']['name']?></div>
					<div class="c_message"><?=$comment['message']?></div>
					<div class="clear"></div>
					<div class="time"><?=$comment['created_time']?></div>
				</div>
			</div>	
			<?}}?>
			<div class="clear"></div>
			<div class="m_action" id="<?=$post['id']?>">
				<div id="cm_count"><input id="cm_count_<?=$post['id']?>" type="text" value="<?=$post['comments']['count']?>" disabled="true"/></div>
				<div id="cm_update"><input id="cm_update_<?=$post['id']?>" type="checkbox" onchange="load_comment('<?=$post['id']?>')"/>Keep up to date</div>
			</div>
		</div>
	<?	$j++;}?>		
	</div>
</div>



</body>
</html>