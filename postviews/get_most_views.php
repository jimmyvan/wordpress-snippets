<?php
/*
		get most viewed posts by bigfa
		http://fatesinger.com
*/
        $args = array(
            'posts_per_page' => 5,
            'meta_key' => 'views',
            'orderby' => 'meta_value_num',
            'date_query' => array(
                array(
                    'after'  => '2 month ago',
                ))
        );
        $postslist = get_posts( $args );
        foreach ( $postslist as $post ) :
            setup_postdata( $post ); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span class="views"> - <?php if ( function_exists('custom_the_views') ) custom_the_views($post->ID); ?></span></li>
<?php endforeach;
        wp_reset_postdata(); ?>