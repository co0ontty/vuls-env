<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('news/news_op');

/**
 * news标签类
 */

class product_op extends news_op {

	/**
		* 初始化
		*/
	public function __construct() {
		global $_M;
    $this->database = load::mod_class('product/product_database', 'new');
	}

  //删除
  public function del_by_class($classnow) {
		global $_M;
		parent::del_by_class($classnow);
    //字段删除
    return true;
  }
  
	/*复制*/
	public function list_copy($classnow = '', $toclass1 ='', $toclass2 = '', $toclass3 = '', $tolang = '', $paras = array()){
		global $_M;
		$class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($classnow);
		$ids = parent::list_copy($classnow, $toclass1, $toclass2, $toclass3, $tolang);

		//内容属性
		if($paras){
			foreach($ids as $idkey => $idval){
				foreach($paras as $pkey => $pval){
					load::mod_class('parameter/parameter_op', 'new')->copy_para_list($class123['class1']['module'], $idkey, $pkey, $idval, $pval, $tolang);
				}
			}
		}

	}

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
