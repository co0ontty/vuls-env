<?php
defined('IN_MET') or exit ('No permission');
load::sys_class('admin');
class install{

    public $appno = 10070;
    public $ver = '1.4';
    public $appname = 'met_sms';
    public $apptitle= '短信功能';
    public $description = '可以用于系统通知、短信注册、批量发送';

    /*public function __construct() {
        global $_M;
        parent::__construct();
    }*/

     /**
     * 注册应用
     * @return [type]
     */
    public function dosql() {

        global $_M;
        $hasapp = DB::get_one("SELECT * FROM {$_M['table']['applist']} WHERE no = '{$this->appno}'");

        if($hasapp) {

           $this->update();

        } else {

            $time = time();
            $query = "INSERT INTO `{$_M['table']['applist']}` SET
                    `id`        =  '',
                    `no`        =  '{$this->appno}',
                    `ver`       =  '{$this->ver}',
                    `m_name`    =  '{$this->appname}',
                    `m_class`   =  'index',
                    `m_action`  =  'doindex',
                    `appname`   =  '{$this->apptitle}',
                    `info`      =  '{$this->description}',
                    `addtime`   =  {$time},
                    `updatetime`=  {$time}";
            DB::query($query);

        }

        $this->addConfig('met_sms_url','https://u.mituo.cn/api/sms');
        $this->addConfig('met_sms_token','');

    }

    /**
     * 如果存在app 只对版本号做更新
     * @param  [type] $ver 版本号
     * @return [type]
     */
    public function update() {

        global $_M;

        DB::query("UPDATE {$_M['table']['applist']} SET ver = '{$this->ver}' WHERE no = '{$this->appno}'");
        $query = "UPDATE {$_M['table']['config']} SET value = 'https://u.mituo.cn/api/sms' WHERE name = 'met_sms_url'";
        DB::query($query);

    }

    public function addConfig($name,$value)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['config']} WHERE  name='{$name}'";
        if(!DB::get_one($query))
        {
            $query = "INSERT INTO {$_M['table']['config']} (name,value,mobile_value,columnid,flashid,lang)VALUES ('{$name}', '{$value}', '', '0', '0', 'metinfo')";
            DB::query($query);
        }
    }


     /**
     * 卸载应用
     */
    public function dodel(){
        global $_M;

        $del_applist = "DELETE FROM {$_M['table']['applist']} WHERE no = {$this->appno}";

        DB::query($del_applist);
        deldir(PATH_WEB.$_M['config']['met_adminfile'].'/update/app/'.$this->appno);
        deldir('../app/app/'.$this->appname);
    }

    public function delConfig($name) {
        global $_M;
        $query = "DELETE FROM {$_M['table']['config']} WHERE name = '{$name}'";
        DB::query($query);
    }

}