<?php
if( class_exists( 'CSF' ) ) {
    $site_options = 'sites_post_meta';
    CSF::createMetabox($site_options, array(
        'title'     => __('站点信息','io_setting'),
        'post_type' => 'sites',
        'data_type' => 'unserialize',
        'theme'     => 'light',
    ));
    CSF::createSection($site_options, array(
        'title'     => '站点信息',
        'icon'      => 'fa fa-sitemap',
        'fields'    => array(
			array(
			  	'id'           => '_sites_type',
			  	'type'         => 'button_set',
			  	'title'        => __('类型','io_setting'),
			  	'options'      => array(
					'sites'  => __('网站','io_setting'),
					'wechat' => __('公众号/小程序','io_setting'),
					'down'   => __('下载资源','io_setting'),
			  	),
			  	'default'      => 'sites',
			),
			array(
				'id'      => '_visible',
				'type'    => 'switcher',
				'title'   => __('仅管理员可见','io_setting'),
				'default' => false,
			),
			array(
				'id'      => '_is_min_app',
				'type'    => 'switcher',
				'title'   => __('小程序','io_setting'),
				'default' => false,
				'dependency' => array( '_sites_type', '==', 'wechat' ),
			),
            array(
                'id'      => '_sites_link',
                'type'    => 'text',
                'class'   => 'sites_link',
                'title'   => __('链接','io_setting'),
                'desc'    => __('需要带上http://或者https://','io_setting'),
				'dependency' => array( '_sites_type', '!=', 'down' ),
            ),
            array(
                'id'      => '_spare_sites_link',
                'type'    => 'group',
                'title'   => __('备用链接地址（其他站点）','io_setting'),
                'subtitle'=> __('如果有多个链接地址，请在这里添加。','io_setting'),
                'fields'  => array(
                    array(
                        'id'    => 'spare_name',
                        'type'  => 'text',
                        'title' => __('站点名称','io_setting'),
                    ),
                    array(
                        'id'    => 'spare_url',
                        'type'  => 'text',
                        'title' => __('站点链接','io_setting'),
                        'desc'  => __('需要带上http://或者https://','io_setting'),
                    ),
                    array(
                        'id'    => 'spare_note',
                        'type'  => 'text',
                        'title' => __('备注','io_setting'),
                    ),
                ),
				'dependency' => array( '_sites_type', '==', 'sites' ),
            ),
            array(
                'id'      => '_sites_sescribe',
                'type'    => 'text',
                'class'   => 'sites_sescribe',
                'title'   => __('一句话描述（简介）','io_setting'),
                'after'   => '<br>'.__('推荐不要超过150个字符，详细介绍加正文。','io_setting'),
                'attributes' => array(
                  'style'    => 'width: 100%'
                ),
            ),
            array(
                'id'      => '_sites_language',
                'type'    => 'text',
                'title'   => __('站点语言','io_setting'),
                'after'   => '<br>'.__('站点支持的语言，多个用英语逗号分隔','io_setting'),
				'dependency' => array( '_sites_type', '==', 'sites' ),
            ),
            array(
                'id'      => '_sites_country',
                'type'    => 'text',
                'class'   => 'sites_country',
                'title'   => __('站点所在国家','io_setting'),
				'dependency' => array( '_sites_type', '==', 'sites' ),
            ),
			array(
				'id'      => '_sites_order',
				'type'    => 'text',
				'title'   => __('排序','io_setting'),
                'desc'    => __('网址排序数值越大越靠前','io_setting'),
				'default' => '0',
			),
            array(
                'id'      => '_thumbnail',
                'type'    => 'upload',
                'title'   => __('LOGO，标志','io_setting'),
                'library' => 'image',
                'desc'    => __('使用自定义图标','io_setting'),
                //'url'     => false,
            ),
            array(
                'id'      => '_wechat_qr',
                'type'    => 'upload',
                'title'   => __('公众号二维码','io_setting'),
                //'url'     => false,
				'dependency' => array( '_sites_type', '!=', 'down' ),
            ),
            //array(
            //    'id'      => '_sites_down',
            //    'type'    => 'text',
            //    'title'   => __('下载地址','io_setting'),
            //    'after'   => '<span style="color: red">后期将弃用，请在下方填写“下载地址信息”中填写，并修改以前添加的资源</span>',
			//	'dependency' => array( '_sites_type', '==', 'down' ),
            //),
            //array(
            //    'id'      => '_sites_password',
            //    'type'    => 'text',
            //    'title'   => __('网盘密码','io_setting'),
            //    'after'   => '<span style="color: red">后期将弃用，请在下方填写“下载地址信息”中填写，并修改以前添加的资源</span>',
			//	'dependency' => array( '_sites_type', '==', 'down' ),
            //),
            array(
                'id'      => '_down_version',
                'type'    => 'text',
                'title'   => __('资源版本','io_setting'),
				'dependency' => array( '_sites_type', '==', 'down' ),
            ),
            array(
                'id'      => '_down_size',
                'type'    => 'text',
                'title'   => __('资源大小','io_setting'),
                'after'   => __('填写单位：KB,MB,GB,TB' ,'io_setting'),
				'dependency' => array( '_sites_type', '==', 'down' ),
            ),
            array(
                'id'     => '_down_url_list',
                'type'   => 'group',
                'title'  => __('下载地址列表','io_setting'),
                'before' => __('添加下载地址，提取码等信息','io_setting'),
                'fields' => array(
                    array(
                      'id'    => 'down_btn_name',
                      'type'  => 'text',
                      'title' => __('按钮名称','io_setting'),
                      'default' => __('百度网盘','io_setting'),
                    ),
                    array(
                      'id'    => 'down_btn_url',
                      'type'  => 'text',
                      'title' => __('下载地址','io_setting'),
                    ),
                    array(
                      'id'    => 'down_btn_tqm',
                      'type'  => 'text',
                      'title' => __('提取码','io_setting'),
                    ),
                    array(
                      'id'    => 'down_btn_info',
                      'type'  => 'text',
                      'title' => __('描述','io_setting'),
                    ),
                ), 
				'dependency' => array( '_sites_type', '==', 'down' ),
            ),
            array(
                'id'      => '_dec_password',
                'type'    => 'text',
                'title'   => __('解压密码','io_setting'),
				'dependency' => array( '_sites_type', '==', 'down' ),
            ),
            array(
                'id'      => '_app_platform',
                'type'    => 'checkbox',
                'title'   => __('支持平台','io_setting'),
                'inline'  => true,
                'options' => array(
                    'icon-microsoft'        => 'PC',
                    'icon-mac'              => 'MAC OS',
                    'icon-linux'            => 'linux',
                    'icon-android'          => __('安卓','io_setting'),
                    'icon-app-store-fill'   => 'ios',
                ),
				'dependency' => array( '_sites_type', '==', 'down' ),
            ),
            array(
                'id'      => '_down_preview',
                'type'    => 'text',
                'title'   => __('演示地址','io_setting'),
				'dependency' => array( '_sites_type', '==', 'down' ),
            ),
            array(
                'id'      => '_down_formal',
                'type'    => 'text',
                'title'   => __('官方地址','io_setting'),
				'dependency' => array( '_sites_type', '==', 'down' ),
            ),
            array(
                'id'    => '_sites_screenshot',
                'type'  => 'gallery',
                'title' => __('添加截图','io_setting'),
				'dependency' => array( '_sites_type', '==', 'down' ),
            ),
            //array(
            //    'id'     => '_rar_screenshot',
            //    'type'   => 'repeater',
            //    'title'  => __('添加截图','io_setting'),
            //    'fields' => array(
            //      array(
            //        'id'    => 'rar_screen',
            //        'type'  => 'media',
            //        'title' => __('截图','io_setting'),
            //      ),
            //    ),
			//	'dependency' => array( '_sites_type', '==', 'down' ),
            //),
        )
    ));
 
    CSF::createSection( $site_options, array(
        'title'  => 'SEO',
        'icon'   => 'fa fa-paw',
        'fields' => array(
            array(
                'id'    => '_seo_title',
                'type'  => 'text',
                'title' => __('自定义标题','io_setting'),
                'after' => '<br>'.__('留空则获取文章标题','io_setting'),
            ),
            array(
                'id'    => '_seo_metakey',
                'type'  => 'text',
                'title' => __('自定义关键词','io_setting'),
                'after' => '<br>'.__('留空则获取文章标签','io_setting'),
            ),
            array(
                'id'    => '_seo_desc',
                'type'  => 'textarea',
                'title' => __('自定义描述','io_setting'),
                'after' => '<br>'.__('留空则获取文章简介或摘要','io_setting'),
            ),
      
        )
    ));
      
}


