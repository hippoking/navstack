<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>


<?php  
include( 'templates/sidebar-nav.php' );
?>
<div class="main-content flex-fill single">
<?php include( 'templates/header-banner.php' ); ?>
<div id="content" class="container my-4 my-md-5">
                <?php  include( 'templates/content-app.php' ); ?>

                <h4 class="text-gray text-lg my-4"><i class="site-tag iconfont icon-tag icon-lg mr-1" ></i><?php _e('相关软件','i_theme') ?></h4>
                <div class="row mb-n4 customize-site"> 
                    <?php
                    $post_num = 6;
                    $i = 0;
                    if ($i < $post_num) {
                        $custom_taxterms = wp_get_object_terms( $post->ID,'apps', array('fields' => 'ids') );
                        $args = array(
                        'post_type' => 'app',// Post type
                        'post_status' => 'publish',
                        'posts_per_page' => 6, // Number of posts
                        'orderby' => 'rand', // Random order
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'apps', // Taxonomy
                                'field' => 'id',
                                'terms' => $custom_taxterms
                            )
                        ),
                        'post__not_in' => array ($post->ID), // Exclude the current post
                        );
                        $related_items = new WP_Query( $args ); 
                        if ($related_items->have_posts()) :
                            while ( $related_items->have_posts() ) : $related_items->the_post();
                            $link_url = get_post_meta($post->ID, '_sites_link', true); 
                            $default_ico = get_theme_file_uri('/images/favicon.png');
                            if(current_user_can('level_10') || !get_post_meta($post->ID, '_visible', true)):
                            ?>
                                <div class="col-4 col-md-3 col-lg-2 pb-1">
                                <?php include( 'templates/card-app.php' ); ?>
                                </div>
                            <?php endif; $i++; endwhile; endif; wp_reset_postdata();
                    }
                    if ($i == 0) echo '<div class="col-lg-12"><div class="nothing">'.__('没有相关内容!','i_theme').'</div></div>';
                    ?>
                </div>
    	        <?php 
    	        if ( comments_open() || get_comments_number() ) :
			    	comments_template();
    	        endif; 
    	        ?>
</div>
<?php get_footer(); ?>
