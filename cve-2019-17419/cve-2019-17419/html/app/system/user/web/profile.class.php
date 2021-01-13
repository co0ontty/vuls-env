<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('user/web/class/userweb');

class profile extends userweb {

	protected $paraclass;
	protected $paralist;
	protected $no;

	public function __construct() {
		global $_M;
        parent::__construct();
        $this->paraclass = load::sys_class('para', 'new');
        $this->paralist  = $this->paraclass->get_para_list(10,$this->input['classnow']);
        $this->sys_group  = load::mod_class('user/sys_group', 'new');
        $this->paygroup_list  = $this->sys_group->get_paygroup_list_buyok();
    }


	/*未激活账户重发邮件验证*/
	public function dovalid_email() {
		global $_M;
		$valid = load::mod_class('user/web/class/valid','new');
		if ($valid->get_email($_M['user']['username'])) {
			$this->ajax_success($_M['word']['emailsuc']);
		} else {
			$this->ajax_error($_M['word']['emailfail']);
		}
	}

	/*基本信息*/

	public function doindex() {
		global $_M;
		$_M['config']['own_order'] = 1;
		if(!$_M['user']['valid']){
			$valid = $_M['config']['met_member_vecan'] == 1?'valid_email':'valid_admin';
			require_once $this->view('app/'.$valid,$this->input);
		}else{
			$_M['paralist']=$this->paralist;
			$_M['paraclass']=$this->paraclass;

            $paygroupnow = $this->sys_group->get_paygroup_by_id($_M['user']['groupid']);
            foreach ($this->paygroup_list as $pgroup) {
                if ($pgroup['price']> $paygroupnow['price']) {
                    $groupshow[] = $pgroup;
                }
            }
			$this->input['groupshow'] = $groupshow;
			require_once $this->view('app/profile_index',$this->input);
		}
	}

	public function doinfosave() {
		global $_M;
		$infos = $this->paraclass->form_para($_M['form'],10,$this->input['classnow']);
		$this->paraclass->update_para($_M['user']['id'], $infos, 10);
		$this->userclass->modify_head($_M['user']['id'], $_M['form']['head']);
		okinfo($_M['url']['profile'], $_M['word']['modifysuc']);
	}

	/*帐号安全*/
	public function dosafety() {
		global $_M;
		$_M['config']['own_order'] = 2;
		if($_M['user']['email']){
			$_M['profile_safety']['emailtxt'] = $_M['user']['email'];
			$_M['profile_safety']['emailbut'] = $_M['word']['modify'];
			$_M['profile_safety']['emailclass'] = 'emailedit';
		}else{
			$_M['profile_safety']['emailtxt'] = $_M['word']['notbound'];
			$_M['profile_safety']['emailbut'] = $_M['word']['binding'];
			$_M['profile_safety']['emailclass'] = 'emailadd';
		}
		if($_M['user']['tel']){
			$_M['profile_safety']['teltxt'] = $_M['user']['tel'];
			$_M['profile_safety']['telbut'] = $_M['word']['modify'];
			$_M['profile_safety']['telclass'] = 'teledit';
		}else{
			$_M['profile_safety']['teltxt'] = $_M['word']['notbound'];
			$_M['profile_safety']['telbut'] = $_M['word']['binding'];
			$_M['profile_safety']['telclass'] = 'teladd';
		}
        if($_M['user']['idvalid']){
            $_M['profile_safety']['idvalitxt'] = $_M['word']['authen'];
            $_M['profile_safety']['idvalibut'] = $_M['word']['memberDetail'];
            $_M['profile_safety']['idvaliclass'] = 'idvalview';
            $_M['user']['realidinfo']  = $this->userclass->getRealIdInfo($_M['user']);
        }else{
            $_M['profile_safety']['idvalitxt'] = $_M['word']['notauthen'];
            $_M['profile_safety']['idvalibut'] = $_M['word']['binding'];
            $_M['profile_safety']['idvaliclass'] = 'idvaliadd';
        }
		if($_M['config']['met_member_vecan']==1&&$_M['user']['email']&&$_M['user']['email']==$_M['user']['username']){
			$_M['profile_safety']['emailbut'] = $_M['word']['accnotmodify'];
			$_M['profile_safety']['disabled'] = 'disabled';
		}
		require_once $this->view('app/profile_safety',$this->input);
	}

	/*邮箱绑定与修改*/
	public function doemailedit() {
		global $_M;
		if($_M['form']['p']){
			$auth = load::sys_class('auth', 'new');
			$email = $auth->decode($_M['form']['p']);
			if($email&&$email==$_M['user']['email']){
				if($_M['form']['email']){
					$valid = load::mod_class('user/web/class/valid','new');
					if ($valid->get_email($_M['form']['email'],'emailadd')) {
						okinfo($_M['url']['profile_safety'], $_M['word']['emailsuclink']);
					} else {
						okinfo($_M['url']['profile_safety'], $_M['word']['emailfail']);
					}
				}else{
					require_once $this->view('app/profile_emailedit',$this->input);
				}
			}else{
				okinfo($_M['url']['profile_safety'], $_M['word']['emailvildtips2']);
			}
		}else{
			$valid = load::mod_class('user/web/class/valid','new');
			if ($valid->get_email($_M['user']['email'],'emailedit')) {
				$this->ajax_success($_M['word']['emailsuclink']);
			} else {
				$this->ajax_error($_M['word']['emailfail']);
			}
		}
	}

