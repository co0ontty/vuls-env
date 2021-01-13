<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

class index extends admin
{

    public function __construct()
    {
        global $_M;
        $this->moduleObj = load::mod_class('myapp/class/myapp', 'new');

        parent::__construct();
    }

    public function doIndex()
    {
        global $_M;
        
        // $this->moduleObj->getUserInfo();
        $data = $this->moduleObj->listApp();

        $this->success($data);
    }

    public function doAction()
    {
        global $_M;
        $data = array();
        $data['name'] = $_M['form']['m_name'];
        $data['appno'] = $_M['form']['no'];
        $handle = $_M['form']['handle'];
        $res = $this->moduleObj->$handle($data);

        if($res){
            $this->success(array(),$_M['word']['jsok']);
        }else{
            $this->error($_M['word']['opfailed']);
        }
    }

    public function doAppList()
    {
        global $_M;
        $type = $_M['form']['type'] ? $_M['form']['type'] : 'free';
        echo $this->moduleObj->appList($type);die;
    }

    public function doLogin()
    {
        global $_M;
        $data = array();
        $data['username'] = $_M['form']['username'];
        $data['password'] = $_M['form']['password'];
        $res = $this->moduleObj->login($data);
        if($res){
            //写日志
            logs::addAdminLog('myapp','loginconfirm','jsok','doLogin');
            $this->success($res['data'],$res['msg']);
        }else{
            //写日志
            logs::addAdminLog('myapp','loginconfirm','opfailed','doLogin');
            $this->error($_M['word']['opfailed']);
        }
    }

    public function doLogout()
    {
        global $_M;
        $res = $this->moduleObj->getUserInfo('logout');
        if($res){
            //写日志
            logs::addAdminLog('myapp','indexloginout','jsok','doLogout');
            $this->success($res['data'],$res['msg']);
        }else{
            //写日志
            logs::addAdminLog('myapp','indexloginout','opfailed','doLogout');
            $this->error($_M['word']['opfailed']);
        }
    }

    public function doUserInfo()
    {
        global $_M;
        $res = $this->moduleObj->getUserInfo();
        if($res){
            $this->success($res['data'],$res['msg']);
        }else{
            $this->error($_M['word']['opfailed']);
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
