<?php
//php get photos from instagram by bigfa 
function get_instagram($id,$num){
	
    $getjson = 'https://api.instagram.com/v1/users/'.$id.'/media/recent?access_token=474768489.63d81af.1655d1641d474362bebe106247cd9367&count='.$num.'&callback=?';
    $content = file_get_contents($getjson);
    $instagram = json_decode($content, true);
    $arr = $instagram['data'];
    for($i=0;$i<15;$i++){
        $arr1 = $arr["$i"];
        if($arr1) {
            $content='<a class="fancybox" href="'.$arr1['images']['standard_resolution']['url'].'"><img src="'.$arr1['images']['thumbnail']['url'].'"></a>';
            echo $content;
        }
    }
}
get_instagram(474768489,15)//your instagram id & the number of photo you want to get
?>