	public function doemailok() {
		global $_M;
		$valid = true;
		if($this->userclass->get_user_by_email($_M['form']['email'])){
			$valid = false;
		}
		echo json_encode(array(
			'valid' => $valid
		));
	}

	public function dosafety_emailadd() {
		global $_M;
        if($_M['form']['p']){
			$auth = load::sys_class('auth', 'new');
			$email = $auth->decode($_M['form']['p']);
            $email = sqlinsert($email);
			if($email){
				if($this->userclass->editor_uesr_email($_M['user']['id'], $email)){
					okinfo($_M['url']['profile_safety'], $_M['word']['bindingok']);
				}else{
					okinfo($_M['url']['profile_safety'], $_M['word']['opfail']);
				}
			}else{
				okinfo($_M['url']['profile_safety'], $_M['word']['emailvildtips2']);
			}
		}else{
			if($this->userclass->get_user_by_email($_M['form']['email'])){
                okinfo($_M['url']['profile_safety'], $_M['word']['emailhave']);
			}
			$valid = load::mod_class('user/web/class/valid','new');
			if ($valid->get_email($_M['form']['email'],'emailadd')) {
				okinfo($_M['url']['profile_safety'], $_M['word']['emailsuclink']);
			} else {
				okinfo($_M['url']['profile_safety'], $_M['word']['emailfail']);
			}
		}
	}

	/*密码修改*/
	public function dopasssave() {
		global $_M;
		if(md5($_M['form']['oldpassword'])==$_M['user']['password']){
			if($this->userclass->editor_uesr_password($_M['user']['id'],$_M['form']['password'])){
				okinfo($_M['url']['profile_safety'], $_M['word']['modifypasswordsuc']);
			}else{
				okinfo($_M['url']['profile_safety'], $_M['word']['opfail']);
			}
		}else{
			okinfo($_M['url']['profile_safety'], $_M['word']['lodpasswordfail']);
		}
	}

	/*手机绑定与修改*/
	public function dosafety_teledit() {
		global $_M;
		if($_M['form']['code']){
			$session = load::sys_class('session', 'new');
			if($_M['form']['code']!=$session->get("phonecode")){
				$this->ajax_error($_M['word']['membercode']);
				die;
			}
			if(time()>$session->get("phonetime")){
				$this->ajax_error($_M['word']['codetimeout']);
				die;
			}
			$session->del('phonecode');
			$session->del('phonetime');
			$session->del('phonetel');
			$this->ajax_success();
		}else{
			$valid = load::mod_class('user/web/class/valid','new');
			if ($valid->get_tel($_M['user']['tel'])) {
				$this->ajax_success();
			} else {
				$this->ajax_error($_M['word']['Sendfrequent']);
			}
		}
	}

	public function dosafety_teladd() {
		global $_M;
		$session = load::sys_class('session', 'new');
		if($_M['form']['phonecode']!=$session->get("phonecode")){
			okinfo($_M['url']['profile_safety'], $_M['word']['membercode']);
		}
		if(time()>$session->get("phonetime")){
			okinfo($_M['url']['profile_safety'], $_M['word']['codetimeout']);
		}
		if($_M['form']['tel']!=$session->get("phonetel")){
			okinfo($_M['url']['profile_safety'], $_M['word']['telcheckfail']);
		}
		$session->del('phonecode');
		$session->del('phonetime');
		$session->del('phonetel');

		if($this->userclass->editor_uesr_tel($_M['user']['id'], $_M['form']['tel'])){
			okinfo($_M['url']['profile_safety'], $_M['word']['bindingok']);
		}else{
			okinfo($_M['url']['profile_safety'], $_M['word']['opfail']);
		}

	}

	public function dosafety_telvalid() {
		global $_M;
		if($this->userclass->get_user_by_tel($_M['form']['tel'])){
			$this->ajax_error($_M['word']['teluse']);
		}
		$valid = load::mod_class('user/web/class/valid','new');
		if ($valid->get_tel($_M['form']['tel'])) {
			$this->ajax_success();
		} else {
			$this->ajax_error($_M['word']['Sendfrequent']);
		}
	}

	public function dosafety_telok() {
		global $_M;
		$valid = true;
		if($this->userclass->get_user_by_tel($_M['form']['tel'])){
			$valid = false;
		}
		echo json_encode(array(
			'valid' => $valid
		));
	}

    /**
     * 用户实名认证
     */
    public function dosafety_idvalid(){
        global $_M;
        if(!load::sys_class('pin', 'new')->check_pin($_M['form']['code']) ){
            okinfo($_M['url']['profile_safety'], $_M['word']['membercode']);
            die();
        }
        $idvalid = load::mod_class('user/include/class/user_idvalid.class.php', 'new');
        $result = $idvalid->idvalidate();
        if (!$result) {
            okinfo($_M['url']['profile_safety'], $_M['word']['idvalidfailed']);
            die();
        }

        $info = $_M['form']['realname']."|".$_M['form']['idcode']."|".$_M['form']['phone'];
        if($this->userclass->editor_uesr_idvalid($_M['user']['id'],$info)){
            okinfo($_M['url']['profile_safety'], $_M['word']['idvalidok']);
            die();
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>