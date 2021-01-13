<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

/** 会员列表 */
class admin_user extends admin
{
    public $module;
    public $userclass;
    public $group;

    public function __construct()
    {
        parent::__construct();
        global $_M;
        $this->module = 10;
        $this->userclass = load::sys_class('user', 'new');
        $this->group = load::sys_class('group', 'new');
    }

    //获取会员列表
    public function doGetUserList()
    {
        global $_M;
        $groupid = isset($_M['form']['groupid']) ? $_M['form']['groupid'] : '';
        $keyword = isset($_M['form']['keyword']) ? $_M['form']['keyword'] : '';
        $idvalid = isset($_M['form']['idvalid']) ? $_M['form']['idvalid'] : '';

        //获取用户组
        $user_group = array();
        $group = DB::get_all("SELECT id,name FROM {$_M['table']['user_group']} WHERE lang = '{$_M['lang']}'");
        foreach ($group as $key => $val) {
            $user_group[$val['id']] = $val['name'];
        }

        $search = $groupid ? " and groupid = '{$groupid}'" : '';
        //是否实名认证
        $search .= $idvalid ? ($idvalid == 1 ? " and idvalid = '1'" : " and (idvalid is null or idvalid = 0)") : '';
        $search .= $keyword ? " and (username like '%{$keyword}%' || email like '%{$keyword}%' || tel like '%{$keyword}%')" : '';

        $table = load::sys_class('tabledata', 'new');
        $order = "login_time DESC,register_time DESC";
        $where = "lang='{$_M['lang']}' {$search}";
        $userlist = $table->getdata($_M['table']['user'], '*', $where, $order);

        foreach ($userlist as $key => $value) {
            switch ($value['source']) {
                case 'weixin':
                    $value['source'] = $_M['word']['weixinlogin'];
                    break;
                case 'weibo':
                    $value['source'] = $_M['word']['sinalogin'];
                    break;
                case 'qq':
                    $value['source'] = $_M['word']['qqlogin'];
                    break;
                default:
                    $value['source'] = $_M['word']['registration'];
                    break;
            }
            $value['idvalid'] = $value['idvalid'] ? $value['idvalid'] : 0;
            $value['register_time'] = timeFormat($value['register_time']);
            $value['login_time'] = timeFormat($value['login_time']);
            $value['groupid'] = $user_group[$value['groupid']];
            if (!$value['login_time']) {
                $value['login_time'] = $value['register_time'];
            }
            $user_data[$key] = $value;
        }

        $table->rdata($user_data);
    }

    //添加会员
    public function doAddUser()
    {
        global $_M;
        $username = isset($_M['form']['username']) ? $_M['form']['username'] : '';
        $password = isset($_M['form']['password']) ? $_M['form']['password'] : '';
        $valid = isset($_M['form']['valid']) ? $_M['form']['valid'] : '';
        $groupid = isset($_M['form']['groupid']) ? $_M['form']['groupid'] : '';
        if ($this->userclass->register($username, $password, '', '', '', $valid, $groupid)) {
            //写日志
            logs::addAdminLog('memberist','memberAdd','jsok','doAddUser');
            $this->success('',$_M['word']['jsok']);
        }
        //写日志
        logs::addAdminLog('memberist','memberAdd','jsx10','doAddUser');
        $this->error($_M['word']['jsx10']);
    }

    //获取会员信息
    public function doGetUserInfo()
    {
        global $_M;

        $id = isset($_M['form']['id']) ? $_M['form']['id'] : '';
        if (!$id) {
            $this->error();
        }
        $user = $this->userclass->get_user_by_id($id);
        unset($user['password']);
        $para_list = load::sys_class('para', 'new')->get_para_list(10);
        foreach ($para_list as $key => $para) {
            $query = "SELECT info FROM {$_M['table']['user_list']} WHERE listid = {$id} AND paraid={$para['id']} AND lang = '{$_M['lang']}'";
            $user_info = DB::get_one($query);
            $values = $user_info['info'];
            $para_list[$key]['value'] = $values;
        }

        $user['user_para'] = $para_list;

        $this->success($user);
    }

    //保存会员信息
    public function doSaveUser()
    {
        global $_M;
        $id         = isset($_M['form']['id']) ? $_M['form']['id'] : '';
        $password   = isset($_M['form']['password']) ? $_M['form']['password'] : '';
        $email      = isset($_M['form']['email']) ? $_M['form']['email'] : '';
        $tel        = isset($_M['form']['tel']) ? $_M['form']['tel'] : '';
        $valid      = isset($_M['form']['valid']) ? $_M['form']['valid'] : '';
        $groupid    = isset($_M['form']['groupid']) ? $_M['form']['groupid'] : '';

        if ($password) {
            if (!$this->userclass->editor_uesr_password($id, $password)) {
                if ($this->userclass->errorno == 'error_password_cha') {
                    $this->error($_M['word']['user_tips4_v6']);
                }
            }
        }
        $this->userclass->editor_uesr($id, $email, $tel, $valid, $groupid);
        $paraclass = load::sys_class('para', 'new');
        $para_list = $paraclass->get_para_list(10);
        $info = array();
        foreach ($para_list as $val) {
            if (isset($_M['form']['info_' . $val['id']])){
                $info[$val['id']] = $_M['form']['info_' . $val['id']];
            }
        }

        $paraclass->update_para($id, $info, 10);

        $this->success('',$_M['word']['jsok']);
    }