if( class_exists( 'CSF' ) ) {
    $site_options = 'app_post_meta';
    CSF::createMetabox($site_options, array(
        'title'     => __('APP 信息','io_setting'),
        'post_type' => 'app',
        'data_type' => 'unserialize',
        'theme'     => 'light',
    ));
    CSF::createSection($site_options, array(
        'title'     => 'app 信息',
        'icon'      => 'fa fa-sitemap',
        'fields'    => array(
            array(
                'type'    => 'content',
                'content' => __('排序：根据文章修改时间排序','io_setting'),//文章标题和seo标题为：app名称+app版本+更新日期+简介+APP状态<br>
            ),
            array(
                'id'      => '_app_ico',
                'type'    => 'upload',
                'title'   => __('app 图标 *','io_setting'),
                'subtitle'=> __('推荐256x256 必填','io_setting'),
                'library' => 'image',
                'class'   => 'cust_app_ico',
                'desc'    => __('添加图标地址，调用自定义图标','io_setting'),
            ),
            array(
                'id'     => 'app_ico_o',
                'type'   => 'fieldset',
                'title'  => __('app 图标选项','io_setting'),
                'fields' => array(
                    array(
                        'type'    => 'content',
                        'content' => __('预览','io_setting'),
                        'dependency' => array( 'ico_a', '==', true )
                    ),
                    array(
                        'id'    => 'ico_a',
                        'type'  => 'switcher',
                        'title' => __('透明','io_setting'),
                        'label' => __('图片是否透明？','io_setting'),
                    ),
                    array(
                        'id'        => 'ico_color',
                        'type'      => 'color_group',
                        'title'     => __('背景颜色','io_setting'),
                        'options'   => array(
                            'color-1' => __('颜色 1','io_setting'),
                            'color-2' => __('颜色 2','io_setting'),
                        ),
                        'default'   => array(
                          'color-1' => '#f9f9f9',
                          'color-2' => '#e8e8e8',
                        ),
                        'dependency' => array( 'ico_a', '==', true )
                    ),
                    array(
                        'id'      => 'ico_size',
                        'type'    => 'slider',
                        'title'   => __('缩放','io_setting'),
                        'min'     => 20,
                        'max'     => 100,
                        'step'    => 1,
                        'unit'    => '%',
                        'default' => 70,
                        'dependency' => array( 'ico_a', '==', true )
                    ),
                ),
            ),
            array(
                'id'      => '_app_name',
                'type'    => 'text',
                'title'   => __('APP 名称','io_setting'),
            ),
            array(
                'id'      => '_app_platform',
                'type'    => 'checkbox',
                'title'   => __('APP支持平台','io_setting'),
                'inline'  => true,
                'options' => array(
                    'icon-microsoft'        => 'PC',
                    'icon-mac'              => 'MAC OS',
                    'icon-linux'            => 'linux',
                    'icon-android'          => __('安卓','io_setting'),
                    'icon-app-store-fill'   => 'ios',
                ),
            ),
            array(
                'id'      => '_down_formal',
                'type'    => 'text',
                'title'   => __('官方地址','io_setting'),
            ),
            array(
                'id'    => '_app_screenshot',
                'type'  => 'gallery',
                'title' => __('添加截图','io_setting'),
            ),
            //array(
            //    'id'     => 'app_screenshot',
            //    'type'   => 'repeater',
            //    'title'  => __('添加截图','io_setting'),
            //    'fields' => array(
            //      array(
            //        'id'    => 'app_screen',
            //        'type'  => 'media',
            //        'title' => __('截图','io_setting'),
            //      ),
            //    ),
            //),
            array(
                'id'      => '_app_sescribe',
                'type'    => 'text',
                'title'   => __('简介','io_setting'),
                'after'   => '<br>'.__('推荐不要超过150个字符，详细介绍加正文。','io_setting'),
            ), 
            array(
                'id'     => 'app_down_list',
                'type'   => 'group', 
                'before' => __('APP 版本信息（添加版本，可构建历史版本）', 'io_setting'),
                'fields' => array(
                    array(
                        'id'    => 'app_version',
                        'type'  => 'text',
                        'title' => __('版本号','io_setting'),
                        'placeholder'=>__('添加版本号','io_setting'),
                    ),
                    array(
                        'id'    => 'app_date',
                        'type'  => 'date',
                        'title' => __('更新日期','io_setting'),
                        'settings' => array(
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'default' => date('yy-m-d'),
                    ),
                    array(
                      'id'     => 'app_size',
                      'type'   => 'text',
                      'title'  => __('APP 大小', 'io_setting'),
                      'after'  => __('填写单位：KB,MB,GB,TB' ,'io_setting'),
                    ),
                    array(
                        'id'     => 'down_url',
                        'type'   => 'group',
                        'before' => __('下载地址信息','io_setting'),
                        'fields' => array(
                            array(
                              'id'    => 'down_btn_name',
                              'type'  => 'text',
                              'title' => __('按钮名称','io_setting'),
                            ),
                            array(
                              'id'    => 'down_btn_url',
                              'type'  => 'text',
                              'title' => __('下载地址','io_setting'),
                            ),
                            array(
                              'id'    => 'down_btn_tqm',
                              'type'  => 'text',
                              'title' => __('提取码','io_setting'),
                            ),
                        ), 
                    ),
                    array(
                        'id'      => 'app_status',
                        'type'    => 'radio',
                        'title'   => __('APP状态','io_setting'),
                        'inline'  => true,
                        'options' => array(
                            'official'  => __('官方版','io_setting'),
                            'cracked'   => __('开心版','io_setting'),
                        ),
                        'default' => 'official',
                    ),
                    array(
                        'id'    => 'app_ad',
                        'type'  => 'switcher',
                        'title' => __('是否有广告','io_setting'),
                    ),
                    array(
                        'id'      => 'app_language',
                        'type'    => 'text',
                        'title'   => __('支持语言','io_setting'),
                        'default' => __('中文','io_setting'),
                    ),
                    array(
                        'id'            => 'version_describe',
                        'type'          => 'wp_editor',
                        'title'         => __('版本描述','io_setting'), 
                        'tinymce'       => true,
                        'quicktags'     => true,
                        'media_buttons' => false,
                        'height'        => '100px',
                    ),
                ),
                'default' => array(
                    array( 
                        'app_date' => date('yy-m-d'),
                        'down_url' => array(
                            array(
                                'down_btn_name' => __('百度网盘','io_setting'),
                            )
                        ), 
                        'app_status' => 'official',
                        'app_language' => __('中文','io_setting')
                    ),
                )
            ),
        )
    ));
 
    CSF::createSection( $site_options, array(
        'title'  => 'SEO',
        'icon'   => 'fa fa-paw',
        'fields' => array(
            array(
                'id'    => '_seo_title',
                'type'  => 'text',
                'title' => __('自定义标题','io_setting'),
                'after' => '<br>'.__('留空则获取(app名称+app版本+是否有广告+APP状态+更新日期)为标题','io_setting'),
            ),
            array(
                'id'    => '_seo_metakey',
                'type'  => 'text',
                'title' => __('自定义关键词','io_setting'),
                'after' => '<br>'.__('留空则获取文章标签','io_setting'),
            ),
            array(
                'id'    => '_seo_desc',
                'type'  => 'textarea',
                'title' => __('自定义描述','io_setting'),
                'after' => '<br>'.__('留空则获取文章简介或摘要','io_setting'),
            ),
      
        )
    ));
}