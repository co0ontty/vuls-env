<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');

/**
 * 前台基类
 */
class userweb extends web {
	public $userclass;
	/**
	  * 初始化
	  */
	public function __construct() {
		global $_M;
		parent::__construct();
		$this->check();
		$this->userclass = load::sys_class('user', 'new');
		// 页面基本信息
		$query = "SELECT * FROM {$_M['table']['column']} WHERE module='10' AND lang='{$_M['lang']}'";
		$member = DB::get_one($query);
		$_M['config']['app_no']=0;
		 $this->add_input('page_title','-'.$member['name'].$this->input['page_title']);
		 $this->add_input('name',$member['name']);
		 $this->add_input('classnow',$this->input_class());
	}

	public function check() {
		global $_M;
		$user = $this->get_login_user_info();
		if(!$user){
			okinfo($_M['url']['web_site'].'member/login.php?lang='.$_M['form']['lang'].'&gourl='.$_M['form']['gourl'],$_M['word']['please_login']);
		}
	}

	public function mcheck() {
		global $_M;

	}

	protected function template($path){
		global $_M;
		$postion = strstr($path, '/',true);
		$file = substr(strstr($path, '/'),1);
		if ($postion == 'own') return PATH_OWN_FILE."templates/{$file}.php";
		if ($postion == 'ui') return PATH_SYS."include/public/ui/web/{$file}.php";
		if($postion == 'tem'){
			$sys_content=$_M['custom_template']['sys_content'];
			$flag=$sys_content?1:0;
			$sys_content = PATH_OWN_FILE."templates/{$file}.php";
			!file_exists($sys_content) && $sys_content = PATH_WEB."public/ui/v2/{$file}.php";
			$_M['custom_template']['sys_content']=$sys_content;
			if($flag){
				return $sys_content;
			}else{
				return $this->template('ui/compatible');
			}
		}
	}

	/**
	  * 重写web类的load_url_unique方法，获取前台特有URL
	  */
	protected function load_url_unique() {
		global $_M;
		parent::load_url_unique();
		// load::mod_class('user/user_url', 'new')->insert_m();
	}

	protected function navlist(){

	}
	//错误
	public function ajax_error($error){
		global $_M;
		$retun = array();
		$retun['status'] = 0;
		$retun['msg'] = $error;
		echo jsonencode($retun);
		die();
	}
	//成功
	public function ajax_success($success){
		global $_M;
		$retun = array();
		$retun['status'] = 1;
		$retun['msg'] = $success;
		echo jsonencode($retun);
		die();
	}
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
