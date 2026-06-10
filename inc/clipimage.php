<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Post thumbnail and image handling helpers
 */

/**
 * Add featured thumbnail support
 * Uncomment below if needed
 */
if ( function_exists('add_theme_support') )add_theme_support('post-thumbnails');

/**
 * Get the featured image URL
 */
function io_theme_get_thumb($post = null){
	if( $post === null ){
    	global $post;
    }
	if( has_post_thumbnail() ){    // If a featured thumbnail exists, output its URL
		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src [0];
	} else {
		$post_thumbnail_src = '';
		$strResult = io_get_post_first_img(true);
		if(!empty($strResult[1][0])){
			$post_thumbnail_src = $strResult[1][0];   // Get the image src
		}else{	
            // If the post contains no image, use a random image
            $random_img = explode(PHP_EOL , io_get_option('random_head_img'));
            $random_img_array = array_rand($random_img);
            $post_thumbnail_src = trim($random_img[$random_img_array]);
		}
    }
    return $post_thumbnail_src;
}

/**
 * Get/output the thumbnail URL
 */
function io_get_post_first_img($is_array = false){ 
     
    global $post; 
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $strResult);
    if($is_array)
        return $strResult;
    else{
        if(!empty($strResult[1][0])){
			return $strResult[1][0];  
		}else{	
            return null;
		}
    }
}
    
/**
 * Get/output the thumbnail URL
 */
function io_get_thumbnail($size = 'thumbnail',$isback = false){
    $post_thumbnail_src = io_theme_get_thumb();
    if($isback){
        return getOptimizedImageUrl($post_thumbnail_src, $size,'90');
    }
    if(io_get_option('lazyload')){
        $loadimg_url=get_theme_file_uri('/images/t.png');
        return 'src="'.$loadimg_url.'" data-src="'.getOptimizedImageUrl($post_thumbnail_src, $size,'90').'"';
    } else {
        return 'src="'.getOptimizedImageUrl($post_thumbnail_src, $size,'90').'"';
    }
}

/**
 * Get the Timthumb cropped image URL
 */
function getTimthumbImage($url, $size = 'thumbnail', $q='70', $nohttp = false){
    if($nohttp)
        $timthumb =  get_theme_file_uri('/timthumb.php');
    else
        $timthumb = str_replace(array('https:','http:'),array('',''), get_theme_file_uri()) . '/timthumb.php';
    // Do not crop GIFs, because it generates invalid black images
    $imgtype = strtolower(substr($url, strrpos($url, '.')));
    if($imgtype === 'gif') return $url;

    $size = getFormatedSize($size);
    return $timthumb . stripslashes('?src=' . $url . '&q=' . $q . '&w=' . $size['width'] . '&h=' . $size['height'] . '&zc=1');
} 


/**
 * Choose the appropriate image URL handling method based on user settings (timthumb|cdn)
 */
function getOptimizedImageUrl($url, $size, $q='70', $nohttp = false){
    if (!preg_match('/'. str_replace('/', '\/', get_host(home_url())) .'/i',$url)) {
        //error_log("Invalid URL".$url.PHP_EOL, 3, "./php_3.log");
        return getTimthumbImage($url, $size, $q, $nohttp);
    }
    else{
        return getTimthumbImage($url, $size, $q, $nohttp);
    }
}


/**
 * Convert size
 */
function getFormatedSize($size){
    if(is_array($size)){
        $width = array_key_exists('width', $size) ? $size['width'] : 225;
        $height = array_key_exists('height', $size) ? $size['height'] : 150;
        $str = array_key_exists('str', $size) ? $size['str'] : 'thumbnail';
    }else{
        switch ($size){
            case 'medium':
                $width = 375;
                $height = 250;
                $str = 'medium';
                break;
            case 'large':
                $width = 960;
                $height = 640;
                $str = 'large';
                break;
            default:
                $width = 225;
                $height = 150;
                $str = 'thumbnail';
        }
    }
    return array(
        'width'   =>  $width,
        'height'  =>  $height,
        'str'     =>  $str
    );
}

/**
 * Get the top-level domain
 * @return [type] 
 * For example, www.iowen.cn returns iowen.cn
 */
function get_host($to_virify_url = ''){
    
    $url   = $to_virify_url ? $to_virify_url : $_SERVER['HTTP_HOST'];
    $data = explode('.', $url);
    $co_ta = count($data);
 
    // Check whether it has a double suffix
    $zi_tow = true;
    $host_cn = 'com.cn,net.cn,org.cn,gov.cn';
    $host_cn = explode(',', $host_cn);
    foreach($host_cn as $host){
        if(strpos($url,$host)){
            $zi_tow = false;
        }
    }
 
    // Return FALSE if it is, otherwise return true
    if($zi_tow == true){
 
        // Whether it is the current domain
        if($url == 'localhost'){
            $host = $data[$co_ta-1];
        }
        else{
            $host = $data[$co_ta-2].'.'.$data[$co_ta-1];
        }
        
    }
    else{
        $host = $data[$co_ta-3].'.'.$data[$co_ta-2].'.'.$data[$co_ta-1];
    }
    
    return $host;
}
