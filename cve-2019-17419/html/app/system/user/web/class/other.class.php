<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

class other{
	public $errorno;
	public $appid;
	public $appkey;
	public $table;
	public $type;
	public function __construct() {
		global $_M;
		$this->appid = $_M['config']['met_weibo_appkey'];
		$this->appkey = $_M['config']['met_weibo_appsecret'];
		$this->table = $_M['table']['user_other'];
		$this->type = 'weibo';
	}	
	

	public function get_user($info){
		$infos = $this->get_access_token($info);
		if(!$infos){
			return false;
		}
		$user = $this->get_user_by_openid($infos['unionid']);
		if(!$user){
			$user['register'] = "no";
			$user['other_id'] = $infos['unionid'];
			$user['other_type'] = $this->type;
		}else{
			$user['register'] = "yes";
		}
		return $user;
	}
	
	public function get_user_by_openid($unionid){	
		$other_user = $this->get_other_user($unionid);
		if($other_user['met_uid']){
			$user = load::sys_class('user', 'new')->get_user_by_id($other_user['met_uid']);
		}
		return $user;
	}
	
	public function register($unionid, $username = ''){
		$userclass = load::sys_class('user', 'new');
		if($username == ''){
			$uerinfo  = $this->get_info_by_curl($unionid);
			if(!$uerinfo){
				return false;
			}
			$username = $uerinfo['username'];
		}
		$result = $userclass->register($username, random('16'), '', '', '', 1, '', $this->type);
		if(!$result){
			if(strstr($userclass->errorno, 'username')){
				$this->errorno = "re_username";
			}else{
				$this->errorno = $userclass->errorno;
			}
			return false;
		}else{
			$user = $userclass->get_user_by_username($username);		
			$this->update_other_user($unionid, '#', $user['id'], '#', '#');
			return $user['id'];
		}
	}
	
	public function get_access_token($info){
		if(is_numeric($info)){
			$data = $this->get_other_user($info);
		}else{
			$data = $this->get_access_token_by_curl($info);
			if(!$data){
				return false;
			}
			if($this->get_other_user($data['unionid'])){
				$this->update_other_user($data['unionid'], $data['openid'], '#', $data['access_token'], $data['expires_in']);
				DB::query($query);
			}else{
				$this->insert_other_user('0', $data['openid'], $data['unionid'], $data['access_token'], $data['expires_in']);
			}
		}
		return $data;		
	}
	
	public function get_other_user($unionid){
		$query = "SELECT * FROM {$this->table} WHERE unionid = '{$unionid}' and type='{$this->type}'";
		return DB::get_one($query);
	}
	
	public function insert_other_user($met_uid, $openid, $unionid, $access_token, $expires_in){
		$query = "INSERT INTO {$this->table} SET met_uid='{$met_uid}', openid = '{$openid}',unionid='{$unionid}',access_token='{$access_token}', expires_in='{$expires_in}', type='{$this->type}'";
		return DB::query($query);
	}
	
	public function update_other_user($unionid, $openid = '#' , $met_uid = '#', $access_token = '#', $expires_in = '#'){
		if($met_uid != '#'){
			$sql .= "met_uid='{$met_uid}',";
		}
		if($access_token != '#'){
			$sql .= "access_token='{$access_token}', expires_in='{$expires_in}',";
		}
		if($openid != '#'){
			$sql .= "openid='{$openid}',";
		}
		$sql = trim($sql, ',');
		$query = "UPDATE {$this->table} SET {$sql} WHERE unionid = '{$unionid}'";
		return DB::query($query);
	}
	
	public function set_state(){
		load::sys_class('session', 'new')->set('other_state', random(10));
	}
	
	public function get_state(){
		return load::sys_class('session', 'new')->get('other_state');
	}
	
	public function state_ok($state){
		if($state == load::sys_class('session', 'new')->get('other_state')){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_access_token_by_curl($code){
		//必须返回access_token,expires_in,openid
	}
	
	public function get_info_by_curl($openid){
		//必须返回username
	}
	
	public function get_login_url(){
		//必须返回第三方登录地址
	}
	
	public function error_curl($data){
		if($data['error']){
			$this->errorno = $data['error_description'] ? $data['error_description'] : $data['error'];
			return true;
		}else{
			return false;
		}
	}
}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>