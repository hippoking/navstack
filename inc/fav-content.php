<?php  if ( ! defined( 'ABSPATH' ) ) { exit; }
function fav_con($mid,$pname = "") { 
    $taxonomy = $mid->taxonomy;
    $quantity = io_get_option('card_n');
    if($taxonomy == "favorites") {
        $icon = 'icon-tag';
    } elseif($taxonomy == "apps") {
        $icon = 'icon-app';
    } elseif($taxonomy == "category") {
        $icon = 'icon-publish';
    } else{
        $icon = 'icon-tag';
    }
    ?>
        <div class="d-flex flex-fill ">
            <h4 class="text-gray text-lg mb-4">
                <i class="site-tag iconfont <?php echo $icon ?> icon-lg mr-1" id="term-<?php echo $mid->term_id; ?>"></i>
                <?php if( $pname != "" && io_get_option("tab_p_n")&& !wp_is_mobile() ){ 
                     echo $pname . '<span style="color:#f1404b"> · </span>';
                } 
                echo $mid->name; ?>
            </h4>
            <div class="flex-fill"></div>
            <?php 
            $site_n = $quantity[$taxonomy];
            $category_count   = $mid->category_count;
            $count            = $site_n;
            if($site_n == 0)  $count = min(get_option('posts_per_page'),$category_count);
            if($site_n >= 0 && $count < $category_count){
                $link = esc_url( get_term_link( $mid, $taxonomy ) );
                echo "<a class='btn-move text-xs' href='$link'>more+</a>";
            } 
            ?>
        </div>
        <div class="row <?php echo io_get_option('site_card_mode') == 'min'?"row-sm":"" ?>">
        <?php show_card($site_n,$mid->term_id,$taxonomy); ?>
        </div>   
<?php }  
function fav_con_a($mid,$pname = "") { 
    $taxonomy = $mid['object'];
    $quantity = io_get_option('card_n');
    if($taxonomy == "favorites") {
        $icon = 'icon-tag';
    } elseif($taxonomy == "apps") {
        $icon = 'icon-app';
    } elseif($taxonomy == "category") {
        $icon = 'icon-publish';
    } else{
        $icon = 'icon-tag';
    }
    ?>
        <div class="d-flex flex-fill ">
            <h4 class="text-gray text-lg mb-4">
                <i class="site-tag iconfont <?php echo $icon ?> icon-lg mr-1" id="term-<?php echo $mid['object_id']; ?>"></i>
                <?php if( $pname != "" && io_get_option("tab_p_n")&& !wp_is_mobile() ){ 
                     echo $pname . '<span style="color:#f1404b"> · </span>';
                } 
                echo $mid['title']; ?>
            </h4>
            <div class="flex-fill"></div>
            <?php 
            $site_n = $quantity[$taxonomy];
            $category_count   = io_get_category_count($mid['object_id']);//10;//$mid->category_count;
            $count            = $site_n;
            if($site_n == 0)  $count = min(get_option('posts_per_page'),$category_count);
            if($site_n >= 0 && $count < $category_count){
                $link = $mid['url'];//esc_url( get_term_link( $mid, $taxonomy ) );
                echo "<a class='btn-move text-xs' href='$link'>more+</a>";
            } 
            ?>
        </div>
        <div class="row <?php echo io_get_option('site_card_mode') == 'min'?"row-sm":"" ?>">
        <?php show_card($site_n,$mid['object_id'],$taxonomy); ?>
        </div>   
<?php } 
function fav_con_tab_a($category,$parent_term) { 
    $_mid = '';  
    $quantity = io_get_option('card_n');
    if($parent_term['object'] == "favorites") { 
        $icon = 'icon-tag'; 
    } elseif($parent_term['object'] == "apps") { 
        $icon = 'icon-app'; 
    } elseif($parent_term['object'] == "category") {
        $icon = 'icon-publish';
    } else{ 
        $icon = 'icon-tag';
    }
    ?>
        <?php if(io_get_option("tab_p_n") ){ ?>
        <h4 class="text-gray text-lg">
            <i class="site-tag iconfont <?php echo $icon ?> icon-lg mr-1" id="term-<?php echo $parent_term['object_id'] ?>"></i>
            <?php echo $parent_term['title']; ?>
        </h4>
        <?php } ?>
        <!-- tab模式菜单 -->
        <div class="d-flex flex-fill flex-tab">
            <div class="overflow-x-auto">
            <div class='slider_menu mini_tab ajax-list-home' sliderTab="sliderTab" data-id="<?php echo  $parent_term['object_id'] ?>">
                <ul class="nav nav-pills menu" role="tablist"> 
                    <?php $i_menu = 0; foreach($category as $mid) { 
                    if($i_menu == 0) $_mid = $mid;
                    $taxonomy = $mid['object'];
                    ?>
                    <li class="pagenumber nav-item">
                        <a id="term-<?php echo $mid['object_id']; ?>" class="nav-link <?php echo $i_menu==0?'active':'' ?>" data-action="load_home_tab" data-taxonomy="<?php echo $taxonomy ?>" data-id="<?php echo $mid['object_id']; ?>" ><?php echo $mid['title']; ?></a>
                    </li>
                    <?php $i_menu++; } ?>
                </ul>
            </div>
            </div> 
            <div class="flex-fill"></div>
            <?php 
            $site_n = $quantity[$_mid['object']];
            $category_count   = io_get_category_count($_mid['object_id']);//10;//$_mid->category_count;
            $count            = $site_n;
            if($site_n == 0)  $count = min(get_option('posts_per_page'),$category_count);
            if($site_n >= 0 && $count < $category_count){
                $link = $_mid['url'];//esc_url( get_term_link( $_mid, $taxonomy ) );
                echo "<a class='btn-move tab-move text-xs ml-2' href='$link' style='line-height:34px'>more+</a>";
            }
            elseif($site_n >= 0) {
                echo "<a class='btn-move tab-move text-xs ml-2' href='#' style='line-height:34px;display:none'>more+</a>";
            }
            ?>
        </div>
        <!-- tab模式菜单 end -->
        <div class="row ajax-<?php echo $parent_term['object_id'] ?> <?php echo io_get_option('site_card_mode') == 'min'?"row-sm":"" ?> mt-4" style="position: relative;">
        <?php show_card($site_n,$_mid['object_id'],$_mid['object']); ?>
        </div>
<?php } 

