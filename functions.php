<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

date_default_timezone_set('Asia/Shanghai');

require get_theme_file_path('/inc/inc.php'); 

add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup(){
    load_theme_textdomain( 'i_theme', get_template_directory() . '/languages' );
    load_theme_textdomain( 'io_setting', get_template_directory() . '/languages' );
}

// Make the login page logo link point to the homepage
add_filter('login_headerurl',function() {return get_bloginfo('url');});
// Make the login page logo title use the blog subtitle
add_filter('login_headertext',function() {return get_bloginfo( 'description' );});

/**
 * Open the dashboard after enabling the theme
 */
add_action('load-themes.php', 'Init_theme');
function Init_theme(){
    global $pagenow;
    if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
        update_option( 'thumbnail_size_w',0 );
        update_option( 'thumbnail_size_h', 0 );
        update_option( 'thumbnail_crop', 0 );
        update_option( 'medium_size_w',0 );
        update_option( 'medium_size_h', 0 );
        update_option( 'large_size_w',0 );
        update_option( 'large_size_h', 0 );
        wp_redirect( admin_url( '/index.php' ) );
        exit;
    }
}


/**
 * Disable automatic generation of 768px thumbnails
 */
function shapeSpace_customize_image_sizes($sizes) {
    unset($sizes['medium_large']);
    return $sizes;
  }
add_filter('intermediate_image_sizes_advanced', 'shapeSpace_customize_image_sizes');
/**
 * Disable WordPress image srcset and sizes attributes
 */
add_filter( 'add_image_size', function(){return 1;} );
add_filter( 'wp_calculate_image_srcset_meta', '__return_false' );
 
/**
 * Disable WordPress automatic thumbnail generation
 */
function ztmao_remove_image_size($sizes) {
    unset( $sizes['small'] );
    unset( $sizes['medium'] );
    unset( $sizes['large'] );
    return $sizes;
}
add_filter('image_size_names_choose', 'ztmao_remove_image_size');


# Support custom features
# ------------------------------------------------------------------------------
//add_action( 'admin_notices', 'webstacks_init_check' );
function webstacks_init_check(){
    $html = '<div id="notice-warning-tgmpa" class="notice notice-warning is-dismissible">
                <p>
                    <b>提示：</b> 启用主题或者更新主题后请保存主题设置，不然可能会报错，
                    <a href="'.get_option('siteurl').'/wp-admin/admin.php?page=theme_settings#tab=1">立即前往保存</a>
                </p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text">忽略此通知。</span></button>
            </div>';
    echo $html;
}
//add_action( 'after_switch_theme', 'active_webstacks_notice');
function active_webstacks_notice() {
    $notice = '<div id="setting-error-tgmpa" class="notice notice-info is-dismissible"> 
				<p>
					<b>通知：</b> WebStacks PRO 主题已激活，鉴于之前很多用户使用时都遇到了问题，请您先去 
     				<a href="'.get_option('siteurl').'/wp-admin/index.php">仪表盘</a>仔细阅读使用说明，谢谢！ 
     			</p> 
     			<button type="button" class="notice-dismiss"><span class="screen-reader-text">忽略此通知。</span></button> 
     		</div>';
    echo $notice;
}
# Notes
# ------------------------------------------------------------------------------
add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' );
function custom_dashboard_help() {
    echo '<li style="font-size:18px;color: red">'.__('先保存一遍主题设置选项，否则会报错','i_theme').'</li>
        <p>首次安装检查如下设置：</p>
		<ul style="list-style:decimal;padding-left:15px">
            <li>404问题请检查服务器伪静态规则和wp固定链接格式，推荐“/%post_id%.html”。</li>
            <li>首次启用主题必须保存一遍主题选项才能打开首页，否则可能会报错。</li>
            <li style="color: red">启用主题前请禁用所有插件，以免插件冲突。</li>
		</ul>
		<p>主题使用注意事项：</p>
		<ul style="list-style:decimal;padding-left:15px">
			<li>请先查看：<a href="https://www.iowen.cn/wordpress-version-webstack/" target="_blank">主题使用说明</a></li>
            <li>菜单图标设置请查看主题使用说明和群公共。</li>
            <li>先创建网址分类，然后这添加网址。</li>
            <li>分类最多两级，且第一级不要添加内容。</li>
            <li style="color: red">更新主题后请重新保存主题设置。</li>
            <li>文章缩略图报错或者不显示，请添加图床地址url到主题根目录的timthumb.php文件的第130行下面，按示例格式添加。</li>
			<li>投搞、博客等页面请新建页面然后选择对应的页面模板。</li>
            <li>阿里图标 Iconfont：<a href="https://www.iowen.cn/webstack-pro-navigation-theme-iconfont/" target="_blank">使用方法</a></li>
            <li>侧栏菜单设置方法：<a href="https://www.iowen.cn/webstack-pro-theme-main-menu-setting-description/" target="_blank" style="color: red">必看</a></li>
        </ul>
        <p>推荐插件：</p>
		<ul style="list-style:decimal;padding-left:15px">
            <li>自动将文章、分类、标签的地址转化为拼音，<a href="https://wordpress.org/plugins/so-pinyin-slugs/" target="_blank">获取插件</a></li>
            <li>对象缓存插件 Memcached， <a href="https://www.baidu.com/s?wd=wordpress%20Memcached" target="_blank">使用方法</a></li>
            <li>XML Sitemap插件，<a href="https://wordpress.org/plugins/xml-sitemap-feed/" target="_blank">获取插件</a></li>
            <li style="color: red">如果不会操作，可以都不用哦 --. 不影响使用</li>
		</ul>
        <br>
        <p>---> 下载 <a href="https://www.iowen.cn/webstack-pro-theme-presentation-data-import-instructions/" target="_blank">演示数据</a> <---</p>
    ';
}
function example_add_dashboard_widgets() {
    wp_add_dashboard_widget('custom_help_widget', __('WebStacks PRO 主题使用说明','i_theme'), 'custom_dashboard_help');
}
















