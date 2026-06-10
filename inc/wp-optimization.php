<?php if ( ! defined( 'ABSPATH' )  ) { die; }
/*
 * WordPress optimization
 */
 
# --------------------------------------------------------------------
# Disable post revisions
# --------------------------------------------------------------------
if(io_get_option('diable_revision')){ 
    remove_action('pre_post_update', 'wp_save_post_revision' ); 
    /** Disable autosave */
    add_action('wp_print_scripts', 'io_not_autosave');
    function io_not_autosave() {
        wp_deregister_script('autosave'); 
    } 
    // Disable revisions
    add_filter( 'wp_revisions_to_keep', 'io_disable_wp_revisions_to_keep', 10, 2 );
    function io_disable_wp_revisions_to_keep( $num, $post ) {
    	return 0;
    }
}
# --------------------------------------------------------------------
# Remove admin bar
# --------------------------------------------------------------------
if(io_get_option('remove_admin_bar')){
    add_filter('show_admin_bar', '__return_false');
}
# --------------------------------------------------------------------
# Disable texturize
# --------------------------------------------------------------------
if(io_get_option('disable_texturize')){
	add_filter('run_wptexturize', '__return_false');
}
# --------------------------------------------------------------------
# Disable Gutenberg
# --------------------------------------------------------------------
if(io_get_option('disable_gutenberg')){
    add_filter('use_block_editor_for_post_type', '__return_false');
}
# --------------------------------------------------------------------
# Disable site feed
# --------------------------------------------------------------------
if( io_get_option('disable_feed') ) {
    function io_disable_feed() {
        wp_die('<h1>'.sprintf(__('Feed已经关闭, 请访问网站<a href="%s">首页' , 'i_theme'), get_bloginfo('url')).'</a>!</h1>');
    }
    add_action('do_feed',      'io_disable_feed', 1);
    add_action('do_feed_rdf',  'io_disable_feed', 1);
    add_action('do_feed_rss',  'io_disable_feed', 1);
    add_action('do_feed_rss2', 'io_disable_feed', 1);
    add_action('do_feed_atom', 'io_disable_feed', 1);
}
# --------------------------------------------------------------------
# Disable the XML-RPC interface
# --------------------------------------------------------------------
if(io_get_option('disable_xml_rpc')){
    if(io_get_option('disable_gutenberg')){
        add_filter( 'xmlrpc_enabled', '__return_false' );
        remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
    }
}
# --------------------------------------------------------------------
# ----------
# --------------------------------------------------------------------
add_filter('register_taxonomy_args', function($args){
	// Disable REST API
	if(io_get_option('disable_rest_api')){
		$args['show_in_rest']	= false;
	}

	return $args;
});
add_filter('register_post_type_args', function($args){
	// Disable REST API
	if(io_get_option('disable_rest_api')){
		//$args['show_in_rest']	= false;// Does this affect Gutenberg?
	}

	if(!empty($args['supports']) && is_array($args['supports'])){
		// Disable trackbacks
		if(io_get_option('disable_trackbacks')){
			$args['supports']	= array_diff($args['supports'], ['trackbacks']);
		}

		// Disable post revision support
		if(io_get_option('diable_revision')){
			$args['supports']	= array_diff($args['supports'], ['revisions']);
		}
	}

	return $args;
});
# --------------------------------------------------------------------
# Disable trackbacks
# --------------------------------------------------------------------
if(io_get_option('disable_trackbacks')){
    if(io_get_option('disable_gutenberg') && io_get_option('disable_xml_rpc')){
        // Completely disable pingback
        add_filter('xmlrpc_methods',function($methods){
            $methods['pingback.ping'] = '__return_false';
            $methods['pingback.extensions.getPingbacks'] = '__return_false';
            return $methods;
        });
    }

    // Disable pingbacks, enclosures, and trackbacks
    remove_action( 'do_pings', 'do_all_pings', 10 );

    // Remove _encloseme and do_ping actions.
    remove_action( 'publish_post','_publish_post_hook',5 );

     
	add_action('post_comment_status_meta_box-options', function($post){
		echo "<style type='text/css'>label[for='ping_status']{display:none}</style>";
	}); 
}
# --------------------------------------------------------------------
# Disable REST API
# --------------------------------------------------------------------
if(io_get_option('disable_rest_api')){
	remove_action('init',			'rest_api_init' );
	remove_action('rest_api_init',	'rest_api_default_filters', 10 );
	remove_action('parse_request',	'rest_api_loaded' );

	add_filter('rest_enabled',		'__return_false');
	add_filter('rest_jsonp_enabled','__return_false');

	// Remove the wp-json tag from the head and the link from the HTTP header
	remove_action('wp_head',			'rest_output_link_wp_head', 10 );
	remove_action('template_redirect',	'rest_output_link_header', 11);

	remove_action('xmlrpc_rsd_apis',	'rest_output_rsd');

	remove_action('auth_cookie_malformed',		'rest_cookie_collect_status');
	remove_action('auth_cookie_expired',		'rest_cookie_collect_status');
	remove_action('auth_cookie_bad_username',	'rest_cookie_collect_status');
	remove_action('auth_cookie_bad_hash',		'rest_cookie_collect_status');
	remove_action('auth_cookie_valid',			'rest_cookie_collect_status');
	remove_filter('rest_authentication_errors',	'rest_cookie_check_errors', 100 );
}
# --------------------------------------------------------------------
# Remove unnecessary WP_Head code
# --------------------------------------------------------------------
if(io_get_option('remove_head_links')){
    remove_action( 'wp_head', 'wp_generator');					// Remove the WP version number from head
    foreach (['rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header', 'atom_head', 'comments_atom_head', 'opml_head', 'app_head'] as $action) {
        remove_action( $action, 'the_generator' );
    }
    remove_action( 'wp_head', 'rsd_link' );						// Remove the RSD link from head
    remove_action( 'wp_head', 'wlwmanifest_link' );				// Remove the Windows Live Writer manifest from head
    remove_action( 'wp_head', 'feed_links_extra', 3 );		  	// Remove feed-related links from head
    remove_action( 'wp_head', 'index_rel_link' );				// Remove home, parent, start, and adjacent post links from head
    remove_action( 'wp_head', 'parent_post_rel_link', 10);
    remove_action( 'wp_head', 'start_post_rel_link', 10);
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );	// Remove the shortlink from head
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10);	// Remove the WP REST API URL from head output
    remove_action( 'template_redirect',	'wp_shortlink_header', 11);		// Prevent shortlink header output.
    remove_action( 'template_redirect',	'rest_output_link_header', 11);	// Prevent header link output.
} 
# --------------------------------------------------------------------
# Disable admin privacy features
# --------------------------------------------------------------------
if(io_get_option('disable_privacy')){

    add_action('admin_menu', function (){
        global $menu, $submenu;

        // Remove the Privacy submenu under Settings.
        unset($submenu['options-general.php'][45]);

        // Remove related pages under the tools banner
        remove_action( 'admin_menu', '_wp_privacy_hook_requests_page' );

        remove_filter( 'wp_privacy_personal_data_erasure_page', 'wp_privacy_process_personal_data_erasure_page', 10, 5 );
        remove_filter( 'wp_privacy_personal_data_export_page', 'wp_privacy_process_personal_data_export_page', 10, 7 );
        remove_filter( 'wp_privacy_personal_data_export_file', 'wp_privacy_generate_personal_data_export_file', 10 );
        remove_filter( 'wp_privacy_personal_data_erased', '_wp_privacy_send_erasure_fulfillment_notification', 10 );

        // Privacy policy text changes check.
        remove_action( 'admin_init', array( 'WP_Privacy_Policy_Content', 'text_change_check' ), 100 );

        // Show a "postbox" with the text suggestions for a privacy policy.
        remove_action( 'edit_form_after_title', array( 'WP_Privacy_Policy_Content', 'notice' ) );

        // Add the suggested policy text from WordPress.
        remove_action( 'admin_init', array( 'WP_Privacy_Policy_Content', 'add_suggested_content' ), 1 );

        // Update the cached policy info when the policy page is updated.
        remove_action( 'post_updated', array( 'WP_Privacy_Policy_Content', '_policy_page_updated' ) );
    },9);
}
# --------------------------------------------------------------------
# Disable Emoji
# --------------------------------------------------------------------
if(io_get_option('emoji_switcher')){
	remove_action('admin_print_scripts','print_emoji_detection_script');
	remove_action('admin_print_styles',	'print_emoji_styles');

	remove_action('wp_head',			'print_emoji_detection_script',	7);
	remove_action('wp_print_styles',	'print_emoji_styles');

	remove_action('embed_head',			'print_emoji_detection_script');//

	remove_filter('the_content_feed',	'wp_staticize_emoji');
	remove_filter('comment_text_rss',	'wp_staticize_emoji');
	remove_filter('wp_mail',			'wp_staticize_emoji_for_email');

	add_filter('emoji_svg_url',		'__return_false');//
	add_filter('tiny_mce_plugins',	function($plugins){ //
		return array_diff($plugins, ['wpemoji']); 
	});
}
# --------------------------------------------------------------------
# Disable post embeds
# --------------------------------------------------------------------
if(io_get_option('disable_post_embed')){  
	
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

	add_filter( 'embed_oembed_discover', '__return_false' );

	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_filter( 'oembed_response_data',   'get_oembed_response_data_rich',  10, 4 );

	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );

	add_filter( 'tiny_mce_plugins', function ($plugins){
		return array_diff( $plugins, array( 'wpembed' ) );
	});

	add_filter('query_vars', function ($public_query_vars) {
		return array_diff($public_query_vars, array('embed'));
	});
}
# --------------------------------------------------------------------
# Remove category from URLs
# --------------------------------------------------------------------
if( io_get_option('ioc_category') ) {
    add_action( 'load-themes.php',  'no_category_base_refresh_rules');
    add_action('created_category', 'no_category_base_refresh_rules');
    add_action('edited_category', 'no_category_base_refresh_rules');
    add_action('delete_category', 'no_category_base_refresh_rules');
    function no_category_base_refresh_rules() {
        global $wp_rewrite;
        $wp_rewrite -> flush_rules();
    }
    // Remove the category base
    add_action('init', 'no_category_base_permastruct');
    function no_category_base_permastruct() {
        global $wp_rewrite, $wp_version;
        if (version_compare($wp_version, '3.4', '<')) {
            // For pre-3.4 support
            $wp_rewrite->extra_permastructs['category'][0] = '%category%';
        } else {
            $wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
        }
    }
    // Add custom category rewrite rules
    add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    function no_category_base_rewrite_rules($category_rewrite) {
        //var_dump($category_rewrite); // For debugging
        $category_rewrite = array();
        $categories = get_categories(array('hide_empty' => false));
        foreach ($categories as $category) {
            $category_nicename = $category -> slug;
            if ($category -> parent == $category -> cat_ID)// recursive recursion
                $category -> parent = 0;
            elseif ($category -> parent != 0)
                $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
            $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
        }
        // Support redirects from the old category base
        global $wp_rewrite;
        $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
        $old_category_base = trim($old_category_base, '/');
        $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
        //var_dump($category_rewrite); // For debugging
        return $category_rewrite;
    }
    // Add the 'category_redirect' query var
    add_filter('query_vars', 'no_category_base_query_vars');
    function no_category_base_query_vars($public_query_vars) {
        $public_query_vars[] = 'category_redirect';
        return $public_query_vars;
    }
    // Redirect if 'category_redirect' is set
    add_filter('request', 'no_category_base_request');
    function no_category_base_request($query_vars) {
        //print_r($query_vars); // For debugging
        if (isset($query_vars['category_redirect'])) {
            $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
            status_header(301);
            header("Location: $catlink");
            exit();
        }
        return $query_vars;
    }
}
# --------------------------------------------------------------------
# Disable Auto OEmbed
# --------------------------------------------------------------------
if(io_get_option('disable_autoembed')){ 
	remove_filter('the_content',			[$GLOBALS['wp_embed'], 'run_shortcode'], 8);
	remove_filter('widget_text_content',	[$GLOBALS['wp_embed'], 'run_shortcode'], 8);

	remove_filter('the_content',			[$GLOBALS['wp_embed'], 'autoembed'], 8);
	remove_filter('widget_text_content',	[$GLOBALS['wp_embed'], 'autoembed'], 8);

	remove_action('edit_form_advanced',		[$GLOBALS['wp_embed'], 'maybe_run_ajax_cache']);
	remove_action('edit_page_form',			[$GLOBALS['wp_embed'], 'maybe_run_ajax_cache']);
}
# --------------------------------------------------------------------
# Gravatar acceleration
# --------------------------------------------------------------------
add_filter('pre_get_avatar_data', function($args, $id_or_email){
	$email_hash	= '';
	$user		= $email = false;
	
	if(is_object($id_or_email) && isset($id_or_email->comment_ID)){
		$id_or_email	= get_comment($id_or_email);
	}

	if(is_numeric($id_or_email)){
		$user	= get_user_by('id', absint($id_or_email));
	}elseif($id_or_email instanceof WP_User){	// User Object
		$user	= $id_or_email;
	}elseif($id_or_email instanceof WP_Post){	// Post Object
		$user	= get_user_by('id', intval($id_or_email->post_author));
	}elseif($id_or_email instanceof WP_Comment){	// Comment Object
		if(!empty($id_or_email->user_id)){
			$user	= get_user_by('id', intval($id_or_email->user_id));
		}elseif(!empty($id_or_email->comment_author_email)){
			$email	= $id_or_email->comment_author_email;
		}
	}elseif(is_string($id_or_email)){
		if(strpos($id_or_email, '@md5.gravatar.com')){
			list($email_hash)	= explode('@', $id_or_email);
		} else {
			$email	= $id_or_email;
		}
	}

	if($user){
		$args	= apply_filters('io_default_avatar_data', $args, $user->ID);
		if($args['found_avatar']){
			return $args;
		}else{
			$email = $user->user_email;
		}
	}
	
	if(!$email_hash){
		if($email){
			$email_hash = md5(strtolower(trim($email)));
		}
	}

	if($email_hash){
		$args['found_avatar']	= true;
	}

	if(io_get_option('gravatar') == 'v2ex'){
		$url	= 'http://cdn.v2ex.com/gravatar/'.$email_hash;
	}else{
		$url	= 'http://cn.gravatar.com/avatar/'.$email_hash;
	}

	$url_args	= array_filter([
		's'	=> $args['size'],
		'd'	=> $args['default'],
		'f'	=> $args['force_default'] ? 'y' : false,
		'r'	=> $args['rating'],
	]);

	$url			= add_query_arg(rawurlencode_deep($url_args), set_url_scheme($url, $args['scheme']));
	$args['url']	= apply_filters('get_avatar_url', $url, $id_or_email, $args);

	return $args;

}, 10, 2);
# --------------------------------------------------------------------
# Do not load language packs on the frontend
# --------------------------------------------------------------------
//if(io_get_option('locale')){
//	add_filter('locale', function($locale){ 
//		if(is_admin()){
//			return $locale;
//		}
//		
//		global $io_locale;
//
//		if(!isset($io_locale)){
//			$io_locale	= $locale;	
//		}
//
//		if(in_array('get_language_attributes', wp_list_pluck(debug_backtrace(), 'function'))){
//			return $io_locale;
//		}else{
//			return 'en_US';
//		}
//	});
//}
# --------------------------------------------------------------------
# Remove the help button at the top right of the admin UI
# --------------------------------------------------------------------
if(io_get_option('remove_help_tabs')){  
	add_action('in_admin_header', function(){
		global $current_screen;
		$current_screen->remove_help_tabs();
	});
}
# --------------------------------------------------------------------
# Remove the options button at the top right of the admin UI
# --------------------------------------------------------------------
if(io_get_option('remove_screen_options')){  
	add_filter('screen_options_show_screen', '__return_false');
	add_filter('hidden_columns', '__return_empty_array');
}
# --------------------------------------------------------------------
# Block login attempts using the admin username
# --------------------------------------------------------------------
if(io_get_option('no_admin')){
	add_filter( 'wp_authenticate',  function ($user){
		if($user == 'admin') exit;
	});

	add_filter('sanitize_user', function ($username, $raw_username, $strict){
		if($raw_username == 'admin' || $username == 'admin'){
			exit;
		}
		return $username;
	}, 10, 3);
}
# --------------------------------------------------------------------
# Compress site HTML source
# --------------------------------------------------------------------
if(io_get_option('compress_html')){
    add_action('get_header', 'wp_compress_html');
    function wp_compress_html(){
        function wp_compress_html_main ($buffer){
            $initial=strlen($buffer);
            $buffer=explode("<!--wp-compress-html-->", $buffer);
            $count=count ($buffer);
            for ($i = 0; $i <= $count; $i++){
                if (stristr($buffer[$i], '<!--wp-compress-html no compression-->')) {
                    $buffer[$i]=(str_replace("<!--wp-compress-html no compression-->", " ", $buffer[$i]));
                } else {
                    $buffer[$i]=(str_replace("\t", " ", $buffer[$i]));
                    $buffer[$i]=(str_replace("\n\n", "\n", $buffer[$i]));
                    $buffer[$i]=(str_replace("\n", "", $buffer[$i]));
                    $buffer[$i]=(str_replace("\r", "", $buffer[$i]));
                    while (stristr($buffer[$i], '  ')) {
                        $buffer[$i]=(str_replace("  ", " ", $buffer[$i]));
                    }
                }
                $buffer_out.=$buffer[$i];
            }
            $final=strlen($buffer_out);   
            $savings=($initial-$final)/$initial*100;   
            $savings=round($savings, 2);   
            $buffer_out.="\n<!--压缩前的大小: $initial bytes; 压缩后的大小: $final bytes; 节约：$savings% -->";   
        	return $buffer_out;
    	}
    	ob_start("wp_compress_html_main");
    }
}
# --------------------------------------------------------------------
# Disable default widgets
# --------------------------------------------------------------------
add_action( 'widgets_init', 'my_unregister_widgets' );   
function my_unregister_widgets() {   
    unregister_widget( 'WP_Widget_Archives' );   
    unregister_widget( 'WP_Widget_Calendar' );   
    unregister_widget( 'WP_Widget_Categories' );   
    unregister_widget( 'WP_Widget_Links' );   
    unregister_widget( 'WP_Widget_Meta' );   
    unregister_widget( 'WP_Widget_Pages' );   
    unregister_widget( 'WP_Widget_Recent_Comments' );     
    unregister_widget( 'WP_Widget_Recent_Posts' );   
    unregister_widget( 'WP_Widget_RSS' );   
    //unregister_widget( 'WP_Widget_Search' );   
    unregister_widget( 'WP_Widget_Tag_Cloud' );   
    unregister_widget( 'WP_Widget_Text' );   
    unregister_widget( 'WP_Nav_Menu_Widget' ); 
	unregister_widget( 'WP_Widget_Media_Audio' );
	unregister_widget( 'WP_Widget_Media_Image' );
	unregister_widget( 'WP_Widget_Media_Gallery' );
	unregister_widget( 'WP_Widget_Media_Video' );  
	//unregister_widget( 'WP_Widget_Custom_HTML' );
}  
