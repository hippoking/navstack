<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
 
// Sites
add_action( 'init', 'post_type_sites' );
function post_type_sites() {
	$labels = array(
		'name'               => __('网址','io_setting'), 'post type general name', 'your-plugin-textdomain',
		'singular_name'      => __('网址','io_setting'), 'post type singular name', 'your-plugin-textdomain',
		'menu_name'          => __('网址','io_setting'), 'admin menu', 'your-plugin-textdomain',
		'name_admin_bar'     => __('网址','io_setting'), 'add new on admin bar', 'your-plugin-textdomain',
		'add_new'            => __('添加网址','io_setting'), 'sites', 'your-plugin-textdomain',
		'add_new_item'       => __('添加新网址','io_setting'), 'your-plugin-textdomain',
		'new_item'           => __('新网址','io_setting'), 'your-plugin-textdomain',
		'edit_item'          => __('编辑网址','io_setting'), 'your-plugin-textdomain',
		'view_item'          => __('查看网址','io_setting'), 'your-plugin-textdomain',
		'all_items'          => __('所有网址','io_setting'), 'your-plugin-textdomain',
		'search_items'       => __('搜索网址','io_setting'), 'your-plugin-textdomain',
		'parent_item_colon'  => __('Parent 网址:','io_setting'), 'your-plugin-textdomain',
		'not_found'          => __('你还没有发布网址。','io_setting'), 'your-plugin-textdomain',
		'not_found_in_trash' => __('回收站中没有网址。','io_setting'), 'your-plugin-textdomain'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => io_get_option('sites_rewrite')['post'] ),
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-admin-site',
		'has_archive'        => false,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'menu_position'      => 10,
		'supports'           => array( 'title',  'author', 'editor', 'comments', 'custom-fields' )//'editor','excerpt',
	); 
	register_post_type( 'sites', $args );
}
// Site categories
add_action( 'init', 'create_sites_taxonomies', 0 );
function create_sites_taxonomies() {
	$labels = array(
		'name'              => __('网址分类目录','io_setting'), 'taxonomy general name',
		'singular_name'     => __('网址分类','io_setting'), 'taxonomy singular name',
		'search_items'      => __('搜索网址目录','io_setting'),
		'all_items'         => __('所有网址目录','io_setting'),
		'parent_item'       => __('父级分类目录','io_setting'),
		'parent_item_colon' => __('父级分类目录:','io_setting'),
		'edit_item'         => __('编辑网址目录','io_setting'),
		'update_item'       => __('更新网址目录','io_setting'),
		'add_new_item'      => __('添加新网址目录','io_setting'),
		'new_item_name'     => 'New Genre Name',
		'menu_name'         => __('网址分类','io_setting'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => io_get_option('sites_rewrite')['taxonomy'] ),
	);

	register_taxonomy( 'favorites', array( 'sites' ), $args );
}
// Site tags
add_action( 'init', 'create_sites_tag_taxonomies', 0 );
function create_sites_tag_taxonomies() {
	$labels = array(
		'name'              => __('网址标签','io_setting'), 'taxonomy general name',
		'singular_name'     => __('网址标签','io_setting'), 'taxonomy singular name',
		'search_items'      => __('搜索网址标签','io_setting'),
		'all_items'         => __('所有网址标签','io_setting'),
		'parent_item'       => __('父级分类目录','io_setting'),
		'parent_item_colon' => __('父级分类目录:','io_setting'),
		'edit_item'         => __('编辑网址标签','io_setting'),
		'update_item'       => __('更新网址标签','io_setting'),
		'add_new_item'      => __('添加新网址标签','io_setting'),
		'new_item_name'     => 'New Genre Name',
		'menu_name'         => __('网址标签','io_setting'),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => io_get_option('sites_rewrite')['tag'] ),
	);

	register_taxonomy( 'sitetag', array( 'sites' ), $args );
}
 