// Compatibility adjustments
// Change custom types
// Get image ID from image URL
function io_get_attachment_id ($img_url) {
	$cache_key	= md5($img_url);
	$post_id	= wp_cache_get($cache_key, 'io_attachment_id' );
	if($post_id == false){

		$attr		= wp_upload_dir();
		$base_url	= $attr['baseurl']."/";
		$path = str_replace($base_url, "", $img_url);
		if($path){
			global $wpdb;
			$post_id	= $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = '{$path}'");
			$post_id	= $post_id?$post_id:'';
		}else{
			$post_id	= '';
		}

		wp_cache_set( $cache_key, $post_id, 'io_attachment_id', 86400);
	}
	return $post_id;
}
function change_app_meta(){ 
    $args = array(
        'post_type' => array('app'), 
        'post_status' => 'publish',
        'meta_key' => 'app_screenshot', 
        'posts_per_page'      => -1,   
    );
    $invalid_items = new WP_Query( $args ); 
    if ($invalid_items->have_posts()) : while ( $invalid_items->have_posts() ) : $invalid_items->the_post();
        if($formal_url = get_post_meta(get_the_ID(), 'app_screenshot', true)){
            //echo "-id/".get_the_ID();
            $id_list=''; 
            foreach ($formal_url as $value) {
                if($value['app_screen']['id']!='')
                    $id_list .= $value['app_screen']['id'].',';
                else
                    $id_list .= io_get_attachment_id($value['app_screen']['url']).',';
            }
            $id_list = rtrim($id_list, ',');
            update_post_meta(get_the_ID(), '_app_screenshot', $id_list);
        }
    endwhile;endif; 
    wp_reset_postdata();
    update_option('io_is_to', 1 );
}
function change_sites_meta(){ 
    $args = array(
        'post_type' => array('sites'), 
        'post_status' => 'publish',
        'meta_key' => '_rar_screenshot',  
        'posts_per_page'      => -1,  
    );
    $invalid_items = new WP_Query( $args ); 
    if ($invalid_items->have_posts()) : while ( $invalid_items->have_posts() ) : $invalid_items->the_post();
        if($formal_url = get_post_meta(get_the_ID(), '_rar_screenshot', true)){
            //echo "-id/".get_the_ID();
            $id_list=''; 
            foreach ($formal_url as $value) {
                if($value['rar_screen']['id']!='')
                    $id_list .= $value['rar_screen']['id'].',';
                else
                    $id_list .= io_get_attachment_id($value['rar_screen']['url']).',';
            }
            $id_list = rtrim($id_list, ',');
            update_post_meta(get_the_ID(), '_sites_screenshot', $id_list);
        }
    endwhile;endif; 
    wp_reset_postdata();
    update_option('io_is_to', 1 );
}
function change_sites_down(){ 
    $args = array(
        'post_type' => array('sites'), 
        'post_status' => 'publish',
        'meta_key' => '_sites_down', 
        'posts_per_page'      => -1,   
    );
    $invalid_items = new WP_Query( $args ); 
    if ($invalid_items->have_posts()) : while ( $invalid_items->have_posts() ) : $invalid_items->the_post();
        if($down_url = get_post_meta(get_the_ID(), '_sites_down', true)){
            //echo "-id/".get_the_ID();
            $down_list=array();  
            $down_list['down_btn_name'] = '网盘下载';
            $down_list['down_btn_url'] = $down_url;
            $down_list['down_btn_tqm'] = get_post_meta(get_the_ID(), '_sites_password', true)?:'';
            $down_list['down_btn_info'] = '';
            update_post_meta(get_the_ID(), '_down_url_list', array($down_list));
        }
    endwhile;endif; 
    wp_reset_postdata();
    update_option('io_is_to', 1 );
}
function change_sites_ico(){ 
    $args = array(
        'post_type' => array('sites'), 
        'post_status' => 'publish',
        'meta_key' => '_thumbnail', 
        'posts_per_page'      => -1,   
    );
    $invalid_items = new WP_Query( $args ); 
    if ($invalid_items->have_posts()) : while ( $invalid_items->have_posts() ) : $invalid_items->the_post();
        if($img_url = get_post_meta(get_the_ID(), '_thumbnail', true)){
            //echo "<br>-id/".get_the_ID();
            if(is_array($img_url))
                update_post_meta(get_the_ID(), '_thumbnail', $img_url['url'] );
        }
    endwhile;endif; 
    wp_reset_postdata();
    update_option('io_is_to', 1 );
}
function change_sites_qr(){ 
    $args = array(
        'post_type' => array('sites'), 
        'post_status' => 'publish',
        'meta_key' => '_wechat_qr', 
        'posts_per_page'      => -1,  
    );
    $invalid_items = new WP_Query( $args ); 
    if ($invalid_items->have_posts()) : while ( $invalid_items->have_posts() ) : $invalid_items->the_post();
        $img_url = get_post_meta(get_the_ID(), '_wechat_qr', true); 
        //echo "<br>-id/".get_the_ID();
        if(is_array($img_url)){
            update_post_meta(get_the_ID(), '_wechat_qr', $img_url['url'] );}
        
    endwhile;endif; 
    wp_reset_postdata();
    update_option('io_is_to', 1 );
}
function change_app_ico(){ 
    $args = array(
        'post_type' => array('app'), 
        'post_status' => 'publish',
        'meta_key' => '_app_ico',  
        'posts_per_page'      => -1, 
    );
    $invalid_items = new WP_Query( $args ); 
    if ($invalid_items->have_posts()) : while ( $invalid_items->have_posts() ) : $invalid_items->the_post();
        if($img_url = get_post_meta(get_the_ID(), '_app_ico', true)){
            if(is_array($img_url)){
                //echo "<br>-id/".get_the_ID();
                update_post_meta(get_the_ID(), '_app_ico', $img_url['url'] );}
        }
    endwhile;endif; 
    wp_reset_postdata();
    update_option('io_is_to', 1 );
}
if( io_get_option('pro_allback') &&  is_admin() && get_option( 'io_is_to',0 )!=1){
  
    change_app_meta(); // Move app screenshots to the new field; if apps exist in beta versions after 2.0218, run once
    change_app_ico();

    change_sites_meta();// Move site download screenshots to the new field; if screenshots were added in beta versions after 2.0218, run once
    change_sites_down();// Move site download URLs to the new field; if download resources exist in version 2.0218 or earlier, run once
    change_sites_ico();// Convert site icons to the new format; run once for version 2.0218 and earlier
    change_sites_qr();// Convert WeChat QR codes to the new format; run once for version 2.0218 and earlier
}
