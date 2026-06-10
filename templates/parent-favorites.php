<?php if ( ! defined( 'ABSPATH' ) ) { exit; }?>
<?php get_header();?>


<?php 
include( 'sidebar-nav.php' );
?>
<div class="main-content flex-fill">
<?php include( 'header-banner.php' ); ?>

    <div id="content" class="content-site customize-site">

    <?php  

    // 加载搜索模块 
    if(io_get_option('search_position') && in_array("home",io_get_option('search_position')) ){
        get_template_part( 'templates/tools','search' );
    } else {
        echo '<div class="no-search my-2 p-1"></div>';
    }   
 
    ?>  

    
     
                <div class="card mb-4">
                    <div class="card-body">
                        <h1 class="text-gray text-lg m-0"><?php single_cat_title() ?></h1>
                    </div>
                </div>
        <?php
        // 加载网址模块  
                $children = get_categories(array(
                    'taxonomy'   => 'favorites',
                    'meta_key'   => '_term_order',
                    'orderby'    => 'meta_value_num',
                    'order'      => 'desc',
                    'child_of'   => get_queried_object_id(),
                    'hide_empty' => 0
                ));
                if( $children ){  
                    foreach($children as $mid) { 
                        fav_con($mid);
                    } 
                } 
        ?>   
 
    </div> 
<?php
get_footer();