// app
add_action( 'init', 'post_type_apps' );
function post_type_apps() {
	$labels = array(
		'name'               => 'APP', 'post type general name', 'your-plugin-textdomain',
		'singular_name'      => 'APP', 'post type singular name', 'your-plugin-textdomain',
		'menu_name'          => 'APP', 'admin menu', 'your-plugin-textdomain',
		'name_admin_bar'     => 'APP', 'add new on admin bar', 'your-plugin-textdomain',
		'add_new'            => __('添加APP','io_setting'), 'app', 'your-plugin-textdomain',
		'add_new_item'       => __('添加新APP','io_setting'), 'your-plugin-textdomain',
		'new_item'           => __('新APP','io_setting'), 'your-plugin-textdomain',
		'edit_item'          => __('编辑APP','io_setting'), 'your-plugin-textdomain',
		'view_item'          => __('查看APP','io_setting'), 'your-plugin-textdomain',
		'all_items'          => __('所有APP','io_setting'), 'your-plugin-textdomain',
		'search_items'       => __('搜索APP','io_setting'), 'your-plugin-textdomain',
		'parent_item_colon'  => 'Parent APP:', 'your-plugin-textdomain',
		'not_found'          => __('你还没有发布APP。','io_setting'), 'your-plugin-textdomain',
		'not_found_in_trash' => __('回收站中没有APP。','io_setting'), 'your-plugin-textdomain'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => io_get_option('app_rewrite')['post'] ),
		'capability_type'    => 'post',
		'menu_icon'          => 'dashicons-archive',
		'has_archive'        => false,
		'hierarchical'       => false,
		'show_in_rest'       => true,
		'menu_position'      => 10,
		'supports'           => array( 'title',  'author', 'editor', 'comments', 'custom-fields' )//'editor','excerpt',
	);

	register_post_type( 'app', $args );
}
// App categories
add_action( 'init', 'create_apps_taxonomies', 0 );
function create_apps_taxonomies() {
	$labels = array(
		'name'              => __('APP分类目录','io_setting'), 'taxonomy general name',
		'singular_name'     => __('APP分类','io_setting'), 'taxonomy singular name',
		'search_items'      => __('搜索APP目录','io_setting'),
		'all_items'         => __('所有APP目录','io_setting'),
		'parent_item'       => __('父级分类目录','io_setting'),
		'parent_item_colon' => __('父级分类目录:','io_setting'),
		'edit_item'         => __('编辑APP目录','io_setting'),
		'update_item'       => __('更新APP目录','io_setting'),
		'add_new_item'      => __('添加新APP目录','io_setting'),
		'new_item_name'     => 'New Genre Name',
		'menu_name'         => __('APP分类','io_setting'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' =>  io_get_option('app_rewrite')['taxonomy'] ),
	);

	register_taxonomy( 'apps', array( 'app' ), $args );
}
// App tags
add_action( 'init', 'create_apps_tag_taxonomies', 0 );
function create_apps_tag_taxonomies() {
	$labels = array(
		'name'              => __('APP标签','io_setting'), 'taxonomy general name',
		'singular_name'     => __('APP标签','io_setting'), 'taxonomy singular name',
		'search_items'      => __('搜索APP标签','io_setting'),
		'all_items'         => __('所有APP标签','io_setting'),
		'parent_item'       => __('父级分类目录','io_setting'),
		'parent_item_colon' => __('父级分类目录:','io_setting'),
		'edit_item'         => __('编辑APP标签','io_setting'),
		'update_item'       => __('更新APP标签','io_setting'),
		'add_new_item'      => __('添加新APP标签','io_setting'),
		'new_item_name'     => 'New Genre Name',
		'menu_name'         => __('APP标签','io_setting'),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' =>  io_get_option('app_rewrite')['tag'] ),
	);

	register_taxonomy( 'apptag', array( 'app' ), $args );
}


if (io_get_option('show_bulletin')) {
	// Bulletin
	add_action( 'init', 'post_type_bulletin' );
	function post_type_bulletin() {
		$labels = array(
			'name'               => __('公告','io_setting'), 'post type general name', 'your-plugin-textdomain',
			'singular_name'      => __('公告','io_setting'), 'post type singular name', 'your-plugin-textdomain',
			'menu_name'          => __('公告','io_setting'), 'admin menu', 'your-plugin-textdomain',
			'name_admin_bar'     => __('公告','io_setting'), 'add new on admin bar', 'your-plugin-textdomain',
			'add_new'            => __('发布公告','io_setting'), 'bulletin', 'your-plugin-textdomain',
			'add_new_item'       => __('发布新公告','io_setting'), 'your-plugin-textdomain',
			'new_item'           => __('新公告','io_setting'), 'your-plugin-textdomain',
			'edit_item'          => __('编辑公告','io_setting'), 'your-plugin-textdomain',
			'view_item'          => __('查看公告','io_setting'), 'your-plugin-textdomain',
			'all_items'          => __('所有公告','io_setting'), 'your-plugin-textdomain',
			'search_items'       => __('搜索公告','io_setting'), 'your-plugin-textdomain',
			'parent_item_colon'  => __('Parent 公告:','io_setting'), 'your-plugin-textdomain',
			'not_found'          => __('你还没有发布公告。','io_setting'), 'your-plugin-textdomain',
			'not_found_in_trash' => __('回收站中没有公告。','io_setting'), 'your-plugin-textdomain'
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'bulletin' ),
			'capability_type'    => 'post',
			'menu_icon'          => 'dashicons-controls-volumeon',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 10,
			'show_in_rest'       => true,
			'supports'           => array( 'title', 'editor', 'author', 'comments', 'custom-fields' )
		);
	
		register_post_type( 'bulletin', $args );
	}
}
/**
 * Save sort order
 *
 * @param int $term_id
 */
