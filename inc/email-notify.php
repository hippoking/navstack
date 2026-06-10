<?php
/* -------------------------------------
 * By... most of this content was collected online; iowen only consolidated it
 * Article URL: https://www.iowen.cn/wordpress-pinglunshenhepinglunhuifutongzhizhanghubiangengtongzhiwenzhangxiugaixinwenzhangyoujiantongai
 * Settings:
 * 1. The template provides two header styles; set the email header style below
 * 2. There is an ad slot at the bottom of the email; you can configure or remove it
 *-----------------------------------*/
 

/*-------------------------------------
 * Header style: true means centered, false means standard
 * Preview: https://www.iowen.cn/demo/email-notify.html
 * On the demo page, the first example is centered and the others use the standard style
 * Issue: in QQ Mail on mobile, the top-right menu button is not hidden in the standard style, which causes some layout issues
 *        The @media only screen and (max-width: 500px) rule does not take effect there
 *        It behaves normally in browsers.
 *-----------------------------------*/
$style_center = false;


// Define the top section content of the email; make sure to update your theme directory
$email_headertop_center = '
    <div class="emailpaged" style="background-color: #f2f5f8;">
        <div class="emailcontent" style="width:96%;max-width:720px;text-align: left;margin: 0 auto;padding-top: 20px;padding-bottom: 20px">
            <div class="emailtitle">
                <div style="position: relative;margin:0;">
                    <div style="text-align: center;margin-bottom: -20px;"> <img src="'.io_get_option('logo_normal_light')['url'].'"  title="' . get_option("blogname") . '" style="display:inline;margin-bottom:20px;max-height:40px;width:auto" border="0"> </div>
                    
                    <div style="line-height:40px;font-size:12px;text-align: center;">
                        <a href="' . get_bloginfo('url') . '" title="' . get_option("blogname") . '" style="color:#222222;text-decoration:none;padding:0 6px;">首页</a>
                        <a href="' . get_permalink(io_get_option('blog_pages')) . '" title="最新文章" style="color:#222222;text-decoration:none;padding:0 6px;">最新文章</a>
                        <a href="' . get_bloginfo('url') . '" title="最新收录" style="color:#222222;text-decoration:none;padding:0 6px;">最新收录</a>
                    </div>
                    <div class="clear" style="clear: both;display: block;"></div>
                </div>
                <div style="margin: 0;color: #2f2f2f; background: #fff;font-size: 20px;padding: 20px 0;text-align: center;border-bottom: 1px solid #eeeeee;">
';
$email_headertop = '
    <div class="emailpaged" style="background-color: #f2f5f8;">
        <div class="emailcontent" style="width:96%;max-width:720px;text-align: left;margin: 0 auto;padding-top: 80px;padding-bottom: 20px">
            <div class="emailtitle">
                <div style="background: #fff;position: relative;margin:0;border-bottom: 1px solid #eeeeee;">
                    <div style="float: left;"><div style="height:60px;padding: 15px 0 0 20px;"><img src="'.io_get_option('logo_small_light')['url'].'"  title="' . get_option("blogname") . '" style="display:inline;margin:0;max-height:45px;width: auto;" border="0"></div></div>     
                    <div class="imenu" style="float:right;position:absolute;right:0;"><div style="height:60px;line-height:60px;padding: 10px 20px 0 0;font-size:12px;">
                        <a href="' . get_bloginfo('url') . '" title="' . get_option("blogname") . '" style="color:#222222;text-decoration:none;padding:0 6px;">首页</a>
                        <a href="' . get_permalink(io_get_option('blog_pages')) . '" title="最新文章" style="color:#222222;text-decoration:none;padding:0 6px;">最新文章</a> 
                        <a href="' . get_bloginfo('url') . '" title="最新收录" style="color:#222222;text-decoration:none;padding:0 6px;">最新收录</a>
                    </div></div>
                    <div class="clear" style="clear: both;display: block;"></div>
                </div>
                <div class="ititle" style="color: #2f2f2f;font-size: 17px;padding-left: 30px;padding-top: 30px;background: #fff;">
';

/*---------------
**----Title spacer----
**-------------*/

$email_headerbot_center = '
                </div>
                <div class="emailtext" style="background:#fff;padding:20px 32px 40px;">
';
$email_headerbot = '
                    </div>
                <div class="emailtext" style="background:#fff;padding:20px 32px 40px;">
';
if($style_center){
    define ('EMAIL_HEADER_TOP',  $email_headertop_center );
    define ('EMAIL_HEADER_BOT', $email_headerbot_center );
}
else{
    define ('EMAIL_HEADER_TOP',  $email_headertop );
    define ('EMAIL_HEADER_BOT', $email_headerbot );
}
 
