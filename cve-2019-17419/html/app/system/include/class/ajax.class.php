<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_func('common');
load::sys_func('power');
load::sys_func('array');
load::sys_class('mysql');
load::sys_class('cache');

/**
 * ajax基类
 */
class ajax extends common {
	/**
	  * 初始化
	  */
	public function __construct() {
		global $_M;//全局数组$_M
		$this->load_form();//表单过滤
	}	
	
	/**
	  * 销毁
	  */
	public function __destruct(){
		global $_M;
		DB::close();//关闭数据库连接
		exit;
	}
} 

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>