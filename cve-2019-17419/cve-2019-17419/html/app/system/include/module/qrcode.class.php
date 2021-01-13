<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

class qrcodes {	
	public function doqrcodes(){
		require_once  PATH_SYS_CLASS.'phpqrcode/phpqrcode.php';
        QRcode::png(urldecode($_M['form']['url']), null, QR_ECLEVEL_L, 4);
		echo 234234;
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>