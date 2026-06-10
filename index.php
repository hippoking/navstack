<?php if ( ! defined( 'ABSPATH' ) ) { exit; }?>
<?php get_header();?>


<?php 
include( 'templates/sidebar-nav.php' );
?>
<div class="main-content flex-fill">
<?php get_template_part( 'templates/header','banner' ); ?>

    <div id="content" class="content-site customize-site">

    <?php  
    // Load bulletin module
    get_template_part( 'templates/bulletin' );  

    // Load search module 
    if(io_get_option('search_position') && in_array("home",io_get_option('search_position')) ){
        get_template_part( 'templates/tools','search' );
    } else {
        echo '<div class="no-search my-2 p-1"></div>';
    }
 
    // Load ad module
    get_template_part( 'templates/ads','hometop' );

    // Load article module
    get_template_part( 'templates/article','list' ); 

    // Load article module
    get_template_part( 'templates/tools','hotsearch' ); 

    // Load article module
    get_template_part( 'templates/tools','post' ); 

    // Load custom module
    get_template_part( 'templates/tools','customize' ); 

    // Load trending module
    get_template_part( 'templates/tools','hotcontent' ); 

    // Load second ad module
    get_template_part( 'templates/ads','homesecond' );

    // Load site module
    foreach($categories as $category) {
        if($category['menu_item_parent'] == 0){
            if(empty($category['submenu'])){ 
                if($category['type'] != 'taxonomy') {
                    $url = trim($category['url']);
                    if( strlen($url)>1 && substr( $url, 0, 1 ) != '#') 
                        echo "<div class='card py-3 px-4'><p style='color:#f00'>“{$category['title']}”不是分类，请到菜单重新添加</p></div>";
                    continue;
                } elseif ( $category['type'] == 'taxonomy' && in_array( $category['object'],array('favorites','apps','category') ) ){
                    fav_con_a($category);
                } else {
                    echo "<div class='card py-3 px-4'><p style='color:#f00'>“{$category['title']}”不是分类，请到菜单重新添加</p></div>";
                }
            }else{
                if(io_get_option("tab_type")) {
                    fav_con_tab_a($category['submenu'],$category);
                }else{
                    foreach($category['submenu'] as $mid) {
                        fav_con_a($mid,$category['title']);
                    }
                }
            }
        }
    } 
      
    // Load link ad module
    get_template_part( 'templates/ads','homelink' );
    // Load friend links module
    get_template_part( 'templates/friendlink' ); ?>   
    </div> 
<?php
get_footer();
