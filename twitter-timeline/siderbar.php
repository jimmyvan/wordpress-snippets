<div id="sidebar-notice">
<?php
	$arr = array();
	$arr = get_twitter_timeline();
	echo '<div id="twitter-info" class="clearfix"><img src="'.$arr[0]->user->profile_image_url.'" class="twitter-avatar">';
	echo '<div class="twitter-name"><a href="https://twitter.com/'.$arr[0]->user->screen_name.'" rel="external nofollow" target="_blank">@'.$arr[0]->user->screen_name.'</a></div>';
	echo '<div class="twitter-des">'.$arr[0]->user->description.'</div></div>';
	echo '<ul id="sidebar-notice-ul">';
	for($i=0;$i<3;$i++){
		$content= $arr["$i"]->text . '<span class="yahei twitter-time">/ ' .human_time_diff(strtotime($arr["$i"]->created_at), strtotime(current_time('mysql', 0))). ' ago</span>';
		echo '<li><i class="icon-twitter"></i>'.$content.'</li>';
		}
	echo '</ul>';
?>
</div>