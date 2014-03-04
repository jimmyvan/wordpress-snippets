<?php
function get_twitter_timeline(){
    $expire = 3600; //过期时间,单位秒,2分钟
    $cache_file = './sqlite_twitter.dat';  //缓存文件
    $arr = array();
    clearstatcache();
    if (file_exists($cache_file) && time() <= (filemtime($cache_file) + $expire)) {
        //缓存文件存在且未过期则直接读取
        $arr = unserialize(file_get_contents($cache_file));
        $timelost = $expire - (time() - filemtime($cache_file));
    }else{
        session_start();
        $twitteruser = "jigoulee";
        $notweets = 5;
        $consumerkey = "123";
        $consumersecret = "123";
        $accesstoken = "244";
        $accesstokensecret = "335";
        function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
            $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
            return $connection;
        }
        $connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
        $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
        $arr = $tweets;
        if($arr) {
            file_put_contents($cache_file, serialize($arr)); //写入缓存文件
        }else{
            $arr = unserialize(file_get_contents($cache_file));
        }
    }
    return $arr;
}


require get_template_directory() . '/include/twitteroauth.php'; 

?>