//add_action( 'edited_favorites', 'save_term_order' );
//add_action('created_favorites','save_term_order',10,1);
add_action('edit_favorites','save_term_order',10,1);
function save_term_order( $term_id ) {
	//if (isset($_POST['_term_order'])) {
   	//	update_term_meta( $term_id, '_term_order', $_POST[ '_term_order' ] );
	//}
	$ca_menu_id = esc_attr($_POST['ca_ordinal']);
	if ($ca_menu_id)
		update_term_meta( $term_id, '_term_order', $ca_menu_id);
 
}

/**
 * Set the custom post type permalink structure to ID.html 
 * https://www.wpdaxue.com/custom-post-type-permalink-code.html
 */
$iotypes = array(
	'sites'    => io_get_option('sites_rewrite')['post'],
	'app'      => io_get_option('app_rewrite')['post'],
	'bulletin' => 'bulletin',
);
if (!io_get_option('rewrites_types') || (io_get_option('rewrites_types') == 'post_id')) {
	add_filter('post_type_link', 'io_custom_post_type_link_id', 1, 3);
	add_action( 'init', 'io_custom_post_type_rewrites_init_id' );
}
if (io_get_option('rewrites_types') == 'postname' && io_get_option('rewrites_end')) {
	add_filter('post_type_link', 'io_custom_post_type_link_name', 1, 3);
	add_action( 'init', 'io_custom_post_type_rewrites_init_name' );
}
// ID
function io_custom_post_type_link_id( $link, $post = 0 ){
	global $iotypes;
	if ( in_array( $post->post_type,array_keys($iotypes) ) ){
		return home_url( $iotypes[$post->post_type].'/' . $post->ID . '.html' );
	} else {
		return $link;
	}
}
function io_custom_post_type_rewrites_init_id(){
	global $iotypes;
	foreach( $iotypes as $k => $v ) {
		add_rewrite_rule(
			$v.'/([0-9]+)?.html$',
			'index.php?post_type='.$k.'&p=$matches[1]',
			'top'
		);
		add_rewrite_rule(
			$v.'/([0-9]+)?.html/comment-page-([0-9]{1,})$',
			'index.php?post_type='.$k.'&p=$matches[1]&cpage=$matches[2]',
			'top'
		);
	}
}
// post_name
function io_custom_post_type_link_name( $link, $post = 0 ){
	global $iotypes;
	if ( in_array( $post->post_type,array_keys($iotypes) ) ){
		return home_url( $iotypes[$post->post_type].'/' . $post->post_name . (io_get_option('rewrites_end')?'.html':'') );
	} else {
		return $link;
	}
}
function io_custom_post_type_rewrites_init_name(){
	global $iotypes;
	foreach( $iotypes as $k => $v ) {
		add_rewrite_rule(
			$v.'/([一-龥a-zA-Z0-9_-]+)?.html([sS]*)?$',
			'index.php?post_type='.$k.'&name=$matches[1]',
			'top'
		);
		add_rewrite_rule(
			
			$v.'/([一-龥a-zA-Z0-9_-]+)?.html/comment-page-([一-龥a-zA-Z0-9_-]{1,})$',
			'index.php?post_type='.$k.'&name=$matches[1]&cpage=$matches[2]',
			'top'
		);
	}
}

