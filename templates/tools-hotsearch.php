<?php if ( ! defined( 'ABSPATH' ) ) { exit; } 

if( $hotlist= io_get_option('hot_list_id') ){
if(!empty($hotlist['enabled'])){
    echo '<div class="row row-sm mb-3">';
    foreach ($hotlist['enabled'] as $key => $value) {
        hot_search($key);
    } 
    echo '</div>';
}
}
