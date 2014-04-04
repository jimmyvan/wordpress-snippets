<?php
$client_id = '801469384';
$client_secret = 'd0437a762b6cd03317456a5bc4f5843f';
$debug = false;
error_reporting(0);
function wptl_at_link($tweet_msg){
    preg_match_all ( '/@(.*?)[:\s]/', $tweet_msg, $matches, PREG_SET_ORDER);
    foreach( $matches as $match )
    {
        $url = $match[1];
        $tweet_msg = str_replace( $match[0], "<a href='http://t.qq.com/".$url."' target='_blank'>@".$match[1]."</a> " , $tweet_msg) ;
    }
    return $tweet_msg;
}
OAuth::init($client_id, $client_secret);
Tencent::$debug = $debug;
session_start();
header('Content-Type: text/html; charset=utf-8');
$userinfo = Tencent::api("user/info",array( "format" => "json"),"get",false);
$user = json_decode($userinfo, true);
echo '<div>';
echo '<img src="'.$user['data']['head'].'/100">';
echo  '<div>'.$user['data']['nick'].'<span><a href="http://t.qq.com/'.$user['data']['name'].'" target="_blank">@'.$user['data']['name'].'</a></span></div>';
echo '<div><div><span>粉丝:'.$user['data']['fansnum'];
echo '</span><span>关注:'.$user['data']['idolnum'].'</span><span>微博:'.$user['data']['tweetnum'].'</span></div>';
echo $user['data']['introduction'].'</div></div>';
echo '<ul>';
$r =Tencent::api('statuses/broadcast_timeline', array("reqnum" => "10"), 'get');
$s = json_decode($r, true);
$content = $s['data']['info'];
foreach( $content as $item ): ?>
    <li>
        <div><?php echo wptl_at_link($item['text']);?>
            <?php if($item['source']){
                echo '<div><strong>'.$item['source']['name'].':</strong>';
                echo $item['source']['text'];
                echo '</div>';}?>
            <?php if($item['pic']){
                echo '<div>';
                foreach( $item['pic']['info'] as $images ):?>
                    <img src="<?php echo $images['url'][0];?>/120">
                <?php endforeach; echo '</div>';}?>
        </div>
        <div>
            <div><?php echo date('Y-m-d H:i:s',$item['timestamp']);?></div>
            <div><?=$item['from'];?></div></div>
    </li>
<?php endforeach;
echo '</ul>';
?>