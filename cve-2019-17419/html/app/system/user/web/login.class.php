<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('user/web/class/userweb');

class login extends userweb
{

    public function __construct()
    {
        global $_M;
        parent::__construct();
        if ($_M['form']['gourl']) {
            $_M['url']['user_home'] = base64_decode($_M['form']['gourl']);
            if (strpos($_M['url']['login'], 'lang=')) {
                $_M['url']['login'] .= "&gourl=" . $_M['form']['gourl'];
            } else {
                $_M['url']['login'] .= "?gourl=" . $_M['form']['gourl'];
            }
        }
    }

    public function check()
    {

    }

    public function doindex()
    {
        global $_M;
        $session = load::sys_class('session', 'new');
        // 如果已登录直接跳转到个人中心
        if ($_M['user']['id']) {
            okinfo($_M['url']['user_home']);
        }

        // 如果从其他页面过来
        if (isset($_SERVER['HTTP_REFERER'])) {
            // 是否从本站过来
            $referer = parse_url($_SERVER['HTTP_REFERER']);
            if ($referer['host'] == $_SERVER['HTTP_HOST']) {
                // 来源页面保存到cookie
                setcookie("referer", $_SERVER['HTTP_REFERER']);
            }
        }

        if (isset($_M['form']['gourl']) && $_M['form']['gourl']) {
            setcookie("referer", base64_decode($_M['form']['gourl']));
        }

        if ($session->get("logineorrorlength") > 3) $_M['code'] = 1;

        $this->view('app/login', $this->input);
    }

    public function dologin()
    {
        global $_M;
        $this->login($_M['form']['username'], $_M['form']['password'], '');
    }

    public function login($username, $password, $type = 'pass')
    {
        global $_M;
        $session = load::sys_class('session', 'new');
        $paygroup = load::mod_class('user/sys_group', 'new');

        if ($session->get("logineorrorlength") > 3) {
            if (!load::sys_class('pin', 'new')->check_pin($_M['form']['code'])) {
                okinfo($_M['url']['user_home'], $_M['word']['membercode']);
            }
        }
        $user = $this->userclass->login_by_password($username, $password, $type);
        if ($user) {
            if (!$user['valid']) {
                okinfo($_M['url']['login'], $_M['word']['membererror6']);
            }

            $session->del('logineorrorlength');
            $this->userclass->set_login_record($user);
            // 如果有来源页面,登录之后跳回原来页面 否则跳到个人中心
            if (isset($_COOKIE['referer']) && !strstr($_COOKIE['referer'], 'member/login') && !strstr($_COOKIE['referer'], 'getpassword')) {
                $referer = $_COOKIE['referer'];
                if (strstr($referer, '/member/register_include.php')) {
                    okinfo($_M['url']['user_home']);
                }
                // 删除cookie保存的来源地址

                setcookie("referer");
                okinfo($referer);

            } else {
                okinfo($_M['url']['user_home']);
            }

        } else {
            $length = $session->get("logineorrorlength");
            $length++;
            $session->set("logineorrorlength", $length);
            okinfo($_M['url']['login'], $_M['word']['membererror1']);
        }
    }


	public function dologout() {
		global $_M;
		$this->userclass->logout();
		okinfo($_M['url']['login']);
	}

	public function doother() {
		global $_M;
		$other = $this->other($_M['form']['type']);
		$other->set_state();
		$url = $other->get_login_url();
		okinfo($url);
	}

	public function doother_login() {
		global $_M;
		$type = $_M['form']['amp;type'] ? $_M['form']['amp;type'] : $_M['form']['type'];
		$other = $this->other($type);
		$user = $other->get_user($_M['form']['code']);

		if(!$other->state_ok($_M['form']['state'])){
			okinfo($_M['url']['login'], $_M['word']['membererror2']);
		}
		if($user){
			if($user['register'] == 'no'){
				okinfo($_M['url']['login_other_register'].'&other_id='.$user['other_id'].'&type='.$user['other_type']);
			}
		}else{
			okinfo($_M['url']['login'], $other->errorno);
		}
		if($user){
			$this->login($user['username'], md5($user['password']), 'md5');
		}else{
			okinfo($_M['url']['login'], $_M['word']['membererror3']);
		}
	}

	public function dologin_other_register() {
		global $_M;
		$other = $this->other($_M['form']['type']);
		$met_id = $other->register($_M['form']['other_id'], $_M['form']['username']);
		if($met_id){
			$user = $this->userclass->get_user_by_id($met_id);
			$this->login($user['username'], md5($user['password']), 'md5');
		}else{
			if($other->errorno == 're_username'){
				okinfo($_M['url']['login_other_info']."&other_id={$_M['form']['other_id']}&type={$_M['form']['type']}");
			}else{
				okinfo($_M['url']['login'], $other->errorno);
			}
		}
	}

	public function other($type) {
		global $_M;
		if(!$type){
			okinfo($_M['url']['login'], $_M['word']['membererror4']);
		}
		if($type == 'qq'){
			$other = load::mod_class('user/web/class/qq', 'new');
		}
		if($type == 'weibo'){
			$other = load::mod_class('user/web/class/weibo', 'new');
		}
		if($type == 'weixin'){
			$other = load::mod_class('user/web/class/weixin', 'new');
		}
		return $other;
	}

	public function dologin_other_info(){
		global $_M;
		$this->view('app/other_info',$this->input);
		#require_once $this->view('app/other_info',$this->input);
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