// This section generates the category dropdown menu
add_action('restrict_manage_posts','io_post_type_filter',10,2);
function io_post_type_filter($post_type, $which){
    if('sites' !== $post_type){ // This is the custom post type and may need to be changed
      return; // Check whether this is the post type we need
    }
    $taxonomy_slug     = 'favorites'; // This is the custom taxonomy and may need to be changed
    $taxonomy          = get_taxonomy($taxonomy_slug);
    $selected          = '';
    $request_attr      = 'favorites'; // This is the custom taxonomy and may need to be changed
    if ( isset($_REQUEST[$request_attr] ) ) {
      $selected = $_REQUEST[$request_attr];
    }
    wp_dropdown_categories(array(
      'show_option_all' =>  __("所有","io_setting").$taxonomy->label,
      'taxonomy'        =>  $taxonomy_slug,
      'name'            =>  $request_attr,
      'orderby'         =>  'name',
      'selected'        =>  $selected,
      'hierarchical'    =>  true,
      'depth'           =>  5,
      'show_count'      =>  true, // Show number of post in parent term
      'hide_empty'      =>  false, // Don't show posts w/o terms
    ));
}
// This section lists all posts under the specified category
add_filter('parse_query','io_work_convert_restrict'); 
function io_work_convert_restrict($query) {  
    global $pagenow;  
    global $typenow;  
    if ($pagenow=='edit.php') {  
        $filters = get_object_taxonomies($typenow);  
        foreach ($filters as $tax_slug) {  
            $var = &$query->query_vars[$tax_slug];  
            if ( isset($var) && $var>0) {  
                $term = get_term_by('id',$var,$tax_slug);  
                $var = $term->slug;  
            }  
        }  
    }  
    return $query;  
} 

/**
 * Add custom fields to the post list
 * https://www.iowen.cn/wordpress-quick-edit
 */
add_filter('manage_edit-sites_columns', 'io_ordinal_manage_posts_columns');
add_action('manage_posts_custom_column','io_ordinal_manage_posts_custom_column',10,2);
function io_ordinal_manage_posts_columns($columns){
	$columns['ordinal']    = __('排序','io_setting'); 
	$columns['visible']    = __('可见性','io_setting'); 
	return $columns;
}
function io_ordinal_manage_posts_custom_column($column_name,$id){ 
	switch( $column_name ) :
		case 'ordinal': {
			echo get_post_meta($id, '_sites_order', true);
			break;
		}
		case 'visible': {
			echo get_post_meta($id, '_visible', true)? __("管理员",'io_setting') : __("所有人",'io_setting');
			break;
		}
	endswitch;
}

