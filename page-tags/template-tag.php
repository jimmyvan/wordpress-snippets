<?php
$py = new PinYin();
$list = '';
$tags = get_tags();
$groups = array();
if( $tags && is_array( $tags ) ) {
    foreach( $tags as $tag ) {
        $name = $py->getFirstPY( $tag->name );
        $first_letter = strtoupper($name[0]);
        $groups[ $first_letter ][] = $tag;
    }
    array_multisort( $groups );
    if( !empty( $groups ) ) {
        foreach(range('A','Z') as $letter){
            if(!empty($groups[ $letter ]))
            {
                $list .= "\n\t" . '<dl><dt id="'.$letter.'">'.$letter.'</dt>';
                $list .= "\n\t" . '<dd><ul class="inline">';
                foreach( $groups[ $letter ] as $tag ) {
                    $url = attribute_escape( get_tag_link( $tag->term_id ) );
                    $count = intval( $tag->count );
                    $name = apply_filters( 'the_title', $tag->name );
                    $list .= "\n\t\t" . '<li><a href="' . $url . '">' . $name . '</a> <span class="set-tags f12">(' . $count . ')</span></li>';
                }
                $list .= "\n\t" . '</ul></dd></dl>';
            }
        }
        foreach(range('0','9') as $letter){
            if(!empty($groups[ $letter ]))
            {
                $list .= "\n\t" . '<dl><dt id="'.$letter.'">'.$letter.'</dt>';
                $list .= "\n\t" . '<dd><ul class="inline">';
                foreach( $groups[ $letter ] as $tag ) {
                    $url = attribute_escape( get_tag_link( $tag->term_id ) );
                    $count = intval( $tag->count );
                    $name = apply_filters( 'the_title', $tag->name );
                    $list .= "\n\t\t" . '<li><a href="' . $url . '">' . $name . '</a> (' . $count . ')</li>';
                }
                $list .= "\n\t" . '</ul></dd></dl>';
            }
        }
    }
}else $list .= "\n\t" . '<p>Sorry, but no tags were found</p>';
echo '<div id="tag-nav"><ul>';
foreach(range('0','9') as $letter){
    if(!empty($groups[ $letter ]))
        echo '<li><a href="#'.$letter.'">'.$letter.'</a></li>';
    else
        echo '<li><a href="#'.$letter.'" class="noclick">'.$letter.'</a></li>';
}
foreach(range('A','Z') as $letter){
    if(!empty($groups[ $letter ]))
        echo '<li><a href="#'.$letter.'">'.$letter.'</a></li>';
    else
        echo '<li><a href="#'.$letter.'" class="noclick">'.$letter.'</a></li>';
}
echo '</ul></div>';
?>
<div class="tags-all-list">
    <?php print $list; ?>
</div>           