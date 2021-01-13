<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('product/product_op');

/**
 * news标签类
 */

class download_op extends product_op {

	/**
		* 初始化
		*/
	public function __construct() {
		global $_M;
    $this->database = load::mod_class('download/download_database', 'new');
	}

  //删除
  public function del_by_class($classnow) {
		global $_M;
		parent::del_by_class($classnow);
    //下载文件
    return true;
  }
  
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>

