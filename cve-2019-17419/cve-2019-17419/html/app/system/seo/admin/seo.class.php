<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');
load::sys_class('curl');
/** 参数设置 */
class seo extends admin {

	public function __construct() {
		global $_M;
		parent::__construct();
	}

    //获取参数设置
	public function doGetParameter()
    {
        global $_M;
        $list = array();

        $list['met_hometitle'] = isset($_M['config']['met_hometitle']) ? $_M['config']['met_hometitle'] : '';
        $list['met_title_type'] = isset($_M['config']['met_title_type']) ? $_M['config']['met_title_type'] : '';
        $list['met_keywords'] = isset($_M['config']['met_keywords']) ? $_M['config']['met_keywords'] : '';
        $list['met_alt'] = isset($_M['config']['met_alt']) ? $_M['config']['met_alt'] : '';
        $list['met_atitle'] = isset($_M['config']['met_atitle']) ? $_M['config']['met_atitle'] : '';
        $list['met_linkname'] = isset($_M['config']['met_linkname']) ? $_M['config']['met_linkname'] : '';
        $list['met_foottext'] = isset($_M['config']['met_foottext']) ? str_replace('&#34;', '"',$_M['config']['met_foottext'])  : '';
        $list['met_seo'] = isset($_M['config']['met_seo']) ? str_replace('&#34;', '"',$_M['config']['met_seo']) : '';
        $list['met_logo_keyword'] = isset($_M['config']['met_logo_keyword']) ? $_M['config']['met_logo_keyword'] : '';
        $list['met_404content'] = isset($_M['config']['met_404content']) ? str_replace('&#34;', '"',$_M['config']['met_404content']) : '';
        $list['met_data_null'] = isset($_M['config']['met_data_null']) ? $_M['config']['met_data_null'] : '';
        $list['met_tags_title'] = isset($_M['config']['met_tags_title']) ? $_M['config']['met_tags_title'] : '';
        $list['met_301jump']     = isset($_M['config']['met_301jump']) ? $_M['config']['met_301jump'] : '';


        $this->success($list);
    }

	//保存参数设置
	public function doSaveParameter(){
		global $_M;
        if ($_M['form']['met_logo_keyword'] == '') {
            $_M['form']['met_logo_keyword'] = $_M['config']['met_webname'];
        }

		$configlist   = array();
		$configlist[] = 'met_hometitle';
		$configlist[] = 'met_title_type';
		$configlist[] = 'met_keywords';
		$configlist[] = 'met_alt';
		$configlist[] = 'met_atitle';
		$configlist[] = 'met_linkname';
		$configlist[] = 'met_foottext';
		$configlist[] = 'met_seo';
        $configlist[] = 'met_logo_keyword';
        $configlist[] = 'met_404content';
        $configlist[] = 'met_data_null';
        $configlist[] = 'met_tags_title';
        $configlist[] = 'met_301jump';
        $configlist[] = 'tag_search_type';
        $configlist[] = 'tag_show_range';
        $configlist[] = 'tag_show_number';
        $configlist[] = 'tag_empty_list';

        configsave($configlist);
        buffer::clearConfig();

        load::sys_class('label', 'new')->get('seo')->html404();
        //写日志
        logs::addAdminLog('seoSetting','submit','jsok','doSaveParameter');
        $this->success("",$_M['word']['jsok']);
	}

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