// Define the footer section content of the email. ---[Please update the ad image URL below. If you do not need it, delete the 4 lines containing <div class="emailad" ......</div>]---
$email_footer = '
				</div>
                <div class="copyright" style="font-size:13px;line-height: 1.5;color: #777777;padding: 5px 0;text-align:center;">
                    <p style="margin:10px 0 0;">(此为系统自动发送邮件, 请勿回复！)</p>
                    <p style="margin:10px 0 0;">© '. date("Y") . ' · 邮件来自 · <a href="' . get_bloginfo('url') . '" style="color:#51a0e3;text-decoration:none">' . get_option("blogname") . '</a></p>
                </div>
            </div>
        </div>
    </div>
';
define ('emailfooter', $email_footer );
 
// Change the site's default sender name and email
function new_from_name($email){
    $wp_from_name = get_option('blogname');
    return $wp_from_name;
}
function new_from_email($email) {
    $wp_from_email = get_option('admin_email');
    return $wp_from_email;
}
add_filter('wp_mail_from_name', 'new_from_name');
add_filter('wp_mail_from', 'new_from_email');

// Notify the commenter when a comment is approved
add_action('comment_unapproved_to_approved', 'iwill_comment_approved');
function iwill_comment_approved($comment) {
  if(is_email($comment->comment_author_email)) {
    $post_link = get_permalink($comment->comment_post_ID);
    // Email subject, can be changed as needed
    $title = '您在 [' . get_option('blogname') . '] 的评论已通过审核';
    // Email content, change as needed. If you are unsure, leave it as is
    $body = EMAIL_HEADER_TOP.'留言审核通过通知'.EMAIL_HEADER_BOT.'
        <p style="color: #6e6e6e;font-size:13px;line-height:24px;">您在' . get_option('blogname') . '《<a href="'.$post_link.'">'.get_the_title($comment->comment_post_ID).'</a>》发表的评论：</p>
        <p style="color: #6e6e6e;font-size:13px;line-height:24px;padding: 15px 20px;background:#f8f8f8;margin:0px;border: 1px solid #eee;">'.$comment->comment_content.'</p>
        <p style="color: #6e6e6e;font-size:13px;line-height:24px;">已通过管理员审核并显示。<br />
        您可在此查看您的评论：<a href="'.get_comment_link( $comment->comment_ID ).'">前往查看</a></p>'.emailfooter;
    @wp_mail($comment->comment_author_email, $title, $body, "Content-Type: text/html; charset=UTF-8");        
  }
}

/* Styled email notifications for comment replies */
function comment_mail_notify($comment_id) {
    $admin_email = get_bloginfo ('admin_email'); 
    $admin_notify = '1'; // Whether admin should receive reply notifications ('1' = yes; '0' = no)
    $comment = get_comment($comment_id);
    $comment_author_email = trim($comment->comment_author_email);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $comment_author_email)) {
        $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $subject = '您在 [' . get_option("blogname") . '] 的留言有了新回复';
        $message = EMAIL_HEADER_TOP.'您在' . get_option("blogname") . '上的留言有回复啦！'.EMAIL_HEADER_BOT.'
            <p style="color: #6e6e6e;font-size:13px;line-height:24px;">' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
            <p style="color: #6e6e6e;font-size:13px;line-height:24px;">您于 '. trim(get_comment($parent_id)->comment_date) . ' 在文章《' . get_the_title($comment->comment_post_ID) . '》上发表评论:<br />
            <p style="color: #6e6e6e;font-size:13px;line-height:24px;padding: 15px 20px;background:#f8f8f8;margin:0px;border: 1px solid #eee;">'. trim(get_comment($parent_id)->comment_content) . '</p>
            <p style="color: #6e6e6e;font-size:13px;line-height:24px;">' . trim($comment->comment_author) . ' 于' . trim($comment->comment_date) . ' 给您的回复如下:<br />
            <p style="color: #6e6e6e;font-size:13px;line-height:24px;padding: 15px 20px;background:#f8f8f8;margin:0px;border: 1px solid #eee;">'. trim($comment->comment_content) . '</p>
            <p style="color: #6e6e6e;font-size:13px;line-height:24px;">你可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '">查看完整内容</a></p>
            <p style="color: #6e6e6e;font-size:13px;line-height:24px;">欢迎再度光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
            '.emailfooter;
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail( $to, $subject, $message, $headers );
    }
    // Notify the admin about new top-level comments
    if($parent_id == '' &&  $comment_author_email != $admin_email && $admin_notify == '1'){
        $wp_email = '';
        $subject = ' [' . get_option("blogname") . '] 上的文章有了新的评论';
        $message = EMAIL_HEADER_TOP. get_option("blogname") . '上有新的评论'.EMAIL_HEADER_BOT.'
            <p style="color: #6e6e6e;font-size:13px;line-height:24px;">' . trim($comment->comment_author) . ' 在文章《<a href="' . htmlspecialchars(get_comment_link($comment_id)) . '" target="_blank">' . get_the_title($comment->comment_post_ID) . '</a>》中发表了回复，快去看看吧：<br></p>
            <p style="color: #6e6e6e;font-size:13px;line-height:24px;padding: 15px 20px;background:#f8f8f8;margin:0px;border: 1px solid #eee;">'. trim($comment->comment_content) . '</p>
            '.emailfooter;
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail( $admin_email, $subject, $message, $headers );
    }
  }
  add_action('comment_post', 'comment_mail_notify');

