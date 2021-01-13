<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');

/*兼容标签*/
require_once PATH_WEB.'app/system/include/compatible/metv5_top.php';
// foreach($_M['custom_template']['mod']['file'] as $key=>$val){
//   require_once $val;
// }
if(!file_exists($this->template($_M['custom_template']['file']))){
	die($_M['word']['templatesusererror']);
}
//require_once $_M['custom_template']['file'];
require_once $this->template($_M['custom_template']['file']);
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
