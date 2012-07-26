<div id="post_comment">
	<div class="avatar"><img src="https://graph.facebook.com/<?=$post['comments']['data'][$i]['from']['id']?>/picture"/></div>
	<div class="person_content">
		<div class="name"><?=$post['comments']['data'][$i]['from']['name']?></div>
		<div class="c_message"><?=$post['comments']['data'][$i]['message']?></div>
		<div class="clear"></div>
		<div class="time"><?=$post['comments']['data'][$i]['created_time']?></div>
	</div>
</div>
<div class="clear"></div>