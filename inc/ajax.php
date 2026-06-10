<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

//图片上传
add_action('wp_ajax_nopriv_img_upload', 'io_img_upload');  
add_action('wp_ajax_img_upload', 'io_img_upload');
function io_img_upload(){  
	$extArr = array("jpg", "png", "jpeg");
	$file = $_FILES['files'];
	if ( !empty( $file ) ) {
	    $wp_upload_dir = wp_upload_dir();                                     // 获取上传目录信息
	    $basename = $file['name'];
	    $baseext = pathinfo($basename, PATHINFO_EXTENSION);
	    $dataname = date("YmdHis_").substr(md5(time()), 0, 8) . '.' . $baseext;
	    $filename = $wp_upload_dir['path'] . '/' . $dataname;
	    rename( $file['tmp_name'], $filename );                               // 将上传的图片文件移动到上传目录
	    $attachment = array(
	        'guid'           => $wp_upload_dir['url'] . '/' . $dataname,      // 外部链接的 url
	        'post_mime_type' => $file['type'],                                // 文件 mime 类型
	        'post_title'     => preg_replace( '/\.[^.]+$/', '', $basename ),  // 附件标题，采用去除扩展名之后的文件名
	        'post_content'   => '',                                           // 文章内容，留空
	        'post_status'    => 'inherit'
	    );
	    $attach_id = wp_insert_attachment( $attachment, $filename );          // 插入附件信息
	    if($attach_id != 0){
	        require_once( ABSPATH . 'wp-admin/includes/image.php' );          // 确保包含此文件，因为wp_generate_attachment_metadata（）依赖于此文件。
	        $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	        wp_update_attachment_metadata( $attach_id, $attach_data );        // 生成附件的元数据，并更新数据库记录。
	        print_r(json_encode(array('status'=>1,'msg'=>__('图片添加成功','i_theme'),'data'=>array('id'=>$attach_id,'src'=>wp_get_attachment_url( $attach_id ),'title'=>$basename))));
	        exit();
	    }else{
	        echo '{"status":4,"msg":"'.__('图片上传失败！','i_theme').'"}';
	        exit();
	    }
	} 
}

//删除图片
add_action('wp_ajax_nopriv_img_remove', 'io_img_remove');  
add_action('wp_ajax_img_remove', 'io_img_remove');
function io_img_remove(){    
	$attach_id = sanitize_key($_POST["id"]);
	if( empty($attach_id) ){
		echo '{"status":3,"msg":"'.__('没有上传图像！','i_theme').'"}';
		exit;
	}

	if($attach_id <= 0)
		return;

	if ( false === wp_delete_attachment( $attach_id ) )
		echo '{"status":4,"msg":"'.__('图片','i_theme').' '.$attach_id.' '.__('删除失败！','i_theme').'"}';
	else
		echo '{"status":1,"msg":"'.__('删除成功！','i_theme').'"}';
	exit; 
}


// 接收前端ajax参数
add_action('wp_ajax_title_checks', 'duplicate_title_checks_callback');
	function duplicate_title_checks_callback(){
	global $wpdb;           
	$title = $_POST['post_title'];
	$post_id = $_POST['post_id'];
	$titles = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'
	AND post_title = '{$title}' AND ID != {$post_id} ";
	$results = $wpdb->get_results($titles);
	if($results) {
	echo "<span style='color:red'>". _( '此标题已存在，请换一个标题！' , '' ) ." </span>";
	} else {
	echo '<span style="color:green">'._('恭喜，此标题未与其他文章标题重复！' , '').'</span>';
	}
	die();
}


