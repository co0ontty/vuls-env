<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('array');

class authcode extends admin {

	function __construct() {
		parent::__construct();
	}

	public function doindex() {
		global $_M;
		$auth = load::mod_class('system/class/auth', 'new');
		if ($auth->have_auth()) {
			$info = $auth->authinfo();
		}
		return $info;
	}

	public function doauth() {
		global $_M;
		$auth = load::mod_class('system/class/auth', 'new');
		$redata['status']=1;
		$redata['msg']=$_M['word']['jsok'];
		if(!$auth->dl_auth($_M['form']['authpass'], $_M['form']['authcode'])){
			$redata['status']=0;
			$redata['msg']=$_M['word']['authTip2'];
		}
		$this->ajaxReturn($redata);
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>