// Send an email to the admin when a backend login attempt fails
function wp_login_failed_notify(){
    date_default_timezone_set('PRC');
    $admin_email = get_bloginfo('admin_email');
    $to = $admin_email;
    $subject = '【登录失败】有人使用了错误的用户名或密码登录' . get_bloginfo('name') . '！';
    $message =  EMAIL_HEADER_TOP . get_bloginfo('name') . '账户登录失败通知！'.EMAIL_HEADER_BOT.'
            <div style="padding:0;font-weight:bold;color:#6e6e6e;font-size:16px">尊敬的管理员您好！</div>
            <p style="color: red;font-size:13px;line-height:24px;">' . get_bloginfo('name') . '有一条登录失败的记录产生，若登录操作不是您产生的，请及时注意网站安全！</p>
            <table cellpadding="0" cellspacing="0" border="0" style="width:100%;border-top:1px solid #eee;border-left:1px solid #eee;color:#6e6e6e;font-size:16px;font-weight:normal">
                <thead><tr><th colspan="2" style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;background:#f8f8f8;">失败信息如下</th></tr></thead>
                <tbody>
				    <tr>
                        <td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;width:100px">登录名</td>
                        <td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">' . $_POST['log'] . '</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center">尝试的密码</td>
                        <td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">' . $_POST['pwd'] . '</td>
                    </tr>
				    <tr>
                        <td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;">登录时间</td>
                        <td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">' . date("Y-m-d H:i:s") . '</td>
                    </tr>  
				    <tr>
                        <td style="padding:10px 0;border-right:1px solid #eee;border-bottom:1px solid #eee;text-align:center;">登录IP</td>
                        <td style="padding:10px 20px 10px 30px;border-right:1px solid #eee;border-bottom:1px solid #eee;line-height:30px">' . $_SERVER['REMOTE_ADDR'] . '</td>
                    </tr>               
                </tbody>
            </table>
            '.emailfooter;
    wp_mail( $to, $subject, $message, "Content-Type: text/html; charset=UTF-8" );
}
add_action('wp_login_failed', 'wp_login_failed_notify');
add_filter('logout_url', 'mk_logout_redirect_home', 10, 2);
function mk_logout_redirect_home($logouturl, $redir){
    $redir = home_url();
    return $logouturl . '&redirect_to=' . urlencode($redir);
}

// Notify the user when their account is updated
function user_profile_update( $user_id ) {
        $site_url = get_bloginfo('wpurl');
        $site_name = get_bloginfo('wpname');
        $user_info = get_userdata( $user_id );
        $to = $user_info->user_email;
        $subject = "".$site_name."账户更新";
        $message = EMAIL_HEADER_TOP.'您在' .$site_name. '账户资料修改成功！'.EMAIL_HEADER_BOT.'<p style="color: #6e6e6e;font-size:13px;line-height:24px;">亲爱的 ' .$user_info->display_name . '<br/>您的资料修改成功!<br/>谢谢您的光临</p>'.emailfooter;

        wp_mail( $to, $subject, $message, "Content-Type: text/html; charset=UTF-8");
}
add_action( 'profile_update', 'user_profile_update', 10, 2);

// Notify the user when their account is deleted
function iwilling_delete_user( $user_id ) {
    global $wpdb;
    $site_name = get_bloginfo('name');
    $user_obj = get_userdata( $user_id );
    $email = $user_obj->user_email;
    $subject = "帐号删除提示：".$site_name."";
    $message = EMAIL_HEADER_TOP.'您在' .$site_name. '的账户已被管理员删除！'.EMAIL_HEADER_BOT.'<p style="color: #6e6e6e;font-size:13px;line-height:24px;">如果您对本次操作有什么异议，请联系管理员反馈！<br/>我们会在第一时间处理您反馈的问题.</p>'.emailfooter;
    wp_mail( $email, $subject, $message, "Content-Type: text/html; charset=UTF-8");
}
add_action( 'delete_user', 'iwilling_delete_user' );

 
