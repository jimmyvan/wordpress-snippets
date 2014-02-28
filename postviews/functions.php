<?php 
function set_post_views() {
    global $post;
    $post_id = intval($post->ID);
    $count_key = 'views';
    $views = get_post_custom($post_id);
    $views = intval($views['views'][0]);
    if (is_single() || is_page()) {
        if(!update_post_meta($post_id, 'views', ($views + 1))) {
            add_post_meta($post_id, 'views', 1, true);
        }
    }
}
add_action('get_header', 'set_post_views');

function format_number($number) {
    if($number >= 1000) {
       return  number_format($number/1000,1) . "k";   // NB: you will want to round this
    }
    else {
        return $number;
    }
}

function custom_the_views($post_id, $echo=true, $unit=' views') {
    $count_key = 'views';
    $views = get_post_custom($post_id);
    $views = intval($views['views'][0]);
    $post_views = intval(post_custom('views'));
    if ($views == '') {
        return '';
    } else {
        if ($echo) {
            echo format_number($views) . $unit;
        } else {
            return format_number($views) . $unit;
        }
    }
}

?>