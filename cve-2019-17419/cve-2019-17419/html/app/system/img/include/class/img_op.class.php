<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('product/product_op');

/**
 * news标签类
 */

class img_op extends product_op {

	/**
		* 初始化
		*/
	public function __construct() {
		global $_M;
    $this->database = load::mod_class('img/img_database', 'new');
	}
  
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>