/**
 * 显示
 * @param  String $site_n 需显示的数量
 * @param  String $terms 分类id
 * @param  String $taxonomy 分类名
 */
function show_card($site_n,$terms,$taxonomy){
    if ( !in_array( $taxonomy,array('favorites','apps','category') ) ){
        echo "<div class='card py-3 px-4'><p style='color:#f00'>不是分类，请到菜单重新添加</p></div>";
        return;
    }
    if($taxonomy == "favorites") { 
        $args = array(      
            'meta_key' => '_sites_order',
            'orderby'  => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
        );
    } elseif($taxonomy == "apps") { 
        $args = array(      
            'orderby' => 'modified',
            'order'   => 'DESC',
        );
    } elseif($taxonomy == "category") {
        $args = array(      
            'orderby' => 'date',
            'order'   => 'DESC',
        );
    }
    global $post;  
    $args2 = array(      
        'ignore_sticky_posts' => 1,              
        'posts_per_page'      => $site_n,    
        'tax_query'           => array(
            array(
                'taxonomy' => $taxonomy,       
                'field'    => 'id',            
                'terms'    => $terms,    
            )
        ),
    );
    $myposts = new WP_Query( array_merge($args,$args2) );
    if(!$myposts->have_posts()): ?>
        <div class="col-lg-12">
            <div class="nothing mb-4"><?php _e('没有内容','i_theme') ?></div>
        </div>
    <?php
    elseif ($myposts->have_posts()): while ($myposts->have_posts()): $myposts->the_post(); 
    
    if($taxonomy == "favorites"){
        if(current_user_can('level_10') || !get_post_meta($post->ID, '_visible', true)){
            $link_url = get_post_meta($post->ID, '_sites_link', true); 
            $default_ico = get_theme_file_uri('/images/favicon.png');
            if(io_get_option('site_card_mode') == 'max'){ ?>
                <div class="url-card <?php get_columns() ?> <?php echo before_class($post->ID) ?>">
                <?php include( get_theme_file_path('/templates/card-sitemax.php') ); ?>
                </div>
            <?php }elseif(io_get_option('site_card_mode') == 'min'){ ?>
                <div class="url-card col-6 <?php get_columns() ?> <?php echo before_class($post->ID) ?>">
                <?php include( get_theme_file_path('/templates/card-sitemini.php') ); ?>
                </div>
            <?php }else{ ?>
                <div class="url-card <?php echo io_get_option('two_columns')?"col-6":"" ?> <?php get_columns() ?> <?php echo before_class($post->ID) ?>">
                <?php include( get_theme_file_path('/templates/card-site.php') ); ?>
                </div>
            <?php }
        }
    } elseif($taxonomy == "apps") {
        if(io_get_option('app_card_mode') == 'card'){
            echo'<div class="col-12 col-md-6 col-lg-4 col-xxl-5a ">';
            include( get_theme_file_path('/templates/card-appcard.php') ); 
            echo'</div>';
        }else{
            echo'<div class="col-4 col-md-3 col-lg-2 col-xl-8a col-xxl-10a pb-1">';
            include( get_theme_file_path('/templates/card-app.php') ); 
            echo'</div>';
        }
    } elseif($taxonomy == "category") {
        if(io_get_option('post_card_mode')=="card"){
            echo '<div class="col-12 col-md-6 col-lg-4 col-xxl-3">';
            get_template_part( 'templates/card','postmin' );
            echo '</div>';
        }elseif(io_get_option('post_card_mode')=="default"){
            echo '<div class="col-6 col-md-4 col-xl-3 col-xxl-6a py-2 py-md-3">';
            get_template_part( 'templates/card','post' );
            echo '</div>';
        } 
    }

    endwhile; endif; wp_reset_query();
}