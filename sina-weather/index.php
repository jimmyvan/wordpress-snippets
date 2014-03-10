<?php

// 复杂获取本地ip地址
/* if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
    $SA_IP = getenv('HTTP_CLIENT_IP');
} elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
    $SA_IP = getenv('HTTP_X_FORWARDED_FOR');
} elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
    $SA_IP = getenv('REMOTE_ADDR');
} elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
    $SA_IP = $_SERVER['REMOTE_ADDR'];
} */
$SA_IP=$_SERVER['REMOTE_ADDR'];//简单获取本地ip地址
//定义一个函数根据ip获取城市名，使用新浪的天气预报
function getIPLoc_sina($queryIP){
    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $queryIP;
    $ch  = curl_init($url);
    curl_setopt($ch, CURLOPT_ENCODING, 'utf8');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $location = curl_exec($ch);
    $location = json_decode($location);
    curl_close($ch);
    $loc = "";
    if ($location === FALSE)
        return "";
    if (empty($location->desc)) {
        $loc      = $location->city;
        $full_loc = $location->province . $location->city . $location->district . $location->isp;
    } else {
        $loc = $location->desc;
    }
    return $loc;
}
$city     = getIPLoc_sina("$SA_IP");

$citycode = mb_convert_encoding($city, "gb2312", "utf-8");

$doc      = new DOMDocument();
if (!@$doc->load("http://php.weather.sina.com.cn/xml.php?city=" . $citycode . "&password=DJOYnieT8234jlsK&day=0")) {
    echo "Get data failed!!\n";
    return;
}

$city         = $doc->getElementsByTagName("city")->item(0)->nodeValue;
$stat1        = $doc->getElementsByTagName("status1")->item(0)->nodeValue;
$chy_shuoming = $doc->getElementsByTagName("chy_shuoming")->item(0)->nodeValue;
$tmp1         = $doc->getElementsByTagName("temperature1")->item(0)->nodeValue;
$tmp2         = $doc->getElementsByTagName("temperature2")->item(0)->nodeValue;
$date         = $doc->getElementsByTagName("savedate_weather")->item(0)->nodeValue;
$pollution_l  = $doc->getElementsByTagName("pollution_l")->item(0)->nodeValue;
$gm_s          = $doc->getElementsByTagName("gm_s")->item(0)->nodeValue;

echo '<aside class="widget"><div class="sina-weather-content"><div class="sina-weather-city">' .$city .' / '.$date.'</div><div class="sina-weather-body"><span>'. $tmp1 .'~'. $tmp2 .'<sup>℃</sup></span><span class="sina-weather-tem">'.$stat1 .'</span>
<span class="stat-w"><p>空气质量：'.$pollution_l .'</p><p>穿衣建议：'. $chy_shuoming .'</p></span></div></div></div></aside>';
?>