<?php
/*
Template Name: 投稿模板
*/

get_header(); 

include( 'templates/sidebar-nav.php' );
?>
<div class="main-content flex-fill page">
<?php include( 'templates/header-banner.php' ); ?>
    <div id="content" class="container my-4 my-md-5"> 
            <div class="panel card">
                <div class="card-body">
                    <h1 class="h2 mb-4"><?php echo get_the_title() ?></h1>
                    <div class="panel-body my-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php while( have_posts() ): the_post(); ?>
	    			            <?php the_content(); ?>
                                    <?php edit_post_link(__('编辑','i_theme'), '<span class="edit-link">', '</span>' ); ?>
	    		                <?php endwhile; ?> 
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div id="tougao-form" class="tougao-form">
                <h1 id="comments-list-title" class="comments-title h5 mx-1 my-4">
                	<i class="iconfont icon-tougao mr-2"></i>推荐资源 
                </h1> 
                <div class="panel panel-tougao card">
  

                <div class="card-body"> 
                    
                    <div class='slider_menu' sliderTab="sliderTab">
                        <ul class="nav nav-pills menu" role="tablist">
                            <li class="pagenumber nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#sites">网站</a>
                            </li>
                            <li class="pagenumber nav-item">
                                <a class="nav-link" data-toggle="pill" href="#wechat">公众号</a>
                            </li>
                            <li class="pagenumber nav-item">
                                <a class="nav-link" data-toggle="pill" href="#down">资源</a>
                            </li>
                        </ul>

                    </div> 
                    <div class="tab-content mt-4">
                        <div id="sites" class="tab-pane active"> 
                            <form class="i-tougao mb-4" method="post" data-type="sites" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                                <input type="hidden" class="form-control" value="sites" name="tougao_type"/>
                                <div class="my-2">
                                    <label for="tougao_sites_ico">网站图标:</label>
                                    <input type="hidden" value="" id="tougao_sites_ico" name="tougao_sites_ico" />
                                    <div class="upload_img">
                                        <div class="show_ico">
                                            <img id="show_sites_ico" src="<?php echo get_theme_file_uri('/images/add.png') ?>" alt="网站图标">
                                            <i id="remove_sites_ico" class="iconfont icon-close-circle remove-ico" data-id="" data-type="ico" style="display: none;"></i>
                                        </div> 
                                        <input type="file" id="upload_sites_ico" data-type="ico" accept="image/*" onchange="uploadImg(this)" >
                                    </div>
                                </div>
                                <div class="row-sm">
                                    <div class="col-sm-6 my-2"> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-name icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" name="tougao_title" placeholder="网站名称 *" maxlength="30"/>
                                        </div>

                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-url icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" name="tougao_sites_link" placeholder="网站链接 *"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-tishi icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" name="tougao_sites_sescribe"  placeholder="网站描叙 *" maxlength="50"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-category icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <?php
                                            $cat_args = array(
                                                'show_option_all'     => "选择分类 *",
                                                'hide_empty'          => 0,
                                                'id'                  => 'tougaocategorg_sites',
                                                'taxonomy'            => 'favorites',
                                                'name'                => 'tougao_cat',
                                                'class'               => 'form-control',
                                                'show_count'          => 1,
                                                'hierarchical'        => 1,
                                            );
                                            wp_dropdown_categories($cat_args);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-12 my-2 ">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-point icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control sites_keywords" value="" name="tougao_sites_keywords"  placeholder="网站关键字，请用英语逗号分隔" maxlength="50"/>
                                        </div>
                                    </div>
                                    <div class="col-12 my-2">
                                        <label style="vertical-align:top" for="tougao_content">网站介绍:</label>
                                        <textarea class="form-control text-sm" rows="6" cols="55" name="tougao_content"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-4 my-2">
                                        <div class="input-group text-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-key icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" name="tougao_form" class="form-control input_veri" maxlength="4" placeholder="输入验证码">
                                            <div class="input-group-append">
                                                <span class="verification-text input-group-text text-sm">0000</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(io_get_option('is_publish')) { ?>
                                    <div class="col-5 col-md-5 my-2">
                                        <div class="custom-control custom-switch my-1">
                                            <input type="checkbox" name="is_publish" class="custom-control-input" id="customSwitch1">
                                            <label class="custom-control-label" for="customSwitch1">直接发布</label>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-3 my-2">
                                    <?php } else { ?>
                                    <div class="col-12 col-md-3 my-2">
                                    <?php } ?>
                                        <button type="submit" class="btn custom_btn-d text-sm col-12">提交</button>
                                    </div> 
                                </div> 
                            </form> 
                        </div>
                        <div id="wechat" class="tab-pane fade">
                            <form class="i-tougao mb-4" method="post" data-type="wechat" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                                <input type="hidden" class="form-control" value="wechat" name="tougao_type"/>
                                <div class="my-2">
                                    <label for="tougao_wechat_ico">公众号图标:</label>
                                    <input type="hidden" value="" id="tougao_wechat_ico" name="tougao_sites_ico" />
                                    <div class="upload_img">
                                        <div class="show_ico">
                                            <img id="show_wechat_ico" src="<?php echo get_theme_file_uri('/images/add.png') ?>" alt="公众号图标">
                                            <i id="remove_wechat_ico" class="iconfont icon-close-circle remove-ico" data-id="" data-type="ico" style="display: none;"></i>
                                        </div> 
                                        <input type="file" id="upload_wechat_ico" data-type="ico" accept="image/*" onchange="uploadImg(this)" >
                                    </div>
                                </div>
                                <div class="row-sm">
                                    <div class="col-sm-6 my-2"> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-name icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" id="tougao_wechat_title" name="tougao_title" placeholder="公众号名称 *" maxlength="30"/>
                                        </div>

                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-url icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" id="tougao_wechat_link" name="tougao_sites_link" placeholder="公众号链接"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-tishi icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" id="tougao_wechat_sescribe" name="tougao_sites_sescribe"  placeholder="公众号描叙 *" maxlength="50"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-category icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <?php
                                            $cat_args = array(
                                                'show_option_all'     => "选择分类 *",
                                                'hide_empty'          => 0,
                                                'id'                  => 'tougaocategorg_wechat',
                                                'taxonomy'            => 'favorites',
                                                'name'                => 'tougao_cat',
                                                'class'               => 'form-control',
                                                'show_count'          => 1,
                                                'hierarchical'        => 1,
                                            );
                                            wp_dropdown_categories($cat_args);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-2 my-2">
                                        <label for="tougao_wechat_qr">公众号二维码:</label>
                                        <input type="hidden" value="" id="tougao_wechat_qr" name="tougao_wechat_qr" />
                                        <div class="upload_img wechat">
                                            <div class="show_ico">
                                                <img id="show_wechat_qr" src="<?php echo get_theme_file_uri('/images/add.png') ?>" alt="公众号二维码">
                                                <i id="remove_wechat_qr" class="iconfont icon-close-circle remove-ico" data-id="" data-type="qr" style="display: none;"></i>
                                            </div> 
                                            <input type="file" id="upload_wechat_qr" data-type="qr" accept="image/*" onchange="uploadImg(this)" >
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-lg-10 my-2">
                                        <label style="vertical-align:top" for="tougao_content">公众号介绍:</label>
                                        <textarea class="form-control text-sm" rows="6" cols="55" name="tougao_content"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-4 my-2">
                                        <div class="input-group text-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-key icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" name="tougao_form" class="form-control input_veri" maxlength="4" placeholder="输入验证码">
                                            <div class="input-group-append">
                                                <span class="verification-text input-group-text text-sm">0000</span>
                                            </div>
                                        </div>
                                    </div> 
                                    <?php if(io_get_option('is_publish')) { ?>
                                    <div class="col-5 col-md-5 my-2">
                                        <div class="custom-control custom-switch my-1">
                                            <input type="checkbox" name="is_publish" class="custom-control-input" id="customSwitch2">
                                            <label class="custom-control-label" for="customSwitch2">直接发布</label>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-3 my-2">
                                    <?php } else { ?>
                                    <div class="col-12 col-md-3 my-2">
                                    <?php } ?>
                                        <button type="submit" class="btn custom_btn-d text-sm col-12">提交</button>
                                    </div>
                                </div> 
                            </form> 
                        </div>
                        <div id="down" class="tab-pane fade">
                            <form class="i-tougao mb-4" method="post" data-type="down" action="<?php echo $_SERVER["REQUEST_URI"]?>">
                                <input type="hidden" class="form-control" value="down" name="tougao_type"/>
                                <div class="my-2">
                                    <label for="tougao_down_ico">资源图标:</label>
                                    <input type="hidden" value="" id="tougao_down_ico" name="tougao_sites_ico" />
                                    <div class="upload_img">
                                        <div class="show_ico">
                                            <img id="show_down_ico" src="<?php echo get_theme_file_uri('/images/add.png') ?>" alt="网站图标">
                                            <i id="remove_down_ico" class="iconfont icon-close-circle remove-ico" data-id="" data-type="ico" style="display: none;"></i>
                                        </div> 
                                        <input type="file" id="upload_down_ico" data-type="ico" accept="image/*" onchange="uploadImg(this)" >
                                    </div>
                                </div>
                                <div class="row-sm">
                                    <div class="col-sm-6 my-2"> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-name icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" id="tougao_title" name="tougao_title" placeholder="资源名称 *" maxlength="30"/>
                                        </div>

                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-tishi icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" id="tougao_sites_sescribe" name="tougao_sites_sescribe"  placeholder="资源描叙 *" maxlength="50"/>
                                        </div>
                                    </div>




                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-version icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" name="tougao_down_version"  placeholder="资源版本" maxlength="50"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-url icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" name="tougao_down_formal"  placeholder="官网链接" maxlength="50"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-url icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" name="tougao_sites_down"  placeholder="网盘链接" maxlength="50"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-url icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" name="tougao_down_preview"  placeholder="演示链接" maxlength="50"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-password icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" name="tougao_sites_password"  placeholder="网盘密码" maxlength="50"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-password icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="" name="tougao_down_decompression"  placeholder="解压密码" maxlength="50"/>
                                        </div>
                                    </div>




                                    <div class="col-sm-6 my-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-category icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <?php
                                            $cat_args = array(
                                                'show_option_all'     => "选择分类 *",
                                                'hide_empty'          => 0,
                                                'id'                  => 'tougaocategorg_down',
                                                'taxonomy'            => 'favorites',
                                                'name'                => 'tougao_cat',
                                                'class'               => 'form-control',
                                                'show_count'          => 1,
                                                'hierarchical'        => 1,
                                            );
                                            wp_dropdown_categories($cat_args);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-12 my-2">
                                        <label style="vertical-align:top" for="tougao_content">资源介绍(使用说明):</label>
                                        <textarea class="form-control text-sm" rows="6" cols="55" name="tougao_content"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-4 my-2">
                                        <div class="input-group text-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="iconfont icon-key icon-fw" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" name="tougao_form" class="form-control input_veri" maxlength="4" placeholder="输入验证码">
                                            <div class="input-group-append">
                                                <span class="verification-text input-group-text text-sm">0000</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(io_get_option('is_publish')) { ?>
                                    <div class="col-5 col-md-5 my-2">
                                        <div class="custom-control custom-switch my-1">
                                            <input type="checkbox" name="is_publish" class="custom-control-input" id="customSwitch3">
                                            <label class="custom-control-label" for="customSwitch3">直接发布</label>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-3 my-2">
                                    <?php } else { ?>
                                    <div class="col-12 col-md-3 my-2">
                                    <?php } ?>
                                        <button type="submit" class="btn custom_btn-d text-sm col-12">提交</button>
                                    </div>
                                </div> 
                            </form> 
                        </div>
                    </div> 
	    	    </div> 
	    	    </div> 
	    	</div> 
    </div>
    