//提交文章
add_action('wp_ajax_nopriv_contribute_post', 'io_contribute');  
add_action('wp_ajax_contribute_post', 'io_contribute');
function io_contribute(){  
	$delay = 60; 
	if( isset($_COOKIE["tougao"]) && ( time() - $_COOKIE["tougao"] ) < $delay ){
		error('{"status":2,"msg":"'.sprintf( __('您投稿也太勤快了吧，“%1$s”秒后再试！', 'i_theme'), $delay - ( time() - $_COOKIE["tougao"] ) ).'"}');
	} 
	  
	//表单变量初始化
	$sites_type         = isset( $_POST['tougao_type'] ) ? trim(htmlspecialchars($_POST['tougao_type'], ENT_QUOTES)) : '';
	$sites_link         = isset( $_POST['tougao_sites_link'] ) ? trim(htmlspecialchars($_POST['tougao_sites_link'], ENT_QUOTES)) : '';
	$sites_sescribe     = isset( $_POST['tougao_sites_sescribe'] ) ? trim(htmlspecialchars($_POST['tougao_sites_sescribe'], ENT_QUOTES)) : '';
	$title              = isset( $_POST['tougao_title'] ) ? trim(htmlspecialchars($_POST['tougao_title'], ENT_QUOTES)) : '';
	$category           = isset( $_POST['tougao_cat'] ) ? sanitize_key($_POST['tougao_cat']) : '0';
	$sites_ico          = isset( $_POST['tougao_sites_ico'] ) ? trim(htmlspecialchars($_POST['tougao_sites_ico'], ENT_QUOTES)) : '';
	$wechat_qr          = isset( $_POST['tougao_wechat_qr'] ) ? trim(htmlspecialchars($_POST['tougao_wechat_qr'], ENT_QUOTES)) : '';
	$content            = isset( $_POST['tougao_content'] ) ? trim(htmlspecialchars($_POST['tougao_content'], ENT_QUOTES)) : '';
	$keywords           = isset( $_POST['tougao_sites_keywords'] ) ? trim(htmlspecialchars($_POST['tougao_sites_keywords'], ENT_QUOTES)) : '';
	$publish            = isset( $_POST['is_publish'] ) ? $_POST['is_publish'] : '0';

	
	$down_version       = isset( $_POST['tougao_down_version'] ) ? trim(htmlspecialchars($_POST['tougao_down_version'], ENT_QUOTES)) : '';//资源版本
	$down_formal        = isset( $_POST['tougao_down_formal'] ) ? trim(htmlspecialchars($_POST['tougao_down_formal'], ENT_QUOTES)) : '';//官网链接
	$sites_down         = isset( $_POST['tougao_sites_down'] ) ? trim(htmlspecialchars($_POST['tougao_sites_down'], ENT_QUOTES)) : '';//网盘链接
	$down_preview       = isset( $_POST['tougao_down_preview'] ) ? trim(htmlspecialchars($_POST['tougao_down_preview'], ENT_QUOTES)) : '';//演示链接
	$sites_password     = isset( $_POST['tougao_sites_password'] ) ? trim(htmlspecialchars($_POST['tougao_sites_password'], ENT_QUOTES)) : '';//网盘密码
	$down_decompression = isset( $_POST['tougao_down_decompression'] ) ? trim(htmlspecialchars($_POST['tougao_down_decompression'], ENT_QUOTES)) : '';//解压密码

	$typename = __('网站','i_theme');
	if( $sites_type == 'down' )
	$typename = __('资源','i_theme');
	if( $sites_type == 'wechat' )
	$typename = __('公众号','i_theme');

	$post_status = 'pending';
	if($publish != '0'){
		if(io_get_option('tougao_category'))
			$category = io_get_option('tougao_category');
		$post_status = 'publish';
	}

	// 表单项数据验证
	if ( empty($title) || mb_strlen($title) > 30 ) {
		error('{"status":4,"msg":"'.$typename.__('名称必须填写，且长度不得超过30字。','i_theme').'"}');
	}
	global $wpdb; 
	$titles = "SELECT post_title FROM $wpdb->posts WHERE post_status IN ('pending','publish') AND post_type = 'sites' AND post_title = '{$title}'";
	if($wpdb->get_results($titles)) {
		error('{"status":4,"msg":"'.__('存在相同的名称，请不要重复提交哦！','i_theme').'"}');
	}

	if ( $sites_type=='sites' && empty($sites_link) || (!empty($sites_link) && !preg_match('/http(s)?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $sites_link))){
		error('{"status":3,"msg":"'.$typename.__('链接必须填写，且必须符合URL格式。','i_theme').'"}');
	}
	$meta_value = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_value = '{$sites_link}' AND meta_key='_sites_link'";
	if($wpdb->get_results($meta_value)) {
		error('{"status":4,"msg":"'.__('存在相同的链接地址，请不要重复提交哦！','i_theme').'"}');
	}

	if ( empty($sites_sescribe) || mb_strlen($sites_sescribe) > 50 ) {
		error('{"status":4,"msg":"'.$typename.__('描叙必须填写，且长度不得超过50字。','i_theme').'"}');
	}
	if ( $category == "0" ){
		error('{"status":4,"msg":"'.__('请选择分类。','i_theme').'"}');
	}
	if ( !empty(get_term_children($category, 'favorites'))){
		error('{"status":4,"msg":"'.__('不能选用父级分类目录。','i_theme').'"}');
	}
	if ( $sites_type=='wechat' && empty($wechat_qr)) {
		error('{"status":4,"msg":"'.__('必须添加二维码。','i_theme').'"}');
	}
	//if ( empty($content) || mb_strlen($content) > 10000 || mb_strlen($content) < 6) {
	//	error('{"status":4,"msg":"内容必须填写，且长度不得超过10000字，不得少于6字。"}');
	//}
	if( $sites_type == 'down'){
		if ( empty($down_formal) && empty($sites_down) ) {
			error('{"status":4,"msg":"'.__('“官网地址”和“网盘地址”怎么地也待填一个把。','i_theme').'"}');
		}
	}
	//if(!empty($sites_ico)){
	//	$sites_ico = array(
	//		'url'       => $sites_ico,  
	//		'thumbnail' => $sites_ico, 
	//	);
	//}
	//if(!empty($wechat_qr)){
	//	$wechat_qr = array(
	//		'url'       => $wechat_qr,  
	//		'thumbnail' => $wechat_qr, 
	//	);
	//}
	$down_list = array();
	if(!empty($sites_down)){ 
            $down_list['down_btn_name'] = '网盘下载';
            $down_list['down_btn_url'] = $sites_down;
            $down_list['down_btn_tqm'] = $sites_password;
            $down_list['down_btn_info'] = '';
	}
	$tougao = array(
		'comment_status'   => 'closed',
		'ping_status'      => 'closed',
		//'post_author'      => 1,//用于投稿的用户ID
		'post_title'       => $title,
		'post_content'     => $content,
		'post_status'      => $post_status,
		'post_type'        => 'sites',
		//'tax_input'        => array( 'favorites' => array($category) ) //游客不可用
	);
	
	// 将文章插入数据库
	$status = wp_insert_post( $tougao );
	if ($status != 0){
		global $wpdb;
		add_post_meta($status, '_sites_type', $sites_type);
		add_post_meta($status, '_sites_sescribe', $sites_sescribe);
		add_post_meta($status, '_sites_link', $sites_link);
		add_post_meta($status, '_down_version', $down_version);
		add_post_meta($status, '_down_formal', $down_formal);
		//add_post_meta($status, '_sites_down', $sites_down);
		add_post_meta($status, '_down_preview', $down_preview);
		//add_post_meta($status, '_sites_password', $sites_password);
		add_post_meta($status, '_down_url_list', array($down_list));//----
		add_post_meta($status, '_dec_password', $down_decompression);
		add_post_meta($status, '_sites_order', '0');
		if( !empty($sites_ico))
			add_post_meta($status, '_thumbnail', $sites_ico); 
		if( !empty($wechat_qr))
			add_post_meta($status, '_wechat_qr', $wechat_qr); 
		wp_set_post_terms( $status, array($category), 'favorites'); //设置文章分类
		if(!empty($keywords)) wp_set_post_terms( $status, explode(',', $keywords), 'sitetag'); //设置文章tag
		setcookie("tougao", time(), time()+$delay+10);
		error('{"status":1,"msg":"'.__('投稿成功！','i_theme').'"}');
	}else{
		error('{"status":4,"msg":"'.__('投稿失败！','i_theme').'"}');
	}
}
 

//提交评论
add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');
function fa_ajax_comment_callback(){
    $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
    if ( is_wp_error( $comment ) ) {
        $data = $comment->get_error_data();
        if ( ! empty( $data ) ) {
			error('{"status":4,"msg":"'.$comment->get_error_message().'"}', true);
        } else {
            exit;
        }
    }
    $user = wp_get_current_user();
    do_action('set_comment_cookies', $comment, $user);
    $GLOBALS['comment'] = $comment; //根据你的评论结构自行修改，如使用默认主题则无需修改
    ?> 
	<li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>" style="position: relative;">
		<div id="comment-<?php comment_ID(); ?>" class="comment_body d-flex flex-fill">	
			<div class="profile mr-2 mr-md-3"> 
                <?php 
                echo  get_avatar( $comment, 96, '', get_comment_author() );
                ?>
			</div>					
			<section class="comment-text d-flex flex-fill flex-column">
				<div class="comment-info d-flex align-items-center mb-1">
					<div class="comment-author text-sm"><?php comment_author_link(); ?>
					<?php is_master( $comment->comment_author_email ); echo site_rank( $comment->comment_author_email, $comment->user_id ); ?>
					</div>										
				</div>
				<div class="comment-content d-inline-block text-sm">
					<?php comment_text(); ?> 
		    	    <?php
		    	    if ($comment->comment_approved == '0'){
  		    	    echo '<span class="cl-approved">('.__('您的评论需要审核后才能显示！','i_theme').')</span><br />';
		    	    } 
		    	    ?>
				</div>
				<div class="d-flex flex-fill text-xs text-muted pt-2">
					<div class="comment-meta">
						<div class="info"><time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' );?>"><?php echo timeago(get_comment_date('Y-m-d G:i:s'));?></time></div>
					</div>
				</div>
			</section>
		</div>
		<div class="new-comment" style="background: #4bbbff;position: absolute;top: -1rem;bottom: 1rem;left: -1.25rem;right: -1.25rem;opacity: .2;"></div>
		</li>	
    <?php die();
}


// 查重
add_action('wp_ajax_nopriv_check_duplicate', 'io_check_duplicate');  
add_action('wp_ajax_check_duplicate', 'io_check_duplicate');
function io_check_duplicate(){ 
	global $wpdb;  

	$sites_link = isset( $_POST['sites_link'] ) ? trim(htmlspecialchars($_POST['sites_link'], ENT_QUOTES)) : '';
	$sites_link = rtrim($sites_link, '/');
	if(!empty($sites_link)){
		
		$meta_value = "SELECT meta_value FROM $wpdb->postmeta WHERE ( meta_value = '{$sites_link}' OR meta_value = '{$sites_link}/' ) AND meta_key='_sites_link'";
		if($wpdb->get_results($meta_value)) {
			echo __('存在相同的链接地址，请不要重复提交哦！','i_theme') ;
		}
		else{
			echo __('没用重复地址，可以提交！','i_theme') ;
		}  
	} else {
		echo __('请填写地址！','i_theme') ;
	}
	exit;  
}

//点赞
add_action('wp_ajax_nopriv_post_like', 'io_like_ajax_handler');  
add_action('wp_ajax_post_like', 'io_like_ajax_handler');
function io_like_ajax_handler(){  
	global $wpdb, $post;  
	if($post_id = sanitize_key($_POST["post_id"])){
		
		if($post_id <= 0)
			return;

		$like_count = get_post_meta($post_id, '_like_count', true);  

		$expire = time() + 99999999;  
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost  

		setcookie('liked_' . $post_id, $post_id, $expire, '/', $domain, false);  
		if (!$like_count || !is_numeric($like_count)){
			update_post_meta($post_id, '_like_count', 1);
		}else{
			update_post_meta($post_id, '_like_count', ($like_count + 1));
		}

		echo get_post_meta($post_id, '_like_count', true); 
	}
	exit;  
}
//设置链接失败
add_action('wp_ajax_nopriv_link_failed', 'io_link_failed');  
add_action('wp_ajax_link_failed', 'io_link_failed');
function io_link_failed(){  
	global $wpdb, $post;  
	if($post_id = (int) sanitize_key( $_POST["post_id"]) ){
		$is_inv = $_POST["is_inv"];
		if( $post_id > 0 ){
			$invalid_count = get_post_meta($post_id, 'invalid', true);  
			if( $is_inv=="false" ){
				if ( !$invalid_count || !is_numeric($invalid_count) ){
					update_post_meta($post_id, 'invalid', 1);
				}else{
					update_post_meta($post_id, 'invalid', ($invalid_count + 1));
				}
			} else {
				if ( ($invalid_count || is_numeric($invalid_count)) && $invalid_count > 0){ 
					update_post_meta($post_id, 'invalid', ($invalid_count - 1));
				}
			}
			echo "反馈成功 ".$is_inv; 
		}
	}
	exit;  
}

// 增加文章浏览统计
add_action( 'wp_ajax_io_postviews', 'io_n_increment_views' );
add_action( 'wp_ajax_nopriv_io_postviews', 'io_n_increment_views' );
function io_n_increment_views() {
	if( empty( $_GET['postviews_id'] ) )
		return;
 
	$post_id =  (int) sanitize_key( $_GET['postviews_id'] );
	if( $post_id > 0 ) {
		$views_count = get_post_meta($post_id, 'views', true);  
		if (!$views_count || !is_numeric($views_count)){
			$views_count = 0;
		}
		update_post_meta($post_id, 'views', ($views_count + 1));
		echo $views_count+1;
		exit();
	}
}

// 增加国家数据，临时方法
add_action( 'wp_ajax_io_set_country', 'io_set_country' );
add_action( 'wp_ajax_nopriv_io_set_country', 'io_set_country' );
function io_set_country() {
	if( empty( $_POST['id'] ) )
		return;
	$country = $_POST['country'];
	$post_id =  (int) sanitize_key( $_POST['id'] );
	if( $post_id > 0 ) { 
		update_post_meta($post_id, '_sites_country', $country); 
		exit();
	}
}
//显示模式切换
add_action('wp_ajax_nopriv_switch_dark_mode', 'io_switch_dark_mode');  
add_action('wp_ajax_switch_dark_mode', 'io_switch_dark_mode');
function io_switch_dark_mode(){    
	$mode = $_POST["mode_toggle"];
	$expire = time() + 99999999;  
	$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost  
	setcookie('night_mode', $mode, $expire, '/', $domain, false);  
	exit; 
}

// 增加app下载量
add_action( 'wp_ajax_down_count', 'io_add_down_count' );
add_action( 'wp_ajax_nopriv_down_count', 'io_add_down_count' );
function io_add_down_count() {
	if( empty( $_POST['id'] ) )
		return;
 
	$post_id =  (int) sanitize_key( $_POST['id'] );
	if( $post_id > 0 ) {
		$down_count = get_post_meta($post_id, '_down_count', true);  
		if (!$down_count || !is_numeric($down_count)){
			$down_count = 0;
		}
		update_post_meta($post_id, '_down_count', ($down_count + 1));
		echo $down_count+1;
		exit();
	}
}

// 加载热门网址   
add_action( 'wp_ajax_load_hot_sites' , 'load_hot_sites' );
add_action( 'wp_ajax_nopriv_load_hot_sites' , 'load_hot_sites' );
function load_hot_sites(){

    $meta_key = sanitize_text_field($_POST['type']); 
     
    global $post;
    $site_n = io_get_option('hot_n');
    $args = array(
        'post_type'           => 'sites',  
        'post_status'         => 'publish',        
        'ignore_sticky_posts' => 1,   
        'posts_per_page'      => $site_n,       
	);
	if($meta_key == 'date'){
		$args['orderby'] = 'date';
	}else{
		$args['meta_key'] = $meta_key;
		$args['orderby'] = array( 'meta_value_num' => 'DESC', 'date' => 'DESC' );
	}
    $myposts = new WP_Query( $args );
    if(!$myposts->have_posts()): ?>
        <div class="col-lg-12">
            <div class="nothing mb-4"><?php _e('没有数据！请开启统计并等待产生数据','i_theme') ?></div>
        </div>
    <?php
    elseif ($myposts->have_posts()): while ($myposts->have_posts()): $myposts->the_post(); 
        $link_url = get_post_meta($post->ID, '_sites_link', true); 
        $default_ico = get_theme_file_uri('/images/favicon.png');
        if(current_user_can('level_10') || !get_post_meta($post->ID, '_visible', true)):
    ?>
		<?php if(io_get_option("hot_card_mini")) {?>
        	<div class="url-card ajax-url col-6 <?php get_columns() ?> col-xxl-10a <?php echo before_class($post->ID) ?>">
            <?php include( get_theme_file_path('/templates/card-sitemini.php')  ); ?>
		<?php }else{?>
        	<div class="url-card <?php echo io_get_option('two_columns')?"col-6":"" ?> ajax-url <?php get_columns() ?> <?php echo before_class($post->ID) ?>">
            <?php include( get_theme_file_path('/templates/card-site.php')  );?>
		<?php }?>
        </div>
	<?php endif; endwhile; endif; wp_reset_postdata();  
	
    die();
}
// 加载热门app
add_action( 'wp_ajax_load_hot_app' , 'load_hot_app' );
add_action( 'wp_ajax_nopriv_load_hot_app' , 'load_hot_app' );
function load_hot_app(){

    $meta_key = sanitize_text_field($_POST['type']); 
     
    global $post;
    $site_n = io_get_option('hot_n');
    $args = array(
        'post_type'           => 'app', 
        'post_status'         => 'publish',         
        'ignore_sticky_posts' => 1,              
        'posts_per_page'      => $site_n,       
	);
	if($meta_key == 'date'){
		$args['orderby'] = 'date';
	}else{
		$args['meta_key'] = $meta_key;
		$args['orderby'] = array( 'meta_value_num' => 'DESC', 'date' => 'DESC' );
	}
    $myposts = new WP_Query( $args );
    if(!$myposts->have_posts()): ?>
        <div class="col-lg-12">
            <div class="nothing mb-4"><?php _e('没有数据！请开启统计并等待产生数据','i_theme') ?></div>
        </div>
    <?php
    elseif ($myposts->have_posts()): while ($myposts->have_posts()): $myposts->the_post();   
    ?> 
		<div class="col-12 col-md-6 col-lg-4 col-xxl-5a ajax-url">
		<?php
             
            include( get_theme_file_path('/templates/card-appcard.php') ); 
             
            ?>
        </div>
	<?php  endwhile; endif; wp_reset_postdata();  
	
    die();
}

// 首页TAB模式ajax加载内容     
add_action( 'wp_ajax_load_home_tab' , 'load_home_tab_post' );
add_action( 'wp_ajax_nopriv_load_home_tab' , 'load_home_tab_post' );
function load_home_tab_post(){

    $meta_id   = sanitize_key($_POST['id']); 
	$taxonomy  = $_POST['taxonomy'];
	
    $quantity = io_get_option('card_n'); 
    global $post;
	$link = "";
	$site_n           = $quantity[$taxonomy];
	$category_count   = get_term_by( 'id', $meta_id, $taxonomy )->count;//get_category( (int)$meta_id )->count;
	$count            = $site_n;
	if($site_n == 0)  $count = min(get_option('posts_per_page'),$category_count);
	if($site_n >= 0 && $count < $category_count){
		$link = get_category_link( $meta_id );
		//$link = esc_url( get_term_link( $_mid, 'res_category' ) );
	}
    $args = array(
		'ignore_sticky_posts' => 1,       
		'posts_per_page'      => $site_n,  
		'tax_query'           => array(
			array(
				'taxonomy' => $taxonomy,     
				'field'    => 'id',            
				'terms'    => $meta_id,     
			)
		),
    );
    // 不同类型的排序规则
    if($taxonomy == "favorites") {
        $args['meta_key'] ='_sites_order'; 
        $args['orderby']  =array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ); 
    } elseif($taxonomy == "apps") {
        $args['orderby'] ='modified'; 
        $args['order']  ='DESC'; 
	} elseif($taxonomy == "category") {
        $args['orderby'] ='date'; 
        $args['order']  ='DESC'; 
	}

    $myposts = new WP_Query( $args );
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
                <div class="url-card ajax-url <?php get_columns() ?> <?php echo before_class($post->ID) ?>">
                <?php include( get_theme_file_path('/templates/card-sitemax.php') ); ?>
                </div>
            <?php }elseif(io_get_option('site_card_mode') == 'min'){ ?>
                <div class="url-card ajax-url col-6 <?php get_columns() ?> <?php echo before_class($post->ID) ?>">
                <?php include( get_theme_file_path('/templates/card-sitemini.php') ); ?>
                </div>
            <?php }else{ ?>
                <div class="url-card ajax-url <?php echo io_get_option('two_columns')?"col-6":"" ?> <?php get_columns() ?> <?php echo before_class($post->ID) ?>">
                <?php include( get_theme_file_path('/templates/card-site.php') ); ?>
                </div>
            <?php
			}
		}
	} elseif($taxonomy == "apps") {
		if(io_get_option('app_card_mode') == 'card'){
			echo'<div class="col-12 col-md-6 col-lg-4 col-xxl-5a ajax-url">';
			include( get_theme_file_path('/templates/card-appcard.php') ); 
			echo'</div>';
		}else{
			echo'<div class="col-4 col-md-3 col-lg-2 col-xl-8a col-xxl-10a pb-1 ajax-url">';
			include( get_theme_file_path('/templates/card-app.php') ); 
			echo'</div>';
		}
	} elseif($taxonomy == "category") {
        if(io_get_option('post_card_mode')=="card"){
            echo '<div class="col-12 col-md-6 col-lg-4 col-xxl-3 ajax-url">';
            get_template_part( 'templates/card','postmin' );
            echo '</div>';
        }elseif(io_get_option('post_card_mode')=="default"){
            echo '<div class="col-6 col-md-4 col-xl-3 col-xxl-6a py-2 py-md-3 ajax-url">';
            get_template_part( 'templates/card','post' );
            echo '</div>';
        } 
    }

	endwhile;
	if($link != "") {?>
		<div id="ajax-cat-url" data-url="<?php echo $link ?>"></div>
	<?php } 
	endif; wp_reset_postdata();  
    die();
}


function error($ErrMsg, $err=false) {
	if($err){
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/json;charset=UTF-8');
	}
	echo $ErrMsg;
	exit;
} 