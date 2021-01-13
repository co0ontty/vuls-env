<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 
defined('IN_MET') or exit('No permission');
load::sys_func('file');
class uninstall extends admin{

    public $appno;
    public $appdir;

    public function __construct()
    {
        $this->appno = 10070;
        $this->appname = 'met_sms';

    }

    /**
     * 卸载应用
     */
    public function dodel(){
        global $_M;

        // $del_applist = "DELETE FROM {$_M['table']['applist']} WHERE no = {$this->appno}"; 
       
        // DB::query($del_applist);

        
        // $this->delConfig('met_sms_url'); 
        // $this->delConfig('met_sms_token');
        // deldir(PATH_WEB.$_M['config']['met_adminfile'].'/update/app/'.$this->appno);
        // deldir('../app/app/'.$this->appname);

        turnover("{$_M['url']['own_form']}a=doindex","系统应用，无法卸载");
    }

    public function delConfig($name) {
        global $_M;
        $query = "DELETE FROM {$_M['table']['config']} WHERE name = '{$name}'";
        DB::query($query);
    }
}
?>