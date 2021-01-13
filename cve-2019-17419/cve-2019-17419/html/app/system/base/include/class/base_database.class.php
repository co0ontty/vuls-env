<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 系统默认
 */

class base_database extends database{

  public $module;
  /**
	 * 初始化模型编号
	 * @param  string  $module 模型编号
	 * @param  string  $table  数据表名称
	 */
	public function construct($table) {
    global $_M;
    parent::construct($table);
    $this->module = str_replace($_M['config']['tablepre'], '', $this->table);
	}

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