// Add custom fields to the category list
add_filter('manage_edit-favorites_columns', 'io_id_manage_tags_columns');
add_action('manage_favorites_custom_column','io_id_manage_tags_custom_column',10,3);
function io_id_manage_tags_columns($columns){
	$columns['ca_ordinal']    = __('菜单排序','io_setting'); 
	$columns['id']    = 'ID'; 
    return $columns;
}
function io_id_manage_tags_custom_column($null,$column_name,$id){
    if ($column_name == 'ca_ordinal') {
        echo get_term_meta($id, '_term_order', true);
    }
    if ($column_name == 'id') {
        echo $id;
    }
}

/**
 * Add custom fields to the post list
 * 
 */
add_action( 'admin_head', 'io_custom_css' );
function io_custom_css(){
	echo '<style>
		#ordinal{
			width:80px;
		} 
	</style>';
}

// Add sorting rules to the post list
add_filter('manage_edit-sites_sortable_columns', 'sort_sites_order_column');
//add_filter('manage_edit-favorites_sortable_columns', 'sort_favorites_order_column');
add_action('pre_get_posts', 'sort_sites_order');
function sort_sites_order_column($defaults)
{
    $defaults['ordinal'] = 'ordinal';
    return $defaults;
}
function sort_favorites_order_column($defaults)
{
    $defaults['ca_ordinal'] = 'ca_ordinal';
    return $defaults;
}
function sort_sites_order($query) {
    if(!is_admin())
		return;
    $orderby = $query->get('orderby');
    if('ordinal' == $orderby) {
        $query->set('meta_key', '_sites_order');
        $query->set('orderby', 'meta_value_num');
    }
    if('ca_ordinal' == $orderby) {
        $query->set('meta_key', '_term_order');
        $query->set('orderby', 'meta_value_num');
    }
}


add_action('quick_edit_custom_box',  'io_add_quick_edit', 10, 2);
function io_add_quick_edit($column_name, $post_type) {
	if ($column_name == 'ordinal') {
		// Note: the <fieldset> class can be:
		// inline-edit-col-left, inline-edit-col-center, inline-edit-col-right
		// All columns use float: left,
		// so if you want the left column, use an element with clear: both
		echo '
		<fieldset class="inline-edit-col-left" style="clear: both;">
			<div class="inline-edit-col"> 
				<label class="alignleft">
					<span class="title">'.__('排序','io_setting').'</span>
					<span class="input-text-wrap"><input type="number" name="ordinal" class="ptitle" value=""></span>
				</label> 
				<em class="alignleft inline-edit-or"> '.__('越大越靠前','io_setting').'</em>
			</div>
		</fieldset>';
	}
	if ($column_name == 'ca_ordinal') {  
	  	echo '
	  	<fieldset>
		  	<div class="inline-edit-col"> 
			  	<label class="alignleft">
				  	<span class="title">'.__('排序','io_setting').'</span>
				  	<span class="input-text-wrap"><input type="number" name="ca_ordinal" class="ptitle" value=""></span>
			  	</label> 
			  	<em class="alignleft inline-edit-or"> '.__('越大越靠前','io_setting').'</em>
		  	</div>
	  	</fieldset>';
	}
}


