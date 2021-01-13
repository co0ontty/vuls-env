<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('handle');

/**
 * banner标签类
 */

class base_handle extends handle
{
	public $contents_page_name;//模块类型
	/**
	 * 初始化，继承类需要调用
	 */
	public function construct($contents_page_name) {
		global $_M;
		$this->contents_page_name = $contents_page_name;
	}

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
