<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); 
include( 'templates/sidebar-nav.php' );
?>
	<div class="main-content flex-fill">
    
	<?php include( 'templates/header-banner.php' ); ?> 
	<div id="content" class="container customize-site mb-4 mb-md-5">
		<?php get_template_part( 'templates/tools','searchmini' ) ?>
		<div class="row">
    	    <div class="col-lg-8">
				<div class="mb-4"> 
					<a class="btn btn-search mr-2 <?php echo $post_type=='sites'?'current':'' ?>" href="<?php echo home_url() ?>?s=<?php echo $s ?>&post_type=sites"><?php _e( '网址', 'i_theme' ); ?></a>
					<a class="btn btn-search mr-2 <?php echo $post_type=='post'?'current':'' ?>" href="<?php echo home_url() ?>?s=<?php echo $s ?>&post_type=post"><?php _e( '文章', 'i_theme' ); ?></a>
					<a class="btn btn-search mr-2 <?php echo $post_type=='app'?'current':'' ?>" href="<?php echo home_url() ?>?s=<?php echo $s ?>&post_type=app"><?php _e( '软件', 'i_theme' ); ?></a>
				</div>
				<h4 class="text-gray text-lg mb-4"><i class="iconfont icon-search mr-1"></i><?php echo sprintf( __('“%s”的搜索结果', 'i_theme'), $s ) ?></h4>
				<?php 
				if(isset($_GET['post_type'] )){
					$post_type=$_GET['post_type']; 
					if (locate_template('templates/search-' . $post_type . '.php') != '') {
						get_template_part( 'templates/search', $post_type );
					}
					else{
						get_template_part( 'templates/search', 'sites' );
					}
				}
				else{
					get_template_part( 'templates/search', 'sites' );
				}
				?>
				<div class="posts-nav mb-4">
				    <?php echo paginate_links(array(
				        'prev_next'          => 0,
				        'before_page_number' => '',
				        'mid_size'           => 2,
				    ));?>
				</div>
			</div> 
			<div class="sidebar col-lg-4 pl-xl-4 d-none d-lg-block">
				<?php get_sidebar(); ?>
			</div> 
    	</div>
	</div> 
<?php
get_footer(); 