// Save and update quick edit data
add_action('save_post', 'io_save_quick_edit_data');
function io_save_quick_edit_data($post_id) {
    // If this is an autosave, not submitted by us, do nothing
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
    // Verify permissions. 'sites' is the post type; the default is 'post'. Here it is our custom post type 'sites'
    if ( 'sites' == isset($_POST['post_type'] )) {
        if ( !current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } else {
        if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;
	}  
	$post = get_post($post_id); 
	// 'ordinal' corresponds to the code above
    if (isset($_POST['ordinal']) && ($post->post_type != 'revision')) {
        $left_menu_id = esc_attr($_POST['ordinal']);
        if ($left_menu_id)
			update_post_meta( $post_id, '_sites_order', $left_menu_id);// '_sites_order' is a custom field
    } 
}

// Output JS
add_action('admin_footer', 'io_quick_edit_javascript');
function io_quick_edit_javascript() {
	$current_screen = get_current_screen(); 
    if (is_object($current_screen) || ($current_screen->post_type == 'sites')){
		if($current_screen->id == 'edit-sites'){
 		echo"
    	<script type='text/javascript'>
    	jQuery(function($){
			var wp_inline_edit_function = inlineEditPost.edit;
			inlineEditPost.edit = function( post_id ) {
				wp_inline_edit_function.apply( this, arguments );
				var id = 0;
				if ( typeof( post_id ) == 'object' ) {
					id = parseInt( this.getId( post_id ) );
				}
				if ( id > 0 ) {
					var specific_post_edit_row = $( '#edit-' + id ),
							specific_post_row = $( '#post-' + id ),
							product_price = $( '.column-ordinal', specific_post_row ).text(); 
					$('input[name=\"ordinal\"]', specific_post_edit_row ).val( product_price ); 
				}
			}
		});
    	</script>";
		} 
		if($current_screen->id == 'edit-favorites'){
 		echo"
    	<script type='text/javascript'>
    	jQuery(function($){
			var wp_inline_edit_function = inlineEditTax.edit;
			inlineEditTax.edit = function( post_id ) {
				wp_inline_edit_function.apply( this, arguments );
				var id = 0;
				if ( typeof( post_id ) == 'object' ) {
					id = parseInt( this.getId( post_id ) );
				}
			console.log('调试区'+id);
				if ( id > 0 ) {
					var specific_post_edit_row = $( '#edit-' + id ),
							specific_post_row = $( '#tag-' + id ),
							product_price = $( '.column-ca_ordinal', specific_post_row ).text(); 

					$('input[name=\"ca_ordinal\"]', specific_post_edit_row ).val( product_price ); 
				}
			}
		});
    	</script>";
		} 
		if($current_screen->id == 'sites'){
?>
		<script type="text/javascript">
		(function($){
			$(document).ready(function(){ 
				$('.sites_link').each(function () {
					$html = $('<a href="javascript:;" id="check-duplicate" style="display:none"><?php _e('查重','io_setting') ?></a> <a href="javascript:;" id="refre-url" style="display:none;margin-left:10px"><?php _e('获取元数据（名称、描叙、关键字、国家）','io_setting') ?></a> <span class="refre_msg" style="display:none;margin-left:10px"></span><br>');
					$(this).children('.csf-fieldset').prepend($html).append('<span class="show_sites_info" style="display:none;margin-left:10px"></span>'); 
				});
			
				$(".sites_link input[name*='_sites_link']").on("change",function(){
					$("#check-duplicate").show();
					$("#refre-url").show();
				});
				$(".sites_link #refre-url").on("click",function(){ 
					check($(".sites_link input[name*='_sites_link']").val()); 
				});
				$(".sites_link #check-duplicate").on("click",function () { 
					$.ajax({
						url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',
						type : 'POST',  
						data : {
							action: "check_duplicate",
							sites_link: $(".sites_link input[name*='_sites_link']").val()
						},
						success : function( data ){
            		        $(".refre_msg").html(data).show(200).delay(4000).hide(200);
						},
            		    error:function(){ 
							$(".refre_msg").html("网络错误 --.").show(200).delay(4000).hide(200);
            		    }
					});
				});
				function check(_url){
						$.post("//api.iotheme.cn/webinfo/get.php", { url: _url ,key:"<?php echo io_get_option('iowen_key') ?>" },function(data,status){ 
    			            if(data.code==0){ 
								$(".refre_msg").html('获取失败，请再试试，或者手动填写').show(200).delay(4000).hide(200);
    			            }
    			            else{ 
								dataInput(data);
								if(data.friend_link_status == 404)
    			                	$(".refre_msg").html(data.site_title).show(200).delay(4000).hide(200);
								else
    			                	$(".refre_msg").html('获取成功，没有的请手动填写').show(200).delay(4000).hide(200);
    			            } 
    			        }).fail(function () {
    			            $(".refre_msg").html('链接超时，请再试试，或者手动填写').show(200).delay(4000).hide(200);
    			        });
				} 
				function dataInput(data) {
					if($('#post-title-0')[0]){
						var info = '古腾堡编辑器请手动复制下面内容到相应位置<br><br>标题：'+data.site_title+'<br>标签：'+data.site_keywords;
						$('.sites_sescribe input[name*="_sites_sescribe"]').val(data.site_description); 
						$('.show_sites_info').html(info).show(200);
					}else{
						$('input[name="post_title"]').val(data.site_title); 
						$('.sites_sescribe input[name*="_sites_sescribe"]').val(data.site_description); 
						if($('#new-tag-sitetag')[0]){
							$('#new-tag-sitetag').val(data.site_keywords);
						}else{
							$(".refre_msg").html('没有打开标签模块，无法写入标签').show(200).delay(4000).hide(200);
						}
						if(data.address && data.address.status == 'success'){
							$('.sites_country input[name*="_sites_country"]').val(data.address.country);
						}
					}
				}
			});
		})(jQuery);
    	</script>
<?php
		}
	}
	
    if (is_object($current_screen) || ($current_screen->post_type == 'app')){
		if($current_screen->id == 'app'){
?>
		   	<script type="text/javascript">
		   	(function($){  
			$(document).ready(function(){  
				$('.csf-field-content[data-controller="ico_a"]').each(function () {
					var color1=$("input[name*='color-1']").val();
					var color2=$("input[name*='color-2']").val();
					var size=$("input[name*='ico_size']").val();
					var ico=$("input[name*='_app_ico']").val();
					var html = '<div id="customize-ico" style="position:relative;display:inline-block;width:100px;height:100px;border-radius:1.875rem;background-image:linear-gradient(130deg, '+color1+', '+color2+');">';
					html +='<div class="media-content" style="background-image:url('+ico+');position:absolute;top:0;bottom:0;left:0;right:0;border:0;border-radius:inherit;background-size:'+size+'%;background-repeat:no-repeat;background-position:50% 50%;"></div>';
					html +='</div>';
					html +='<a href="javascript:;" id="refre-ico" style="display:none;margin-left:20px"><?php _e('刷新图标','io_setting') ?></a>';
					$(this).append(html);
				});
				$("input[name*='color-1'][data-depend-id]").on("change input propertychange",function(){
					$("#customize-ico").css({
						background:"linear-gradient(130deg, "+$(this).val()+", "+$("input[name*='color-2']").val()+")"
					});
				});
				$("input[name*='color-2'][data-depend-id]").on("change input propertychange",function(){
					$("#customize-ico").css({
						background:"linear-gradient(130deg, "+$("input[name*='color-1']").val()+", "+$(this).val()+")"
					});
				});
				$("input[name*='ico_size'][data-depend-id]").on("change input propertychange",function(){
					$("#customize-ico .media-content").css({
						"background-size":$(this).val()+"%"
					});
				});
				$("input[name*='_app_ico'][data-depend-id='_app_ico']").on("input propertychange",function(){
					$("#customize-ico .media-content").css({
						'background-image':"url("+$(this).val()+")"
					});
				});
				$("input[name*='_app_ico'][data-depend-id='_app_ico']+a").on("click",function(){ 
					$("#refre-ico").show();
				})
				$("#refre-ico").on("click",function(){ 
					$("#customize-ico .media-content").css({
						'background-image':"url("+$("input[name*='_app_ico']").val()+")"
					});
					$("#refre-ico").hide();
				})
			});
			})(jQuery);
		   </script> 
<?php 	} 
	}
}