<script> 
    var verification = Math.floor(Math.random()*(9999-1000+1)+1000);
    $('.verification-text').text(verification);


    $('.i-tougao').submit(function() {
        if($(this).find('.input_veri').val() != verification){
            showAlert(JSON.parse('{"status":3,"msg":"验证码错误！"}'));
            return false;
        }
        if(checkText($(this).find('.sites_keywords').val())){
            return false;
        }
		$.ajax({
    	    url: theme.ajaxurl,
            type:     'POST',
            dataType: 'json',
            data:     $(this).serialize() + "&action=contribute_post", 
        }).done(function (result) {
            if(result.status == 1){
                verification = Math.floor(Math.random()*(9999-1000+1)+1000);
                $('.verification-text').text(verification);
                $(':input','.i-tougao') 
                .not(':button, :submit, :reset, :hidden') 
                .val('') 
                .removeAttr('checked') 
                .removeAttr('selected');
            }
            showAlert(result);
        }).fail(function (result) {
            showAlert(JSON.parse('{"status":3,"msg":"网络连接错误！"}'));
        });
        return false;
    }); 
    function checkText(text)
    {
        var reg = /[\u3002|\uff1f|\uff01|\uff0c|\u3001|\uff1b|\uff1a|\u201c|\u201d|\u2018|\u2019|\uff08|\uff09|\u300a|\u300b|\u3008|\u3009|\u3010|\u3011|\u300e|\u300f|\u300c|\u300d|\ufe43|\ufe44|\u3014|\u3015|\u2026|\u2014|\uff5e|\ufe4f|\uffe5]/;
        if(reg.test(text)){
            showAlert(JSON.parse('{"status":3,"msg":"关键词请使用英语逗号分隔。"}'));
            return true;
        }else{
            return false;
        }
    }
    function uploadImg(file) {
        var tg_type = $(file).parents(".i-tougao").data('type');
        var doc_id=file.getAttribute("data-type");
        if (file.files != null && file.files[0] != null) {
            if (!/\.(jpg|jpeg|png|JPG|PNG)$/.test(file.files[0].name)) {    
                showAlert(JSON.parse('{"status":3,"msg":"图片类型只能是jpeg,jpg,png！"}'));   
                return false;    
            } 
            if(file.files[0].size > (64 * 1024)){
                showAlert(JSON.parse('{"status":3,"msg":"图片大小不能超过64kb"}'));
                return false;
            }
            var formData = new FormData();
            formData.append('files', file.files[0]);
            formData.append('action','img_upload');
    	    $.ajax({
    	        url: theme.ajaxurl,
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false
            }).done(function (result) {
                showAlert(result);
                if(result.status == 1){
                    $("#show_"+tg_type+"_"+doc_id).attr("src", result.data.src);
                    $("#tougao_"+tg_type+"_"+doc_id).val(result.data.src);
                    $("#remove_"+tg_type+"_"+doc_id).data('id',result.data.id).show();
                    $(file).attr("disabled","disabled").parent().addClass('disabled');
                }
            }).fail(function (result) {
                showAlert(JSON.parse('{"status":3,"msg":"网络连接错误！"}'));
            });
        }else{
            showAlert(JSON.parse('{"status":2,"msg":"请选择文件！"}'));
            return false;
        }
    }
    $('.remove-ico').click(function() {
        if(!confirm('确定要删除图片吗?')){
            return false;
        }
        var tg_type = $(this).parents(".i-tougao").data('type');
        var doc_id = $(this).data('type');
		$.ajax( {
			url: theme.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
				action: "img_remove",
				id: $(this).data("id"),
			}
        }).done(function (result) {
            showAlert(result);
            if(result.status == 1){
                $("#show_"+tg_type+"_"+doc_id).attr("src", theme.addico);
                $("#tougao_"+tg_type+"_"+doc_id).val('');
                $("#remove_"+tg_type+"_"+doc_id).data('id','').hide();
                $("#upload_"+tg_type+"_"+doc_id).removeAttr("disabled").val("").parent().removeClass('disabled');
            }
        }).fail(function (result) {
            showAlert(JSON.parse('{"status":3,"msg":"网络连接错误！"}'));
        });
    });
</script>

<?php get_footer(); ?>
