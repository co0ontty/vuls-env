<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('column/column_label');

/**
 * 简介标签类
 */

class about_label extends column_label {

  /**
	 * 获取简介模块内容
	 * @param  string  $lang 语言标示
	 * @return array         about栏目配置数组
	 */
	public function get_about($id){
		global $_M;
		return $this->get_column_id($id);
  }

	/**
	 * 搜索简介
	 * @param  string  $lang 语言标示
	 * @return array         about栏目配置数组
	 */
	public function search_about($searchword){
		global $_M;
		$c = load::sys_class('label', 'new')->get('column')->get_class_list();
		foreach($c as $val){
			if( ( strstr($val['name'], $searchword) || strstr($val['name'], $searchword ) ) && $val['module'] == 1){
				$list[] = $val;
			}
		}
		return $list;
  }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