    //删除会员
    public function doDelUser()
    {
        global $_M;
        if (!isset($_M['form']['id']) || !$_M['form']['id'] || !is_array($_M['form']['id'])){
            $this->error();
        }
        $id = $_M['form']['id'];

        foreach ($id as $value) {
            $query = "DELETE FROM {$_M['table']['user']} WHERE id='{$value}'";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['user_other']} WHERE met_uid='{$value}'";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['user_list']} WHERE listid='{$value}'";
            DB::query($query);
        }
        //写日志
        logs::addAdminLog('memberist','delete','jsx10','doDelUser');
        $this->success('',$_M['word']['jsok']);
    }

    //检查用户名是否可用
    public function doCheckUsername()
    {
        global $_M;
        $username = isset($_M['form']['username']) ? $_M['form']['username'] : '';
        if (!$username){
            $res['message'] = $_M['word']['loginid'];
            $res['valid'] = false;
            $this->ajaxReturn($res);
        }

        if (!$this->userclass->check_str($username)) {
            $res['message'] = $_M['word']['user_tips2_v6'];
            $res['valid'] = false;
            $this->ajaxReturn($res);
        }
        if ($this->userclass->get_user_by_username_sql($username) || $this->userclass->get_admin_by_username_sql($username)) {
            $res['message'] = $_M['word']['user_tips3_v6'];
            $res['valid'] = false;
            $this->ajaxReturn($res);
        }

        $res['message'] = $_M['word']['user_tips1_v6'];
        $res['valid'] = true;
        $this->ajaxReturn($res);
    }

    //检查邮箱是否可用
    public function doCheckEmail()
    {
        global $_M;
        $user = $this->userclass->get_user_by_email($_M['form']['email']);
        if ($user && $user['id'] != $_M['form']['id']) {
            $this->error();
        }

        $this->success();
    }

    //检查电话号码是否可用
    public function doCheckTel()
    {
        global $_M;
        $user = $this->userclass->get_user_by_tel($_M['form']['tel']);
        if ($user && $user['id'] != $_M['form']['id']) {
            $this->error();
        }
        $this->success();
    }


    //导出会员列表
    public function doExportUser()
    {
        global $_M;

        $groupid = isset($_M['form']['groupid']) ? $_M['form']['groupid'] : '';
        $keyword = isset($_M['form']['keyword']) ? $_M['form']['keyword'] : '';
        $search = $groupid ? "and groupid = '{$groupid}'" : '';
        $search .= $keyword ? "and (username like '%{$keyword}%' || email like '%{$keyword}%' || tel like '%{$keyword}%')" : '';

        /*查询表*/
        $query = "SELECT * FROM {$_M['table']['user']} WHERE lang='{$_M['lang']}' {$search} ORDER BY login_time DESC,register_time DESC";  //mysql语句
        $user_data = DB::get_all($query);

        $para_list = load::mod_class('parameter/parameter_op','new')->get_para_list($this->module);
        foreach ($user_data as $key => $val) {
            switch ($val['source']) {
                case 'weixin':
                    $val['source'] = $_M['word']['weixinlogin'];
                    break;
                case 'weibo':
                    $val['source'] = $_M['word']['sinalogin'];
                    break;
                case 'qq':
                    $val['source'] = $_M['word']['qqlogin'];
                    break;
                default:
                    $val['source'] = $_M['word']['register'];
                    break;
            }
            if (!$val['login_time']){
                $val['login_time'] = $val['register_time'];
            }

            $user_group = $this->group->get_group_list();
            foreach ($user_group as $group) {
                if ($val['groupid'] == $group['id']) {
                    $group_name = $group['name'];
                }
            }

            $list = array();
            $list[] = $val['username'];
            $list[] = $group_name;
            $list[] = date('Y-m-d H:i:s', $val['register_time']);
            $list[] = date('Y-m-d H:i:s', $val['login_time']);
            $list[] = $val['login_count'];
            $list[] = $val['valid'] ? $_M['word']['memberChecked'] : $_M['word']['memberUnChecked'];
            $list[] = $val['source'];
            $list[] = $val['email'];
            $list[] = $val['tel'];

            if ($para_list) {
                foreach ($para_list as $vals) {
                    $query = "SELECT info FROM {$_M['table']['user_list']} WHERE listid='{$val['id']}' AND paraid='{$vals['id']}'";
                    $plist =  DB::get_one($query);
                    $list[] = $plist['info'];
                }
            }
            $rarray[] = $list;
        }

        $head = array(
            $_M['word']['loginusename'],
            $_M['word']['membergroup'],
            $_M['word']['membertips1'],
            $_M['word']['lastactive'],
            $_M['word']['adminLoginNum'],
            $_M['word']['memberCheck'],
            $_M['word']['source'],
            $_M['word']['bindingmail'],
            $_M['word']['bindingmobile']
        );
        if ($para_list) {
            foreach ($para_list as $val) {
                $head[] = $val['name'];
            }
        }


        $filename = "USER_" . date('Y-m-d', time()) . "_ACCLOG";
        $csv = load::sys_class('csv', 'new');
        $csv->get_csv($filename, $rarray, $head);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>