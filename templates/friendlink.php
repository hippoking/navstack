<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

        <?php if( io_get_option('show_friendlink') && io_get_option('links')) : ?>
        <h4 class="text-gray text-lg mb-4">
            <i class="iconfont icon-book-mark mr-2" id="friendlink"></i><?php _e('友情链接','i_theme') ?>
        </h4>
        <div class="friendlink text-xs card">
            <div class="card-body">
                <?php wp_list_bookmarks('title_li=&before=&after=&categorize=0&show_images=0&orderby=rating&order=DESC&category='.get_option('link_f_cat')); ?>
            </div> 
        </div> 
        <?php endif; ?> 
        