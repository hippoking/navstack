<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>


<?php 
include( 'templates/sidebar-nav.php' );
?>
<div class="main-content flex-fill page">
<?php include( 'templates/header-banner.php' ); ?>
    <div id="content" class="container my-4 my-md-5">
            <div class="panel card">
		    <div class="card-body">
                <h1 class="h4 mb-4"><?php echo get_the_title() ?></h1>
                <div class="panel-body mt-2">
                    <?php while( have_posts() ): the_post(); ?>
	    		    <?php the_content();?>
                        <?php edit_post_link(__('编辑','i_theme'), '<span class="edit-link">', '</span>' ); ?>
	    	        <?php endwhile; ?>
                </div>
            </div>
            </div>
            <?php 
            if ( comments_open() || get_comments_number() ) :
	    		comments_template();
            endif; 
            ?>
	</div>
<?php get_footer(); ?>